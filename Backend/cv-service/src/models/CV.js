const db = require('../../../shared/database/mysql');

class CV {
  static async create(userId, cvData) {
    const { title, summary, skills, experience } = cvData;
    const query = `
      INSERT INTO cvs (user_id, title, summary, skills, experience, created_at)
      VALUES (?, ?, ?, ?, ?, NOW())
    `;
    const result = await db.query(query, [userId, title, summary, JSON.stringify(skills), JSON.stringify(experience)]);
    return result;
  }

  static async findByUserId(userId) {
    const query = 'SELECT * FROM cvs WHERE user_id = ?';
    const results = await db.query(query, [userId]);
    return results[0] || null;
  }

  static async update(userId, cvData) {
    const { title, summary, skills, experience } = cvData;
    const query = `
      UPDATE cvs 
      SET title = ?, summary = ?, skills = ?, experience = ?, updated_at = NOW()
      WHERE user_id = ?
    `;
    await db.query(query, [title, summary, JSON.stringify(skills), JSON.stringify(experience), userId]);
    return this.findByUserId(userId);
  }

  static async delete(userId) {
    const query = 'DELETE FROM cvs WHERE user_id = ?';
    await db.query(query, [userId]);
    return true;
  }
}

module.exports = CV;
