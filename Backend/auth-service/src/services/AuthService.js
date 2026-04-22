const bcrypt = require('bcryptjs');
const User = require('../models/User');
const { generateToken } = require('../../../shared/middleware/auth');
const logger = require('../../../shared/utils/logger');

class AuthService {
  /**
   * Register a new user (only 'user' role can be created)
   */
  static async register(email, password) {
    try {
      // Check if user already exists
      const existingUser = await User.findByEmail(email);
      if (existingUser) {
        throw new Error('User with this email already exists');
      }

      // Hash password
      const salt = await bcrypt.genSalt(10);
      const hashedPassword = await bcrypt.hash(password, salt);

      // Create user with 'user' role only
      const result = await User.create(email, hashedPassword, 'user');
      logger.success('User registered successfully', { email, userId: result.insertId });

      return {
        id: result.insertId,
        email,
        role: 'user',
      };
    } catch (error) {
      logger.error('Registration error', error.message);
      throw error;
    }
  }

  /**
   * Login user and return JWT token
   */
  static async login(email, password) {
    try {
      const user = await User.findByEmail(email);
      if (!user) {
        throw new Error('User not found');
      }

      // Compare password
      const isPasswordValid = await bcrypt.compare(password, user.password);
      if (!isPasswordValid) {
        throw new Error('Invalid password');
      }

      // Generate JWT token
      const token = generateToken({
        id: user.id,
        email: user.email,
        role: user.role,
      });

      logger.success('User logged in successfully', { email });

      return {
        user: {
          id: user.id,
          email: user.email,
          role: user.role,
        },
        token,
      };
    } catch (error) {
      logger.error('Login error', error.message);
      throw error;
    }
  }

  /**
   * Validate token
   */
  static async validateToken(userId) {
    try {
      const user = await User.findById(userId);
      if (!user) {
        throw new Error('User not found');
      }
      return {
        id: user.id,
        email: user.email,
        role: user.role,
      };
    } catch (error) {
      logger.error('Token validation error', error.message);
      throw error;
    }
  }
}

module.exports = AuthService;
