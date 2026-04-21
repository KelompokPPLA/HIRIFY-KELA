const db = require('../../../shared/database/mysql');

class Profile {
  static async create(userId, profileData) {
    const { firstName, lastName, bio, location, phone } = profileData;
    const query = `
      INSERT INTO profiles (user_id, first_name, last_name, bio, location, phone, created_at)
      VALUES (?, ?, ?, ?, ?, ?, NOW())
    `;
    const result = await db.query(query, [userId, firstName, lastName, bio, location, phone]);
    return result;
  }

  static async findByUserId(userId) {
    const query = 'SELECT * FROM profiles WHERE user_id = ?';
    const results = await db.query(query, [userId]);
    return results[0] || null;
  }

  static async update(userId, profileData) {
    const { firstName, lastName, bio, location, phone } = profileData;
    const query = `
      UPDATE profiles 
      SET first_name = ?, last_name = ?, bio = ?, location = ?, phone = ?, updated_at = NOW()
      WHERE user_id = ?
    `;
    await db.query(query, [firstName, lastName, bio, location, phone, userId]);
    return this.findByUserId(userId);
  }

  static async delete(userId) {
    const query = 'DELETE FROM profiles WHERE user_id = ?';
    await db.query(query, [userId]);
    return true;
  }
}

module.exports = Profile;
