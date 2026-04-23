const db = require('../config/database');

class ReplyModel {
  /**
   * Get semua reply untuk sebuah thread
   */
  static async findByThread(threadId, { page = 1, limit = 20 }) {
    const offset = (page - 1) * limit;

    const [rows] = await db.query(
      `SELECT
         r.*,
         u.email AS author_email,
         p.first_name AS author_first_name,
         p.last_name AS author_last_name
       FROM forum_replies r
       LEFT JOIN users u ON r.user_id = u.id
       LEFT JOIN profiles p ON r.user_id = p.user_id
       WHERE r.thread_id = ? AND r.is_deleted = FALSE
       ORDER BY r.created_at ASC
       LIMIT ? OFFSET ?`,
      [threadId, parseInt(limit), parseInt(offset)]
    );

    const [countResult] = await db.query(
      'SELECT COUNT(*) AS total FROM forum_replies WHERE thread_id = ? AND is_deleted = FALSE',
      [threadId]
    );

    return {
      replies: rows,
      total: countResult[0].total,
      page: parseInt(page),
      limit: parseInt(limit),
      totalPages: Math.ceil(countResult[0].total / limit)
    };
  }

  static async findById(id) {
    const [rows] = await db.query(
      `SELECT r.*, u.email AS author_email
       FROM forum_replies r
       LEFT JOIN users u ON r.user_id = u.id
       WHERE r.id = ? AND r.is_deleted = FALSE`,
      [id]
    );
    return rows[0] || null;
  }

  static async create({ threadId, userId, content, parentReplyId = null }) {
    const [result] = await db.query(
      `INSERT INTO forum_replies (thread_id, user_id, content, parent_reply_id)
       VALUES (?, ?, ?, ?)`,
      [threadId, userId, content, parentReplyId]
    );
    return this.findById(result.insertId);
  }

  static async update(id, { content }) {
    await db.query(
      'UPDATE forum_replies SET content = ? WHERE id = ?',
      [content, id]
    );
    return this.findById(id);
  }

  static async softDelete(id) {
    const [result] = await db.query(
      'UPDATE forum_replies SET is_deleted = TRUE WHERE id = ?',
      [id]
    );
    return result.affectedRows > 0;
  }

  static async markAsSolution(id, threadId) {
    // Unmark solusi lain di thread yang sama
    await db.query(
      'UPDATE forum_replies SET is_solution = FALSE WHERE thread_id = ?',
      [threadId]
    );
    // Mark yang ini sebagai solusi
    await db.query(
      'UPDATE forum_replies SET is_solution = TRUE WHERE id = ?',
      [id]
    );
    return this.findById(id);
  }

  static async updateLikeCount(id, delta) {
    await db.query(
      'UPDATE forum_replies SET like_count = GREATEST(like_count + ?, 0) WHERE id = ?',
      [delta, id]
    );
  }
}

module.exports = ReplyModel;
