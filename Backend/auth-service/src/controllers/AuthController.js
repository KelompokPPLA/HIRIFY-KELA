const AuthService = require('../services/AuthService');

class AuthController {
  /**
   * Register new user
   * POST /api/auth/register
   */
  static async register(req, res) {
    try {
      const { email, password } = req.body;

      if (!email || !password) {
        return res.status(400).json({
          success: false,
          message: 'Email and password are required',
        });
      }

      const user = await AuthService.register(email, password);

      res.status(201).json({
        success: true,
        message: 'User registered successfully',
        data: user,
      });
    } catch (error) {
      res.status(error.message.includes('already exists') ? 409 : 500).json({
        success: false,
        message: error.message,
      });
    }
  }

  /**
   * Login user
   * POST /api/auth/login
   */
  static async login(req, res) {
    try {
      const { email, password } = req.body;

      if (!email || !password) {
        return res.status(400).json({
          success: false,
          message: 'Email and password are required',
        });
      }

      const result = await AuthService.login(email, password);

      res.status(200).json({
        success: true,
        message: 'Login successful',
        data: result,
      });
    } catch (error) {
      res.status(401).json({
        success: false,
        message: error.message,
      });
    }
  }

  /**
   * Validate token
   * GET /api/auth/validate
   */
  static async validate(req, res) {
    try {
      const user = await AuthService.validateToken(req.user.id);

      res.status(200).json({
        success: true,
        message: 'Token is valid',
        data: user,
      });
    } catch (error) {
      res.status(401).json({
        success: false,
        message: error.message,
      });
    }
  }

  /**
   * Get user profile
   * GET /api/auth/me
   */
  static async getProfile(req, res) {
    try {
      const user = await AuthService.validateToken(req.user.id);

      res.status(200).json({
        success: true,
        data: user,
      });
    } catch (error) {
      res.status(404).json({
        success: false,
        message: error.message,
      });
    }
  }
}

module.exports = AuthController;
