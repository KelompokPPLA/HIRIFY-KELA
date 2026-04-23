const express = require('express');
const router = express.Router();
const ReplyController = require('../controllers/replyController');
const { authenticate } = require('../middleware/auth');

router.put('/:id', authenticate, ReplyController.update);
router.delete('/:id', authenticate, ReplyController.delete);
router.post('/:id/like', authenticate, ReplyController.toggleLike);
router.patch('/:id/solution', authenticate, ReplyController.markSolution);

module.exports = router;
