const supabase = require('./supabase');

const connectDB = async () => {
  try {
    if (!process.env.SUPABASE_URL || !process.env.SUPABASE_KEY) {
      console.warn('SUPABASE_URL or SUPABASE_KEY not set — skipping connection test');
      return;
    }
    const { error } = await supabase.from('users').select('id').limit(1);
    if (error) throw error;
    console.log('Supabase connected');
  } catch (err) {
    console.error('Supabase connection error', err);
    process.exit(1);
  }
};

module.exports = connectDB;
