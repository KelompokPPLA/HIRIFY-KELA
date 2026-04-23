const supabase = require('../config/supabase');
const User = require('./User');
const Availability = require('./Availability');

const mapRow = (r) => r ? { ...r, _id: r.id } : null;

const makeQuery = (rows) => {
  const ctx = { rows: (rows || []).map(mapRow), populates: [] };
  return {
    populate(field, fields) {
      ctx.populates.push({ field, fields });
      return this;
    },
    then: async (resolve, reject) => {
      try {
        let result = ctx.rows;
        for (const p of ctx.populates) {
          if (p.field === 'menteeId') {
            const ids = result.map(r => r.menteeId).filter(Boolean);
            const { data: users } = await supabase.from('users').select('*').in('id', ids);
            const byId = (users || []).reduce((acc, u) => { acc[u.id] = u; return acc; }, {});
            result = result.map(r => ({ ...r, menteeId: byId[r.menteeId] || null }));
          }
          if (p.field === 'availabilityId') {
            const ids = result.map(r => r.availabilityId).filter(Boolean);
            const { data: avails } = await supabase.from('availabilities').select('*').in('id', ids);
            const byId = (avails || []).reduce((acc, a) => { acc[a.id] = a; return acc; }, {});
            result = result.map(r => ({ ...r, availabilityId: byId[r.availabilityId] || null }));
          }
        }
        return resolve ? resolve(result) : result;
      } catch (err) {
        return reject ? reject(err) : Promise.reject(err);
      }
    }
  };
};

module.exports = {
  create: async (data) => {
    const { data: result, error } = await supabase.from('bookings').insert([data]).select().single();
    if (error) throw error;
    return mapRow(result);
  },
  find: async (filter = {}) => {
    let qb = supabase.from('bookings').select('*');
    if (filter.mentorId) qb = qb.eq('mentorId', filter.mentorId);
    const { data, error } = await qb;
    if (error) throw error;
    return makeQuery(data);
  },
  findOne: async (filter = {}) => {
    let qb = supabase.from('bookings').select('*').limit(1);
    if (filter._id) qb = qb.eq('id', filter._id);
    if (filter.mentorId) qb = qb.eq('mentorId', filter.mentorId);
    const { data, error } = await qb;
    if (error) throw error;
    const row = data[0];
    if (!row) return null;
    const obj = mapRow(row);
    obj.populate = function(field, fields) {
      return (async () => {
        if (field === 'menteeId') {
          const user = await User.findById(obj.menteeId);
          obj.menteeId = user;
        }
        if (field === 'availabilityId') {
          const avail = await Availability.findById(obj.availabilityId);
          obj.availabilityId = avail;
        }
        return obj;
      })();
    };
    obj.save = async function() {
      const updates = { mentorId: obj.mentorId, menteeId: obj.menteeId && obj.menteeId._id ? obj.menteeId._id : obj.menteeId, availabilityId: obj.availabilityId && obj.availabilityId._id ? obj.availabilityId._id : obj.availabilityId, status: obj.status };
      const { data: res, error: err } = await supabase.from('bookings').update(updates).eq('id', obj._id).select().single();
      if (err) throw err;
      Object.assign(obj, mapRow(res));
      return obj;
    };
    return obj;
  },
  findById: async (id) => {
    const { data, error } = await supabase.from('bookings').select('*').eq('id', id).limit(1);
    if (error) throw error;
    return mapRow(data[0]);
  }
};
