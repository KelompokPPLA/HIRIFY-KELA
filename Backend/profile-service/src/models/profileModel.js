const db = require('../config/db');

exports.createProfile = async (data) => {
    const query = `
        INSERT INTO profiles 
        (user_id, first_name, last_name, education, experience, skills, photo)
        VALUES (?, ?, ?, ?, ?, ?, ?)
    `;
    return db.execute(query, [
        data.user_id,
        data.first_name,
        data.last_name,
        data.education,
        data.experience,
        data.skills,
        data.photo || null
    ]);
};

exports.getProfileByUserId = async (userId) => {
    const query = `SELECT * FROM profiles WHERE user_id = ?`;
    return db.execute(query, [userId]);
};

exports.updateProfile = async (userId, data) => {
    const query = `
        UPDATE profiles SET 
        first_name=?, last_name=?, education=?, experience=?, skills=?, photo=?
        WHERE user_id=?
    `;
    return db.execute(query, [
        data.first_name,
        data.last_name,
        data.education,
        data.experience,
        data.skills,
        data.photo,
        userId
    ]);
};