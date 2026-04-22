const ProfileService = require('../services/ProfileService');

class ProfileController {
  /**
   * Create user profile
   * POST /api/profiles
   */
  static async create(req, res) {
    try {
      const userId = req.user.id;
      const profileData = req.body;

      if (!profileData.firstName || !profileData.lastName) {
        return res.status(400).json({
          success: false,
          message: 'First name and last name are required',
        });
      }

      const result = await ProfileService.createProfile(userId, profileData);

      res.status(201).json({
        success: true,
        message: 'Profile created successfully',
        data: result,
      });
    } catch (error) {
      res.status(500).json({
        success: false,
        message: error.message,
      });
    }
  }

  /**
   * Get user profile
   * GET /api/profiles/:userId
   */
  static async get(req, res) {
    try {
      const { userId } = req.params;

      const profile = await ProfileService.getProfile(userId);

      res.status(200).json({
        success: true,
        data: profile,
      });
    } catch (error) {
      const statusCode = error.message.includes('not found') ? 404 : 500;
      res.status(statusCode).json({
        success: false,
        message: error.message,
      });
    }
  }

  /**
   * Update user profile
   * PUT /api/profiles/:userId
   */
  static async update(req, res) {
    try {
      const { userId } = req.params;
      const profileData = req.body;

      const profile = await ProfileService.updateProfile(userId, profileData);

      res.status(200).json({
        success: true,
        message: 'Profile updated successfully',
        data: profile,
      });
    } catch (error) {
      res.status(500).json({
        success: false,
        message: error.message,
      });
    }
  }

  /**
   * Delete user profile
   * DELETE /api/profiles/:userId
   */
  static async delete(req, res) {
    try {
      const { userId } = req.params;

      await ProfileService.deleteProfile(userId);

      res.status(200).json({
        success: true,
        message: 'Profile deleted successfully',
      });
    } catch (error) {
      res.status(500).json({
        success: false,
        message: error.message,
      });
    }
  }
}

module.exports = ProfileController;
