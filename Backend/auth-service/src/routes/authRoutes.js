const express = require('express');
const AuthController = require('../controllers/AuthController');
const { authMiddleware } = require('../../../shared/middleware/auth');

const router = express.Router();

// Public routes
router.post('/register', AuthController.register);
router.post('/login', AuthController.login);

// Protected routes
router.get('/validate', authMiddleware, AuthController.validate);
router.get('/me', authMiddleware, AuthController.getProfile);

module.exports = router;
