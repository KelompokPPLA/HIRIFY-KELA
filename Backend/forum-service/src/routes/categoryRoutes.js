const express = require('express');
const router = express.Router();
const CategoryController = require('../controllers/categoryController');
const { authenticate, authorize } = require('../middleware/auth');

// Public routes
router.get('/', CategoryController.getAll);
router.get('/:slug', CategoryController.getBySlug);

// Admin only
router.post('/', authenticate, authorize('admin'), CategoryController.create);
router.put('/:id', authenticate, authorize('admin'), CategoryController.update);
router.delete('/:id', authenticate, authorize('admin'), CategoryController.delete);

module.exports = router;
