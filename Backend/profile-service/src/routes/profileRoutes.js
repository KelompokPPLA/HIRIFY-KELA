const express = require('express');
const router = express.Router();
const controller = require('../controllers/profileController');
const upload = require('../middleware/upload');

router.post('/', controller.createProfile);
router.get('/:userId', controller.getProfile);
router.put('/:userId', controller.updateProfile);

// upload foto
router.post('/upload/:userId', upload.single('photo'), (req, res) => {
    res.json({
        message: 'Foto berhasil diupload',
        file: req.file.filename
    });
});

module.exports = router;