const CategoryModel = require('../models/categoryModel');
const { generateSlug } = require('../services/slugService');

class CategoryController {
  /**
   * GET /api/forum/categories
   * Public - ambil semua kategori aktif
   */
  static async getAll(req, res) {
    try {
      const activeOnly = req.query.all !== 'true';
      const categories = await CategoryModel.findAll(activeOnly);
      return res.json({ success: true, data: categories });
    } catch (err) {
      console.error('[Category] getAll error:', err);
      return res.status(500).json({ success: false, message: err.message });
    }
  }

  /**
   * GET /api/forum/categories/:slug
   */
  static async getBySlug(req, res) {
    try {
      const category = await CategoryModel.findBySlug(req.params.slug);
      if (!category) {
        return res.status(404).json({ success: false, message: 'Kategori tidak ditemukan' });
      }
      return res.json({ success: true, data: category });
    } catch (err) {
      return res.status(500).json({ success: false, message: err.message });
    }
  }

  /**
   * POST /api/forum/categories
   * Admin only
   */
  static async create(req, res) {
    try {
      const { name, description, icon } = req.body;

      if (!name) {
        return res.status(400).json({ success: false, message: 'Nama kategori wajib diisi' });
      }

      const slug = generateSlug(name);
      const existing = await CategoryModel.findBySlug(slug);
      if (existing) {
        return res.status(409).json({ success: false, message: 'Kategori dengan nama tersebut sudah ada' });
      }

      const category = await CategoryModel.create({ name, slug, description, icon });
      return res.status(201).json({ success: true, data: category });
    } catch (err) {
      console.error('[Category] create error:', err);
      return res.status(500).json({ success: false, message: err.message });
    }
  }

  /**
   * PUT /api/forum/categories/:id
   * Admin only
   */
  static async update(req, res) {
    try {
      const { id } = req.params;
      const { name, description, icon, is_active } = req.body;

      const existing = await CategoryModel.findById(id);
      if (!existing) {
        return res.status(404).json({ success: false, message: 'Kategori tidak ditemukan' });
      }

      const slug = name ? generateSlug(name) : existing.slug;
      const category = await CategoryModel.update(id, {
        name: name ?? existing.name,
        slug,
        description: description ?? existing.description,
        icon: icon ?? existing.icon,
        is_active: is_active ?? existing.is_active
      });

      return res.json({ success: true, data: category });
    } catch (err) {
      return res.status(500).json({ success: false, message: err.message });
    }
  }

  /**
   * DELETE /api/forum/categories/:id
   * Admin only
   */
  static async delete(req, res) {
    try {
      const deleted = await CategoryModel.delete(req.params.id);
      if (!deleted) {
        return res.status(404).json({ success: false, message: 'Kategori tidak ditemukan' });
      }
      return res.json({ success: true, message: 'Kategori berhasil dihapus' });
    } catch (err) {
      return res.status(500).json({ success: false, message: err.message });
    }
  }
}

module.exports = CategoryController;
