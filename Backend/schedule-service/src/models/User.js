const supabase = require('../config/supabase');

const mapUser = (row) => {
  if (!row) return null;
  return { ...row, _id: row.id };
};

module.exports = {
  create: async (data) => {
    const { data: result, error } = await supabase.from('users').insert([data]).select().single();
    if (error) throw error;
    return mapUser(result);
  },
  findOne: async (query) => {
    let qb = supabase.from('users').select('*').limit(1);
    if (query.email) qb = qb.eq('email', query.email);
    if (query._id) qb = qb.eq('id', query._id);
    const { data, error } = await qb;
    if (error) throw error;
    return mapUser(data[0]);
  },
  findById: async (id) => {
    const { data, error } = await supabase.from('users').select('*').eq('id', id).limit(1);
    if (error) throw error;
    return mapUser(data[0]);
  }
};
