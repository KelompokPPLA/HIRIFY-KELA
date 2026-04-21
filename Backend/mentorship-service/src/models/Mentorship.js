const db = require('../../../shared/database/mysql');

class Mentorship {
  static async createRequest(menteeId, mentorId, message) {
    const query = `
      INSERT INTO mentorship_requests (mentee_id, mentor_id, message, status, created_at)
      VALUES (?, ?, ?, 'pending', NOW())
    `;
    const result = await db.query(query, [menteeId, mentorId, message]);
    return result;
  }

  static async findRequests(userId) {
    const query = `
      SELECT * FROM mentorship_requests 
      WHERE mentee_id = ? OR mentor_id = ?
    `;
    return await db.query(query, [userId, userId]);
  }

  static async updateStatus(requestId, status) {
    const query = `
      UPDATE mentorship_requests 
      SET status = ?, updated_at = NOW()
      WHERE id = ?
    `;
    await db.query(query, [status, requestId]);
    return true;
  }

  static async delete(requestId) {
    const query = 'DELETE FROM mentorship_requests WHERE id = ?';
    await db.query(query, [requestId]);
    return true;
  }
}

module.exports = Mentorship;
