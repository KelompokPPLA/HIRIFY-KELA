require('dotenv').config();
const express = require('express');
const cors = require('cors');
const db = require('../../shared/database/mysql');
const config = require('../../shared/config');
const logger = require('../../shared/utils/logger');

const profileRoutes = require('./routes/profileRoutes');
const serviceConfig = require('./config');

const app = express();
const PORT = serviceConfig.port;

// Middleware
app.use(cors(config.cors));
app.use(express.json());
app.use(express.urlencoded({ extended: true }));

// Request logging middleware
app.use((req, res, next) => {
  logger.debug(`${req.method} ${req.path}`);
  next();
});

// Health check
app.get('/health', (req, res) => {
  res.json({
    success: true,
    service: 'profile-service',
    status: 'running',
  });
});

// Routes
app.use('/api/profiles', profileRoutes);

// 404 handler
app.use((req, res) => {
  res.status(404).json({
    success: false,
    message: 'Route not found',
  });
});

// Error handler
app.use((err, req, res, next) => {
  logger.error('Unexpected error', err.message);
  res.status(500).json({
    success: false,
    message: 'Internal server error',
    error: config.isDev ? err.message : undefined,
  });
});

// Initialize database and start server
async function startServer() {
  try {
    await db.initializePool();
    logger.success(`Profile Service running on port ${PORT}`);

    app.listen(PORT, () => {
      logger.info(`Profile Service listening at http://localhost:${PORT}`);
    });
  } catch (error) {
    logger.error('Failed to start server', error.message);
    process.exit(1);
  }
}

// Graceful shutdown
process.on('SIGINT', async () => {
  logger.warn('Shutting down gracefully...');
  await db.closePool();
  process.exit(0);
});

startServer();

module.exports = app;
