require('dotenv').config();
const express = require('express');
const cors = require('cors');
const db = require('../../shared/database/mysql');
const config = require('../../shared/config');
const logger = require('../../shared/utils/logger');

const serviceConfig = require('./config');
const app = express();
const PORT = serviceConfig.port;

// Middleware
app.use(cors(config.cors));
app.use(express.json());
app.use(express.urlencoded({ extended: true }));

// Request logging
app.use((req, res, next) => {
  logger.debug(`${req.method} ${req.path}`);
  next();
});

// Health check
app.get('/health', (req, res) => {
  res.json({
    success: true,
    service: 'jobmatching-service',
    status: 'running',
  });
});

// Routes - Add your routes here
app.get('/api/jobs', (req, res) => {
  res.json({
    success: true,
    message: 'Job Matching Service',
  });
});

// 404 handler
app.use((req, res) => {
  res.status(404).json({ success: false, message: 'Route not found' });
});

// Error handler
app.use((err, req, res, next) => {
  logger.error('Error', err.message);
  res.status(500).json({
    success: false,
    message: 'Internal server error',
    error: config.isDev ? err.message : undefined,
  });
});

async function startServer() {
  try {
    await db.initializePool();
    logger.success(`Job Matching Service running on port ${PORT}`);
    app.listen(PORT, () => {
      logger.info(`Job Matching Service listening at http://localhost:${PORT}`);
    });
  } catch (error) {
    logger.error('Failed to start server', error.message);
    process.exit(1);
  }
}

process.on('SIGINT', async () => {
  logger.warn('Shutting down...');
  await db.closePool();
  process.exit(0);
});

startServer();
module.exports = app;
