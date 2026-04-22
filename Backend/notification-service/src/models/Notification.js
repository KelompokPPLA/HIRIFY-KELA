const db = require('../../../shared/database/mysql');

class Notification {
  static async create(userId, notificationData) {
    const { title, message, type } = notificationData;
    const query = `
      INSERT INTO notifications (user_id, title, message, type, is_read, created_at)
      VALUES (?, ?, ?, ?, false, NOW())
    `;
    const result = await db.query(query, [userId, title, message, type]);
    return result;
  }

  static async findByUserId(userId) {
    const query = 'SELECT * FROM notifications WHERE user_id = ? ORDER BY created_at DESC';
    return await db.query(query, [userId]);
  }

  static async markAsRead(notificationId) {
    const query = `
      UPDATE notifications 
      SET is_read = true
      WHERE id = ?
    `;
    await db.query(query, [notificationId]);
    return true;
  }

  static async delete(notificationId) {
    const query = 'DELETE FROM notifications WHERE id = ?';
    await db.query(query, [notificationId]);
    return true;
  }
}

module.exports = Notification;
