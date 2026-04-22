const cvModel = require('../models/cvModel');
const fs = require('fs')
exports.uploadCV = async (req, res) => {
    try {
        const userId = req.body.user_id;
        const fileName = req.file.filename;

        await cvModel.uploadCV(userId, fileName);

        res.json({ message: 'CV berhasil diupload' });
    } catch (err) {
        res.status(500).json({ error: err.message });
    }
};

exports.getCV = async (req, res) => {
    try {
        const userId = req.params.userId;
        const [rows] = await cvModel.getCVByUser(userId);

        res.json(rows);
    } catch (err) {
        res.status(500).json({ error: err.message });
    }
};

exports.updateCV = async (req, res) => {
    try {
        const id = req.params.id;
        const fileName = req.file.filename;

        await cvModel.updateCV(id, fileName);

        res.json({ message: 'CV berhasil diupdate' });
    } catch (err) {
        res.status(500).json({ error: err.message });
    }
};

exports.deleteCV = async (req, res) => {
    try {
        const id = req.params.id;

        await cvModel.deleteCV(id);

        res.json({ message: 'CV berhasil dihapus' });
    } catch (err) {
        res.status(500).json({ error: err.message });
    }
};