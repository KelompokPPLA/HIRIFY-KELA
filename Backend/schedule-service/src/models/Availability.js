const supabase = require('../config/supabase');

const mapRow = (r) => r ? { ...r, _id: r.id } : null;

module.exports = {
  create: async (data) => {
    const { data: result, error } = await supabase.from('availabilities').insert([data]).select().single();
    if (error) throw error;
    return mapRow(result);
  },
  find: async (filter = {}) => {
    let qb = supabase.from('availabilities').select('*');
    if (filter.mentorId) qb = qb.eq('mentorId', filter.mentorId);
    if (filter.date) qb = qb.eq('date', filter.date);
    if (filter._id && filter._id.$ne) qb = qb.neq('id', filter._id.$ne);
    const { data, error } = await qb;
    if (error) throw error;
    return (data || []).map(mapRow);
  },
  findOne: async (filter = {}) => {
    let qb = supabase.from('availabilities').select('*').limit(1);
    if (filter._id) qb = qb.eq('id', filter._id);
    if (filter.mentorId) qb = qb.eq('mentorId', filter.mentorId);
    const { data, error } = await qb;
    if (error) throw error;
    const row = data[0];
    if (!row) return null;
    const obj = mapRow(row);
    obj.save = async () => {
      const updates = { date: obj.date, startTime: obj.startTime, endTime: obj.endTime, isBooked: obj.isBooked };
      const { data: res, error: err } = await supabase.from('availabilities').update(updates).eq('id', obj._id).select().single();
      if (err) throw err;
      Object.assign(obj, mapRow(res));
      return obj;
    };
    obj.remove = async () => {
      const { error: err } = await supabase.from('availabilities').delete().eq('id', obj._id);
      if (err) throw err;
      return;
    };
    return obj;
  },
  findById: async (id) => {
    const { data, error } = await supabase.from('availabilities').select('*').eq('id', id).limit(1);
    if (error) throw error;
    return mapRow(data[0]);
  }
};
