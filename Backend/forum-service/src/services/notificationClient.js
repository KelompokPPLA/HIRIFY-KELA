const axios = require('axios');

const NOTIFICATION_SERVICE = process.env.NOTIFICATION_SERVICE_URL || 'http://localhost:4008';
const REALTIME_SERVICE = process.env.REALTIME_SERVICE_URL || 'http://localhost:4010';

/**
 * Kirim notifikasi ke user via notification service
 */
async function sendNotification({ userId, type, title, message, link }) {
  try {
    await axios.post(
      `${NOTIFICATION_SERVICE}/api/notifications`,
      { userId, type, title, message, link },
      { timeout: 3000 }
    );
  } catch (err) {
    // Log error tapi jangan block flow utama
    console.error('[Forum] Gagal kirim notifikasi:', err.message);
  }
}

/**
 * Emit realtime event via Socket.IO service
 */
async function emitRealtimeEvent({ room, event, payload }) {
  try {
    await axios.post(
      `${REALTIME_SERVICE}/api/emit`,
      { room, event, payload },
      { timeout: 3000 }
    );
  } catch (err) {
    console.error('[Forum] Gagal emit realtime event:', err.message);
  }
}

module.exports = { sendNotification, emitRealtimeEvent };
