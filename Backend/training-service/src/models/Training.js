const db = require('../../../shared/database/mysql');

class Training {
  static async create(trainingData) {
    const { title, description, category, level } = trainingData;
    const query = `
      INSERT INTO trainings (title, description, category, level, created_at)
      VALUES (?, ?, ?, ?, NOW())
    `;
    const result = await db.query(query, [title, description, category, level]);
    return result;
  }

  static async findAll() {
    const query = 'SELECT * FROM trainings';
    return await db.query(query);
  }

  static async findById(id) {
    const query = 'SELECT * FROM trainings WHERE id = ?';
    const results = await db.query(query, [id]);
    return results[0] || null;
  }

  static async update(id, trainingData) {
    const { title, description, category, level } = trainingData;
    const query = `
      UPDATE trainings 
      SET title = ?, description = ?, category = ?, level = ?, updated_at = NOW()
      WHERE id = ?
    `;
    await db.query(query, [title, description, category, level, id]);
    return this.findById(id);
  }

  static async delete(id) {
    const query = 'DELETE FROM trainings WHERE id = ?';
    await db.query(query, [id]);
    return true;
  }
}

module.exports = Training;
