const express = require('express');
const router = express.Router();
const controller = require('../controllers/cvController');
const upload = require('../middleware/upload');

// upload CV
router.post('/', upload.single('cv'), controller.uploadCV);

// get CV
router.get('/:userId', controller.getCV);

// update CV
router.put('/:id', upload.single('cv'), controller.updateCV);

// delete CV
router.delete('/:id', controller.deleteCV);

module.exports = router;