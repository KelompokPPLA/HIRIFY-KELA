const express = require('express');
const ProfileController = require('../controllers/ProfileController');
const { authMiddleware } = require('../../../shared/middleware/auth');

const router = express.Router();

// All profile routes require authentication
router.use(authMiddleware);

router.post('/', ProfileController.create);
router.get('/:userId', ProfileController.get);
router.put('/:userId', ProfileController.update);
router.delete('/:userId', ProfileController.delete);

module.exports = router;
