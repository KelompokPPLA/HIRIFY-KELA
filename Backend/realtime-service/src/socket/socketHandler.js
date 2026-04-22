const logger = require('../../../shared/utils/logger');

function setupSocketEvents(io) {
  io.on('connection', (socket) => {
    logger.success(`User connected: ${socket.id}`);

    // User joins a room (e.g., notification room)
    socket.on('join', (data) => {
      const { userId, room } = data;
      socket.join(room);
      logger.debug(`User ${userId} joined room ${room}`);
      io.to(room).emit('user-joined', {
        message: `User ${userId} joined the room`,
        userId,
      });
    });

    // Send notification
    socket.on('send-notification', (data) => {
      const { room, message } = data;
      io.to(room).emit('notification', message);
      logger.debug(`Notification sent to room ${room}`);
    });

    // Mentorship message
    socket.on('mentorship-message', (data) => {
      const { from, to, message } = data;
      io.to(to).emit('new-message', {
        from,
        message,
        timestamp: new Date(),
      });
      logger.debug(`Message from ${from} to ${to}`);
    });

    // Training progress update
    socket.on('training-progress', (data) => {
      const { userId, progress } = data;
      io.emit('user-progress', {
        userId,
        progress,
        timestamp: new Date(),
      });
    });

    // Job match notification
    socket.on('job-match', (data) => {
      const { userId, job } = data;
      io.to(userId).emit('new-job-match', job);
      logger.debug(`Job match sent to user ${userId}`);
    });

    // User disconnect
    socket.on('disconnect', () => {
      logger.warn(`User disconnected: ${socket.id}`);
      io.emit('user-left', {
        userId: socket.id,
        message: 'User disconnected',
      });
    });
  });
}

module.exports = {
  setupSocketEvents,
};
