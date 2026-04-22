const db = require('../config/db');

exports.uploadCV = async (userId, fileName) => {
    const query = `INSERT INTO cvs (user_id, file_name) VALUES (?, ?)`;
    return db.execute(query, [userId, fileName]);
};

exports.getCVByUser = async (userId) => {
    const query = `SELECT * FROM cvs WHERE user_id = ?`;
    return db.execute(query, [userId]);
};

exports.updateCV = async (id, fileName) => {
    const query = `UPDATE cvs SET file_name=? WHERE id=?`;
    return db.execute(query, [fileName, id]);
};

exports.deleteCV = async (id) => {
    const query = `DELETE FROM cvs WHERE id=?`;
    return db.execute(query, [id]);
};