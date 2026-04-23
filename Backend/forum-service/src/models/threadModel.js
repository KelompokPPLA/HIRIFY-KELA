const db = require('../config/database');

class ThreadModel {
  /**
   * Get all threads dengan filter dan pagination
   */
  static async findAll({ categoryId, userId, search, page = 1, limit = 10, sortBy = 'last_activity_at' }) {
    const offset = (page - 1) * limit;
    const params = [];
    let whereClause = 'WHERE t.is_deleted = FALSE';

    if (categoryId) {
      whereClause += ' AND t.category_id = ?';
      params.push(categoryId);
    }

    if (userId) {
      whereClause += ' AND t.user_id = ?';
      params.push(userId);
    }

    if (search) {
      whereClause += ' AND MATCH(t.title, t.content) AGAINST(? IN NATURAL LANGUAGE MODE)';
      params.push(search);
    }

    const allowedSort = ['last_activity_at', 'created_at', 'view_count', 'like_count', 'reply_count'];
    const sortColumn = allowedSort.includes(sortBy) ? sortBy : 'last_activity_at';

    const query = `
      SELECT
        t.*,
        c.name AS category_name,
        c.slug AS category_slug,
        c.icon AS category_icon,
        u.email AS author_email,
        p.first_name AS author_first_name,
        p.last_name AS author_last_name
      FROM forum_threads t
      LEFT JOIN forum_categories c ON t.category_id = c.id
      LEFT JOIN users u ON t.user_id = u.id
      LEFT JOIN profiles p ON t.user_id = p.user_id
      ${whereClause}
      ORDER BY t.is_pinned DESC, t.${sortColumn} DESC
      LIMIT ? OFFSET ?
    `;

    params.push(parseInt(limit), parseInt(offset));
    const [rows] = await db.query(query, params);

    // Count total
    const countQuery = `
      SELECT COUNT(*) AS total FROM forum_threads t ${whereClause}
    `;
    const countParams = params.slice(0, -2);
    const [countResult] = await db.query(countQuery, countParams);

    return {
      threads: rows,
      total: countResult[0].total,
      page: parseInt(page),
      limit: parseInt(limit),
      totalPages: Math.ceil(countResult[0].total / limit)
    };
  }

  static async findById(id) {
    const [rows] = await db.query(
      `SELECT
         t.*,
         c.name AS category_name,
         c.slug AS category_slug,
         u.email AS author_email,
         p.first_name AS author_first_name,
         p.last_name AS author_last_name
       FROM forum_threads t
       LEFT JOIN forum_categories c ON t.category_id = c.id
       LEFT JOIN users u ON t.user_id = u.id
       LEFT JOIN profiles p ON t.user_id = p.user_id
       WHERE t.id = ? AND t.is_deleted = FALSE`,
      [id]
    );
    return rows[0] || null;
  }

  static async findBySlug(slug) {
    const [rows] = await db.query(
      `SELECT t.*, c.name AS category_name, u.email AS author_email
       FROM forum_threads t
       LEFT JOIN forum_categories c ON t.category_id = c.id
       LEFT JOIN users u ON t.user_id = u.id
       WHERE t.slug = ? AND t.is_deleted = FALSE`,
      [slug]
    );
    return rows[0] || null;
  }

  static async create({ categoryId, userId, title, slug, content }) {
    const [result] = await db.query(
      `INSERT INTO forum_threads (category_id, user_id, title, slug, content)
       VALUES (?, ?, ?, ?, ?)`,
      [categoryId, userId, title, slug, content]
    );
    return this.findById(result.insertId);
  }

  static async update(id, { title, slug, content, categoryId }) {
    await db.query(
      `UPDATE forum_threads
       SET title = ?, slug = ?, content = ?, category_id = ?
       WHERE id = ?`,
      [title, slug, content, categoryId, id]
    );
    return this.findById(id);
  }

  static async softDelete(id) {
    const [result] = await db.query(
      'UPDATE forum_threads SET is_deleted = TRUE WHERE id = ?',
      [id]
    );
    return result.affectedRows > 0;
  }

  static async incrementView(id) {
    await db.query(
      'UPDATE forum_threads SET view_count = view_count + 1 WHERE id = ?',
      [id]
    );
  }

  static async togglePin(id, isPinned) {
    await db.query(
      'UPDATE forum_threads SET is_pinned = ? WHERE id = ?',
      [isPinned, id]
    );
  }

  static async toggleLock(id, isLocked) {
    await db.query(
      'UPDATE forum_threads SET is_locked = ? WHERE id = ?',
      [isLocked, id]
    );
  }

  static async updateLastActivity(id) {
    await db.query(
      'UPDATE forum_threads SET last_activity_at = CURRENT_TIMESTAMP WHERE id = ?',
      [id]
    );
  }

  static async incrementReplyCount(id) {
    await db.query(
      'UPDATE forum_threads SET reply_count = reply_count + 1, last_activity_at = CURRENT_TIMESTAMP WHERE id = ?',
      [id]
    );
  }

  static async decrementReplyCount(id) {
    await db.query(
      'UPDATE forum_threads SET reply_count = GREATEST(reply_count - 1, 0) WHERE id = ?',
      [id]
    );
  }

  static async updateLikeCount(id, delta) {
    await db.query(
      'UPDATE forum_threads SET like_count = GREATEST(like_count + ?, 0) WHERE id = ?',
      [delta, id]
    );
  }
}

module.exports = ThreadModel;
