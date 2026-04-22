const db = require('../../../shared/database/mysql');

class JobMatch {
  static async create(jobData) {
    const { title, description, company, location, requiredSkills } = jobData;
    const query = `
      INSERT INTO jobs (title, description, company, location, required_skills, created_at)
      VALUES (?, ?, ?, ?, ?, NOW())
    `;
    const result = await db.query(query, [title, description, company, location, JSON.stringify(requiredSkills)]);
    return result;
  }

  static async findAll() {
    const query = 'SELECT * FROM jobs';
    return await db.query(query);
  }

  static async findById(id) {
    const query = 'SELECT * FROM jobs WHERE id = ?';
    const results = await db.query(query, [id]);
    return results[0] || null;
  }

  static async matchUserToJobs(userId, userSkills) {
    const query = `
      SELECT * FROM jobs 
      WHERE required_skills IS NOT NULL
    `;
    const jobs = await db.query(query);
    
    // Simple matching algorithm - can be enhanced
    const matches = jobs.filter(job => {
      const requiredSkills = JSON.parse(job.required_skills);
      return requiredSkills.some(skill => userSkills.includes(skill));
    });

    return matches;
  }
}

module.exports = JobMatch;
