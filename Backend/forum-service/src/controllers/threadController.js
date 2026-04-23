const ThreadModel = require('../models/threadModel');
const CategoryModel = require('../models/categoryModel');
const LikeModel = require('../models/likeModel');
const { generateUniqueSlug } = require('../services/slugService');
const { emitRealtimeEvent } = require('../services/notificationClient');

class ThreadController {
  /**
   * GET /api/forum/threads
   * Public - list threads dengan filter
   */
  static async getAll(req, res) {
    try {
      const { category, categoryId, search, page, limit, sortBy, userId } = req.query;

      let finalCategoryId = categoryId;
      if (category && !categoryId) {
        const cat = await CategoryModel.findBySlug(category);
        if (cat) finalCategoryId = cat.id;
      }

      const result = await ThreadModel.findAll({
        categoryId: finalCategoryId,
        userId,
        search,
        page: page || 1,
        limit: limit || 10,
        sortBy: sortBy || 'last_activity_at'
      });

      return res.json({ success: true, ...result });
    } catch (err) {
      console.error('[Thread] getAll error:', err);
      return res.status(500).json({ success: false, message: err.message });
    }
  }

  /**
   * GET /api/forum/threads/:id
   * Public - detail thread + increment view
   */
  static async getById(req, res) {
    try {
      const { id } = req.params;
      const thread = await ThreadModel.findById(id);

      if (!thread) {
        return res.status(404).json({ success: false, message: 'Thread tidak ditemukan' });
      }

      // Increment view count (async, no await to save time)
      ThreadModel.incrementView(id).catch(() => {});

      // Cek apakah user sudah like thread ini
      let hasLiked = false;
      if (req.user) {
        hasLiked = await LikeModel.hasLiked({
          userId: req.user.id,
          targetType: 'thread',
          targetId: id
        });
      }

      return res.json({
        success: true,
        data: { ...thread, has_liked: hasLiked }
      });
    } catch (err) {
      return res.status(500).json({ success: false, message: err.message });
    }
  }

  /**
   * POST /api/forum/threads
   * Protected - buat thread baru
   */
  static async create(req, res) {
    try {
      const { categoryId, title, content } = req.body;
      const userId = req.user.id;

      if (!categoryId || !title || !content) {
        return res.status(400).json({
          success: false,
          message: 'categoryId, title, dan content wajib diisi'
        });
      }

      if (title.length < 5 || title.length > 255) {
        return res.status(400).json({
          success: false,
          message: 'Judul harus antara 5-255 karakter'
        });
      }

      if (content.length < 10) {
        return res.status(400).json({
          success: false,
          message: 'Konten minimal 10 karakter'
        });
      }

      const category = await CategoryModel.findById(categoryId);
      if (!category) {
        return res.status(404).json({ success: false, message: 'Kategori tidak ditemukan' });
      }

      const slug = generateUniqueSlug(title);
      const thread = await ThreadModel.create({ categoryId, userId, title, slug, content });
      await CategoryModel.incrementThreadCount(categoryId);

      // Broadcast event realtime
      emitRealtimeEvent({
        room: `forum-category-${categoryId}`,
        event: 'new-thread',
        payload: { threadId: thread.id, title, categoryId }
      });

      return res.status(201).json({ success: true, data: thread });
    } catch (err) {
      console.error('[Thread] create error:', err);
      return res.status(500).json({ success: false, message: err.message });
    }
  }

  /**
   * PUT /api/forum/threads/:id
   * Protected - hanya pemilik atau admin
   */
  static async update(req, res) {
    try {
      const { id } = req.params;
      const { title, content, categoryId } = req.body;

      const thread = await ThreadModel.findById(id);
      if (!thread) {
        return res.status(404).json({ success: false, message: 'Thread tidak ditemukan' });
      }

      // Cek otorisasi: pemilik atau admin
      if (thread.user_id !== req.user.id && req.user.role !== 'admin') {
        return res.status(403).json({ success: false, message: 'Anda tidak berhak mengedit thread ini' });
      }

      if (thread.is_locked && req.user.role !== 'admin') {
        return res.status(403).json({ success: false, message: 'Thread ini sudah dikunci' });
      }

      const newTitle = title || thread.title;
      const newSlug = title && title !== thread.title
        ? generateUniqueSlug(title)
        : thread.slug;

      const updated = await ThreadModel.update(id, {
        title: newTitle,
        slug: newSlug,
        content: content || thread.content,
        categoryId: categoryId || thread.category_id
      });

      return res.json({ success: true, data: updated });
    } catch (err) {
      return res.status(500).json({ success: false, message: err.message });
    }
  }

  /**
   * DELETE /api/forum/threads/:id
   * Protected - pemilik atau admin
   */
  static async delete(req, res) {
    try {
      const { id } = req.params;
      const thread = await ThreadModel.findById(id);

      if (!thread) {
        return res.status(404).json({ success: false, message: 'Thread tidak ditemukan' });
      }

      if (thread.user_id !== req.user.id && req.user.role !== 'admin') {
        return res.status(403).json({ success: false, message: 'Anda tidak berhak menghapus thread ini' });
      }

      await ThreadModel.softDelete(id);
      await CategoryModel.decrementThreadCount(thread.category_id);

      return res.json({ success: true, message: 'Thread berhasil dihapus' });
    } catch (err) {
      return res.status(500).json({ success: false, message: err.message });
    }
  }

  /**
   * POST /api/forum/threads/:id/like
   * Toggle like thread
   */
  static async toggleLike(req, res) {
    try {
      const { id } = req.params;
      const userId = req.user.id;

      const thread = await ThreadModel.findById(id);
      if (!thread) {
        return res.status(404).json({ success: false, message: 'Thread tidak ditemukan' });
      }

      const result = await LikeModel.toggle({ userId, targetType: 'thread', targetId: id });
      await ThreadModel.updateLikeCount(id, result.delta);

      return res.json({ success: true, data: result });
    } catch (err) {
      return res.status(500).json({ success: false, message: err.message });
    }
  }

  /**
   * PATCH /api/forum/threads/:id/pin
   * Admin only - pin/unpin thread
   */
  static async togglePin(req, res) {
    try {
      const { id } = req.params;
      const thread = await ThreadModel.findById(id);
      if (!thread) {
        return res.status(404).json({ success: false, message: 'Thread tidak ditemukan' });
      }
      await ThreadModel.togglePin(id, !thread.is_pinned);
      return res.json({ success: true, message: thread.is_pinned ? 'Thread di-unpin' : 'Thread di-pin' });
    } catch (err) {
      return res.status(500).json({ success: false, message: err.message });
    }
  }

  /**
   * PATCH /api/forum/threads/:id/lock
   * Admin/mentor only - lock/unlock thread
   */
  static async toggleLock(req, res) {
    try {
      const { id } = req.params;
      const thread = await ThreadModel.findById(id);
      if (!thread) {
        return res.status(404).json({ success: false, message: 'Thread tidak ditemukan' });
      }
      await ThreadModel.toggleLock(id, !thread.is_locked);
      return res.json({ success: true, message: thread.is_locked ? 'Thread di-unlock' : 'Thread di-lock' });
    } catch (err) {
      return res.status(500).json({ success: false, message: err.message });
    }
  }
}

module.exports = ThreadController;
