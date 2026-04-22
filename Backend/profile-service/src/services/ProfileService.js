const Profile = require('../models/Profile');
const logger = require('../../../shared/utils/logger');

class ProfileService {
  static async createProfile(userId, profileData) {
    try {
      const result = await Profile.create(userId, profileData);
      logger.success('Profile created', { userId });
      return result;
    } catch (error) {
      logger.error('Failed to create profile', error.message);
      throw error;
    }
  }

  static async getProfile(userId) {
    try {
      const profile = await Profile.findByUserId(userId);
      if (!profile) {
        throw new Error('Profile not found');
      }
      return profile;
    } catch (error) {
      logger.error('Failed to get profile', error.message);
      throw error;
    }
  }

  static async updateProfile(userId, profileData) {
    try {
      const profile = await Profile.update(userId, profileData);
      logger.success('Profile updated', { userId });
      return profile;
    } catch (error) {
      logger.error('Failed to update profile', error.message);
      throw error;
    }
  }

  static async deleteProfile(userId) {
    try {
      await Profile.delete(userId);
      logger.success('Profile deleted', { userId });
      return true;
    } catch (error) {
      logger.error('Failed to delete profile', error.message);
      throw error;
    }
  }
}

module.exports = ProfileService;
