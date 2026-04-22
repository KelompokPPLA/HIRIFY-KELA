const express = require('express');
const app = express();
const cvRoutes = require('./routes/cvRoutes');

app.use(express.json());
app.use('/api/cvs', cvRoutes);
app.listen(4003, () => {
    console.log('CV Service running on port 4003');
});