require('dotenv').config();
const express = require('express');
const cors = require('cors');
const http = require('http');
const socketIo = require('socket.io');
const config = require('../../shared/config');
const logger = require('../../shared/utils/logger');

const serviceConfig = require('./config');
const { setupSocketEvents } = require('./socket/socketHandler');

const app = express();
const server = http.createServer(app);
const io = socketIo(server, {
  cors: config.cors,
});

const PORT = serviceConfig.port;

// Middleware
app.use(cors(config.cors));
app.use(express.json());

// Health check
app.get('/health', (req, res) => {
  res.json({
    success: true,
    service: 'realtime-service',
    status: 'running',
  });
});

// Socket.IO setup
setupSocketEvents(io);

// Start server
server.listen(PORT, () => {
  logger.success(`Realtime Service running on port ${PORT}`);
  logger.info(`WebSocket server listening at http://localhost:${PORT}`);
});

// Graceful shutdown
process.on('SIGINT', () => {
  logger.warn('Shutting down...');
  server.close(() => {
    logger.warn('Server closed');
    process.exit(0);
  });
});

module.exports = { app, io };
