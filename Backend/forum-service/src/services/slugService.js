/**
 * Utility untuk generate slug dari string
 */
function generateSlug(text) {
  return text
    .toString()
    .toLowerCase()
    .trim()
    .replace(/\s+/g, '-')           // spasi -> dash
    .replace(/[^\w\-]+/g, '')       // hapus karakter non-word
    .replace(/\-\-+/g, '-')         // dash ganda -> satu dash
    .replace(/^-+/, '')
    .replace(/-+$/, '');
}

/**
 * Generate unique slug dengan menambahkan timestamp jika perlu
 */
function generateUniqueSlug(text) {
  const baseSlug = generateSlug(text);
  const timestamp = Date.now().toString(36);
  return `${baseSlug}-${timestamp}`;
}

module.exports = { generateSlug, generateUniqueSlug };
