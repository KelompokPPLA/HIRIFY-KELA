const express = require('express');
const app = express();

const profileRoutes = require('./routes/profileRoutes');
const cvRoutes = require('./routes/cvRoutes');

app.use(express.json());

app.use('/api/profiles', profileRoutes);
app.use('/api/cvs', cvRoutes);

app.listen(3000, () => {
    console.log('Server running on port 3000');
});