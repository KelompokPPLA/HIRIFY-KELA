const profileModel = require('../models/profileModel');

exports.createProfile = async (req, res) => {
    try {
        const { user_id, first_name } = req.body;

        if (!user_id || !first_name) {
            return res.status(400).json({ message: 'user_id dan first_name wajib diisi' });
        }

        const [result] = await profileModel.createProfile(req.body);

        res.status(201).json({
            message: 'Profile berhasil dibuat',
            data: result
        });
    } catch (error) {
        res.status(500).json({ error: error.message });
    }
};

exports.getProfile = async (req, res) => {
    try {
        const userId = req.params.userId;

        const [rows] = await profileModel.getProfileByUserId(userId);

        if (rows.length === 0) {
            return res.status(404).json({ message: 'Profile tidak ditemukan' });
        }

        res.json(rows[0]);
    } catch (error) {
        res.status(500).json({ error: error.message });
    }
};

exports.updateProfile = async (req, res) => {
    try {
        const userId = req.params.userId;

        if (!userId) {
            return res.status(400).json({ message: 'userId wajib ada' });
        }

        await profileModel.updateProfile(userId, req.body);

        res.json({ message: 'Profile berhasil diupdate' });
    } catch (error) {
        res.status(500).json({ error: error.message });
    }
};