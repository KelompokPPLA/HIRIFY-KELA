const db = require('../config/database');

class CategoryModel {
  static async findAll(activeOnly = true) {
    const query = activeOnly
      ? 'SELECT * FROM forum_categories WHERE is_active = TRUE ORDER BY name ASC'
      : 'SELECT * FROM forum_categories ORDER BY name ASC';
    const [rows] = await db.query(query);
    return rows;
  }

  static async findById(id) {
    const [rows] = await db.query(
      'SELECT * FROM forum_categories WHERE id = ?',
      [id]
    );
    return rows[0] || null;
  }

  static async findBySlug(slug) {
    const [rows] = await db.query(
      'SELECT * FROM forum_categories WHERE slug = ?',
      [slug]
    );
    return rows[0] || null;
  }

  static async create({ name, slug, description, icon }) {
    const [result] = await db.query(
      `INSERT INTO forum_categories (name, slug, description, icon)
       VALUES (?, ?, ?, ?)`,
      [name, slug, description, icon]
    );
    return this.findById(result.insertId);
  }

  static async update(id, { name, slug, description, icon, is_active }) {
    await db.query(
      `UPDATE forum_categories
       SET name = ?, slug = ?, description = ?, icon = ?, is_active = ?
       WHERE id = ?`,
      [name, slug, description, icon, is_active, id]
    );
    return this.findById(id);
  }

  static async delete(id) {
    const [result] = await db.query(
      'DELETE FROM forum_categories WHERE id = ?',
      [id]
    );
    return result.affectedRows > 0;
  }

  static async incrementThreadCount(id) {
    await db.query(
      'UPDATE forum_categories SET thread_count = thread_count + 1 WHERE id = ?',
      [id]
    );
  }

  static async decrementThreadCount(id) {
    await db.query(
      'UPDATE forum_categories SET thread_count = GREATEST(thread_count - 1, 0) WHERE id = ?',
      [id]
    );
  }
}

module.exports = CategoryModel;
