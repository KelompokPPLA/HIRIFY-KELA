const ReplyModel = require('../models/replyModel');
const ThreadModel = require('../models/threadModel');
const LikeModel = require('../models/likeModel');
const { sendNotification, emitRealtimeEvent } = require('../services/notificationClient');

class ReplyController {
  /**
   * GET /api/forum/threads/:threadId/replies
   */
  static async getByThread(req, res) {
    try {
      const { threadId } = req.params;
      const { page, limit } = req.query;

      const result = await ReplyModel.findByThread(threadId, {
        page: page || 1,
        limit: limit || 20
      });

      return res.json({ success: true, ...result });
    } catch (err) {
      return res.status(500).json({ success: false, message: err.message });
    }
  }

  /**
   * POST /api/forum/threads/:threadId/replies
   * Protected
   */
  static async create(req, res) {
    try {
      const { threadId } = req.params;
      const { content, parentReplyId } = req.body;
      const userId = req.user.id;

      if (!content || content.trim().length < 1) {
        return res.status(400).json({ success: false, message: 'Konten reply wajib diisi' });
      }

      const thread = await ThreadModel.findById(threadId);
      if (!thread) {
        return res.status(404).json({ success: false, message: 'Thread tidak ditemukan' });
      }

      if (thread.is_locked) {
        return res.status(403).json({ success: false, message: 'Thread ini sudah dikunci, tidak bisa reply' });
      }

      // Validasi parent reply jika ada
      if (parentReplyId) {
        const parent = await ReplyModel.findById(parentReplyId);
        if (!parent || parent.thread_id !== parseInt(threadId)) {
          return res.status(400).json({ success: false, message: 'Parent reply tidak valid' });
        }
      }

      const reply = await ReplyModel.create({ threadId, userId, content, parentReplyId });
      await ThreadModel.incrementReplyCount(threadId);

      // Kirim notifikasi ke pemilik thread (jika bukan dia sendiri yang reply)
      if (thread.user_id !== userId) {
        sendNotification({
          userId: thread.user_id,
          type: 'forum_reply',
          title: 'Thread Anda mendapat balasan baru',
          message: `Seseorang membalas thread "${thread.title}"`,
          link: `/forum/thread/${threadId}`
        });
      }

      // Broadcast event realtime ke room thread
      emitRealtimeEvent({
        room: `forum-thread-${threadId}`,
        event: 'new-reply',
        payload: { threadId, reply }
      });

      return res.status(201).json({ success: true, data: reply });
    } catch (err) {
      console.error('[Reply] create error:', err);
      return res.status(500).json({ success: false, message: err.message });
    }
  }

  /**
   * PUT /api/forum/replies/:id
   */
  static async update(req, res) {
    try {
      const { id } = req.params;
      const { content } = req.body;

      const reply = await ReplyModel.findById(id);
      if (!reply) {
        return res.status(404).json({ success: false, message: 'Reply tidak ditemukan' });
      }

      if (reply.user_id !== req.user.id && req.user.role !== 'admin') {
        return res.status(403).json({ success: false, message: 'Anda tidak berhak mengedit reply ini' });
      }

      const updated = await ReplyModel.update(id, { content });
      return res.json({ success: true, data: updated });
    } catch (err) {
      return res.status(500).json({ success: false, message: err.message });
    }
  }

  /**
   * DELETE /api/forum/replies/:id
   */
  static async delete(req, res) {
    try {
      const { id } = req.params;
      const reply = await ReplyModel.findById(id);

      if (!reply) {
        return res.status(404).json({ success: false, message: 'Reply tidak ditemukan' });
      }

      if (reply.user_id !== req.user.id && req.user.role !== 'admin') {
        return res.status(403).json({ success: false, message: 'Anda tidak berhak menghapus reply ini' });
      }

      await ReplyModel.softDelete(id);
      await ThreadModel.decrementReplyCount(reply.thread_id);

      return res.json({ success: true, message: 'Reply berhasil dihapus' });
    } catch (err) {
      return res.status(500).json({ success: false, message: err.message });
    }
  }

  /**
   * POST /api/forum/replies/:id/like
   */
  static async toggleLike(req, res) {
    try {
      const { id } = req.params;
      const userId = req.user.id;

      const reply = await ReplyModel.findById(id);
      if (!reply) {
        return res.status(404).json({ success: false, message: 'Reply tidak ditemukan' });
      }

      const result = await LikeModel.toggle({ userId, targetType: 'reply', targetId: id });
      await ReplyModel.updateLikeCount(id, result.delta);

      return res.json({ success: true, data: result });
    } catch (err) {
      return res.status(500).json({ success: false, message: err.message });
    }
  }

  /**
   * PATCH /api/forum/replies/:id/solution
   * Hanya pemilik thread atau admin yang bisa mark solution
   */
  static async markSolution(req, res) {
    try {
      const { id } = req.params;
      const reply = await ReplyModel.findById(id);

      if (!reply) {
        return res.status(404).json({ success: false, message: 'Reply tidak ditemukan' });
      }

      const thread = await ThreadModel.findById(reply.thread_id);
      if (thread.user_id !== req.user.id && req.user.role !== 'admin') {
        return res.status(403).json({
          success: false,
          message: 'Hanya pemilik thread yang bisa menandai solusi'
        });
      }

      const updated = await ReplyModel.markAsSolution(id, reply.thread_id);

      // Notifikasi ke pemilik reply
      if (reply.user_id !== req.user.id) {
        sendNotification({
          userId: reply.user_id,
          type: 'forum_solution',
          title: 'Jawaban Anda dipilih sebagai solusi!',
          message: `Jawaban Anda di thread "${thread.title}" ditandai sebagai solusi`,
          link: `/forum/thread/${reply.thread_id}`
        });
      }

      return res.json({ success: true, data: updated });
    } catch (err) {
      return res.status(500).json({ success: false, message: err.message });
    }
  }
}

module.exports = ReplyController;
