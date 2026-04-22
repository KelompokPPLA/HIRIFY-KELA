const db = require('../../../shared/database/mysql');

class Roadmap {
  static async create(userId, roadmapData) {
    const { title, description, milestones } = roadmapData;
    const query = `
      INSERT INTO roadmaps (user_id, title, description, milestones, created_at)
      VALUES (?, ?, ?, ?, NOW())
    `;
    const result = await db.query(query, [userId, title, description, JSON.stringify(milestones)]);
    return result;
  }

  static async findByUserId(userId) {
    const query = 'SELECT * FROM roadmaps WHERE user_id = ?';
    const results = await db.query(query, [userId]);
    return results;
  }

  static async findById(id) {
    const query = 'SELECT * FROM roadmaps WHERE id = ?';
    const results = await db.query(query, [id]);
    return results[0] || null;
  }

  static async update(id, roadmapData) {
    const { title, description, milestones } = roadmapData;
    const query = `
      UPDATE roadmaps 
      SET title = ?, description = ?, milestones = ?, updated_at = NOW()
      WHERE id = ?
    `;
    await db.query(query, [title, description, JSON.stringify(milestones), id]);
    return this.findById(id);
  }

  static async delete(id) {
    const query = 'DELETE FROM roadmaps WHERE id = ?';
    await db.query(query, [id]);
    return true;
  }
}

module.exports = Roadmap;
