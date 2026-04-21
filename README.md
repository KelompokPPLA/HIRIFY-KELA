# HIRIFY-KELA

## 🏗️ Architecture

### Microservices
- **Auth Service** (Port 4001) - Authentication & JWT management
- **Profile Service** (Port 4002) - User profile management
- **CV Service** (Port 4003) - CV/Resume building
- **Roadmap Service** (Port 4004) - Career roadmap planning
- **Training Service** (Port 4005) - Training resources
- **Mentorship Service** (Port 4006) - Mentor connections
- **Job Matching Service** (Port 4007) - Job recommendations
- **Notification Service** (Port 4008) - User notifications
- **Realtime Service** (Port 4010) - WebSocket via Socket.IO

### Frontend
- **Vue 3** with Vite
- **Tailwind CSS** for styling
- **Pinia** for state management
- **Vue Router** with auth guards
- **Socket.IO Client** for realtime

### Database
- **MySQL 8.0** with connection pooling
- Separate schemas per service pattern
- Pre-seeded admin and mentor accounts

## 🚀 Quick Start

### Prerequisites
- Node.js 18+
- MySQL 8.0+

### Local Development Setup

1. **Clone and install dependencies:**
```bash
cd d:\TUBES\ PPL

# Install root dependencies
npm install

# Install backend services
for dir in backend/*/; do cd "$dir" && npm install && cd ../../; done

# Install frontend dependencies
cd frontend && npm install && cd ..
```

2. **Configure environment:**
```bash
cp .env .env.local
# Edit .env.local with your database credentials
```

3. **Initialize database:**
```bash
npm run db:init
npm run seed
```

4. **Start all services:**
```bash
npm run dev
```

Services will be available at:
- Frontend: http://localhost:3000
- Auth: http://localhost:4001
- Profile: http://localhost:4002
- CV: http://localhost:4003
- Roadmap: http://localhost:4004
- Training: http://localhost:4005
- Mentorship: http://localhost:4006
- Job Matching: http://localhost:4007
- Notification: http://localhost:4008
- Realtime: http://localhost:4010

## 📋 Database Schema

### Users Table
```sql
- id (INT, PK)
- email (VARCHAR, UNIQUE)
- password (VARCHAR, hashed)
- role (ENUM: admin, mentor, user)
- created_at, updated_at
```

### Related Tables
- **profiles** - User profile information
- **cvs** - CV/Resume data
- **roadmaps** - Career roadmaps
- **trainings** - Training resources
- **mentorship_requests** - Mentor connections
- **jobs** - Job listings
- **notifications** - User notifications

## 🔐 Authentication

### JWT Implementation
- Token generated on login
- Stored in localStorage (frontend)
- Attached to all API requests via Authorization header
- Validated by auth middleware on protected routes

### Roles & Access Control
```javascript
// Roles
- admin: Full system access
- mentor: Can provide mentorship
- user: Regular user (default on registration)

// RBAC Middleware
authorize('admin', 'mentor') // Restricts to specific roles
```

### Default Accounts
- Admin: `admin@career-platform.com` / `admin123`
- Mentor: `mentor@career-platform.com` / `mentor123`

## 🔌 API Examples

### Authentication Service

#### Register (Public)
```bash
POST /api/auth/register
{
  "email": "user@example.com",
  "password": "password123"
}
```

#### Login (Public)
```bash
POST /api/auth/login
{
  "email": "user@example.com",
  "password": "password123"
}

Response:
{
  "success": true,
  "data": {
    "user": { "id": 1, "email": "user@example.com", "role": "user" },
    "token": "eyJhbGc..."
  }
}
```

#### Validate Token (Protected)
```bash
GET /api/auth/validate
Authorization: Bearer {token}
```

### Profile Service

#### Create Profile (Protected)
```bash
POST /api/profiles
Authorization: Bearer {token}
{
  "firstName": "John",
  "lastName": "Doe",
  "bio": "Software Developer",
  "location": "New York, NY",
  "phone": "555-1234"
}
```

#### Get Profile
```bash
GET /api/profiles/{userId}
Authorization: Bearer {token}
```

## 🔄 Service-to-Service Communication

Services can communicate via HTTP to shared URLs defined in `.env`:

```javascript
// Example: From Job Matching to Notification Service
const response = await axios.post(
  `${config.services.notification}/api/notifications`,
  notificationData
);
```

## 🔌 Socket.IO Events

### Connection & Room Management
```javascript
// Join a room
socket.emit('join', { userId: 1, room: 'user-1' })

// Send notification
socket.emit('send-notification', { 
  room: 'user-1', 
  message: 'New message!' 
})
```

### Available Events
- `notification` - Receive notifications
- `new-message` - Mentorship messages
- `user-progress` - Training progress
- `new-job-match` - Job recommendations
- `user-left` - User disconnected

## 📁 Project Structure

```
career-platform/
├── frontend/                    # Vue 3 + Vite
│   ├── src/
│   │   ├── modules/            # Feature modules
│   │   ├── services/           # API services
│   │   ├── stores/             # Pinia stores
│   │   ├── router/             # Vue Router
│   │   └── socket/             # Socket.IO client
│   ├── package.json
│   └── vite.config.js
│
├── backend/
│   ├── auth-service/
│   │   ├── src/
│   │   │   ├── app.js
│   │   │   ├── routes/
│   │   │   ├── controllers/
│   │   │   ├── services/
│   │   │   ├── models/
│   │   │   └── config/
│   │   └── package.json
│   ├── profile-service/       # Similar structure
│   ├── cv-service/
│   ├── roadmap-service/
│   ├── training-service/
│   ├── mentorship-service/
│   ├── jobmatching-service/
│   ├── notification-service/
│   └── realtime-service/
│
├── shared/
│   ├── database/              # MySQL connection pool
│   ├── middleware/            # Auth & RBAC
│   ├── utils/                 # Logger & utilities
│   └── config/                # Shared configuration
│
├── scripts/
│   ├── init.sql               # Database schema
│   ├── initDatabase.js        # DB initialization
│   └── seedDatabase.js        # Seed default users
│
├── .env                        # Environment variables
├── .env.production            # Production env
├── package.json               # Root scripts
└── README.md
```

## 🛠️ Development Workflow

### Add a New Microservice

1. Create service directory:
```bash
mkdir -p backend/my-service/src/{routes,controllers,services,models,config}
```

2. Create `app.js` following the template pattern
3. Create `package.json` with dependencies
4. Create routes, controllers, and models
6. Update root package.json scripts

### Frontend Module Structure

Each module follows this pattern:
```
modules/module-name/
├── components/
├── pages/
├── store/          (optional Pinia store)
└── types/          (TypeScript types if using TS)
```

## 🚦 Production Considerations

### Security
- ✓ Password hashing with bcryptjs
- ✓ JWT token validation
- ✓ CORS configured
- ⚠️ Change JWT_SECRET in production
- ⚠️ Use HTTPS in production
- ⚠️ Implement rate limiting
- ⚠️ Add request validation & sanitization

### Performance
- ✓ MySQL connection pooling
- ✓ Separate services for scaling
- ⚠️ Implement caching (Redis)
- ⚠️ Add API gateway (nginx/Kong)
- ⚠️ Enable compression

### Monitoring
- ⚠️ Add centralized logging
- ⚠️ Health check endpoints
- ⚠️ Performance metrics
- ⚠️ Error tracking (Sentry)

### Database
- ✓ Indexed common queries
- ⚠️ Regular backups
- ⚠️ Replication setup
- ⚠️ Query optimization

## 📦 Dependencies

### Backend Services
- express: Web framework
- mysql2: Database client
- jsonwebtoken: JWT auth
- bcryptjs: Password hashing
- cors: CORS middleware
- socket.io: WebSocket library

### Frontend
- vue: UI framework
- vue-router: Routing
- pinia: State management
- axios: HTTP client
- tailwindcss: CSS framework

## 🧪 Testing

```bash
# Run unit tests (to be implemented)
npm run test

# Run integration tests
npm run test:integration

# Run e2e tests
npm run test:e2e
```

## 🤝 Contributing

1. Create a feature branch
2. Make changes
3. Test thoroughly
4. Create pull request
5. Code review and merge

## 📄 License

MIT License - See LICENSE file

## 📚 Documentation

- [API Documentation](./docs/API.md)
- [Architecture Overview](./docs/ARCHITECTURE.md)
- [Deployment Guide](./docs/DEPLOYMENT.md)

## 🆘 Troubleshooting

### Database Connection Issues
```bash
# Check MySQL is running
mysql -u root -p -e "SELECT 1"

# Verify credentials in .env
# Make sure DATABASE is created
npm run db:init
```

### Port Already in Use
```bash
# Kill process on port
npx kill-port 4001 4002 ... 3000
```

### Module Not Found
```bash
# Reinstall dependencies
rm -rf node_modules package-lock.json
npm install
```

## 📞 Support

For issues and questions, please create an issue in the repository.
