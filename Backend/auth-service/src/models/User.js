const db = require('../../../shared/database/mysql');

class User {
  static async create(email, password, role = 'user') {
    const query = `
      INSERT INTO users (email, password, role, created_at)
      VALUES (?, ?, ?, NOW())
    `;
    const result = await db.query(query, [email, password, role]);
    return result;
  }

  static async findByEmail(email) {
    const query = 'SELECT * FROM users WHERE email = ?';
    const results = await db.query(query, [email]);
    return results[0] || null;
  }

  static async findById(id) {
    const query = 'SELECT * FROM users WHERE id = ?';
    const results = await db.query(query, [id]);
    return results[0] || null;
  }

  static async findByRole(role) {
    const query = 'SELECT * FROM users WHERE role = ?';
    const results = await db.query(query, [role]);
    return results;
  }

  static async update(id, updates) {
    const fields = Object.keys(updates)
      .map((key) => `${key} = ?`)
      .join(', ');
    const values = Object.values(updates);
    
    const query = `UPDATE users SET ${fields}, updated_at = NOW() WHERE id = ?`;
    await db.query(query, [...values, id]);
    return this.findById(id);
  }

  static async delete(id) {
    const query = 'DELETE FROM users WHERE id = ?';
    await db.query(query, [id]);
    return true;
  }

  static async getAll() {
    const query = 'SELECT id, email, role, created_at FROM users';
    return await db.query(query);
  }
}

module.exports = User;
