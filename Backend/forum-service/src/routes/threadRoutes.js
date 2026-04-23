const express = require('express');
const router = express.Router();
const ThreadController = require('../controllers/threadController');
const ReplyController = require('../controllers/replyController');
const { authenticate, authorize, optionalAuth } = require('../middleware/auth');

// Public/optional auth routes
router.get('/', optionalAuth, ThreadController.getAll);
router.get('/:id', optionalAuth, ThreadController.getById);

// Protected routes
router.post('/', authenticate, ThreadController.create);
router.put('/:id', authenticate, ThreadController.update);
router.delete('/:id', authenticate, ThreadController.delete);
router.post('/:id/like', authenticate, ThreadController.toggleLike);

// Admin/mentor routes
router.patch('/:id/pin', authenticate, authorize('admin'), ThreadController.togglePin);
router.patch('/:id/lock', authenticate, authorize('admin', 'mentor'), ThreadController.toggleLock);

// Nested reply routes
router.get('/:threadId/replies', ReplyController.getByThread);
router.post('/:threadId/replies', authenticate, ReplyController.create);

module.exports = router;
