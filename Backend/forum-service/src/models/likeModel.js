const db = require('../config/database');

class LikeModel {
  /**
   * Toggle like - jika sudah like, unlike. Jika belum, like.
   * Return: { liked: boolean, delta: number }
   */
  static async toggle({ userId, targetType, targetId }) {
    const [existing] = await db.query(
      'SELECT id FROM forum_likes WHERE user_id = ? AND target_type = ? AND target_id = ?',
      [userId, targetType, targetId]
    );

    if (existing.length > 0) {
      await db.query(
        'DELETE FROM forum_likes WHERE user_id = ? AND target_type = ? AND target_id = ?',
        [userId, targetType, targetId]
      );
      return { liked: false, delta: -1 };
    } else {
      await db.query(
        'INSERT INTO forum_likes (user_id, target_type, target_id) VALUES (?, ?, ?)',
        [userId, targetType, targetId]
      );
      return { liked: true, delta: 1 };
    }
  }

  static async hasLiked({ userId, targetType, targetId }) {
    const [rows] = await db.query(
      'SELECT id FROM forum_likes WHERE user_id = ? AND target_type = ? AND target_id = ?',
      [userId, targetType, targetId]
    );
    return rows.length > 0;
  }

  static async countByTarget({ targetType, targetId }) {
    const [rows] = await db.query(
      'SELECT COUNT(*) AS total FROM forum_likes WHERE target_type = ? AND target_id = ?',
      [targetType, targetId]
    );
    return rows[0].total;
  }
}

module.exports = LikeModel;
