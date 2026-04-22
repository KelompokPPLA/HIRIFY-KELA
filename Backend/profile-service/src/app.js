const express = require('express');
const app = express();

const profileRoutes = require('./routes/profileRoutes');

app.use(express.json());

app.use('/api/profiles', profileRoutes);

app.listen(4002, () => {
    console.log('Profile Service running on port 4002');
});