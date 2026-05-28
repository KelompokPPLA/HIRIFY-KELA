<?php

namespace Database\Seeders;

use App\Models\SkillCourse;
use App\Models\SkillLesson;
use Illuminate\Database\Seeder;

class SkillTrainingSeeder extends Seeder
{
    public function run(): void
    {
        $courses = [
            [
                'title'           => 'Dasar-Dasar Python untuk Pemula',
                'description'     => 'Pelajari bahasa pemrograman Python dari nol. Cocok untuk siapa saja yang ingin memulai karier di bidang teknologi, data, atau otomasi.',
                'category'        => 'Programming',
                'level'           => 'beginner',
                'thumbnail_emoji' => '🐍',
                'instructor_name' => 'Ahmad Rizki',
                'estimated_hours' => 8,
                'is_free'         => true,
                'lessons'         => [
                    ['title' => 'Pengenalan Python & Instalasi', 'duration_minutes' => 15, 'content' => "# Pengenalan Python\n\nPython adalah bahasa pemrograman yang mudah dipelajari dan sangat populer di dunia.\n\n## Mengapa Python?\n- Sintaks yang bersih dan mudah dibaca\n- Komunitas yang besar\n- Digunakan di web development, data science, AI, dan otomasi\n\n## Instalasi\n1. Download Python dari python.org\n2. Pilih versi terbaru (3.x)\n3. Jalankan installer dan centang 'Add Python to PATH'\n4. Verifikasi instalasi: buka terminal, ketik `python --version`\n\n## Hello World\n```python\nprint('Hello, World!')\n```\n\nSelamat! Kamu sudah bisa menjalankan program Python pertama."],
                    ['title' => 'Variabel dan Tipe Data', 'duration_minutes' => 20, 'content' => "# Variabel dan Tipe Data\n\n## Variabel\nVariabel adalah tempat menyimpan data.\n\n```python\nnama = 'Budi'\numur = 25\ntinggi = 175.5\naktif = True\n```\n\n## Tipe Data Utama\n- **str** → teks/string\n- **int** → bilangan bulat\n- **float** → bilangan desimal\n- **bool** → True/False\n- **list** → kumpulan data `[1, 2, 3]`\n- **dict** → key-value `{'nama': 'Budi'}`\n\n## Cek Tipe Data\n```python\nprint(type(nama))   # <class 'str'>\nprint(type(umur))   # <class 'int'>\n```"],
                    ['title' => 'Kondisi dan Perulangan', 'duration_minutes' => 25, 'content' => "# Kondisi dan Perulangan\n\n## If-Else\n```python\nnilai = 80\n\nif nilai >= 90:\n    print('A')\nelif nilai >= 75:\n    print('B')\nelse:\n    print('C')\n```\n\n## For Loop\n```python\nbuah = ['apel', 'mangga', 'jeruk']\n\nfor item in buah:\n    print(item)\n\n# Output:\n# apel\n# mangga\n# jeruk\n```\n\n## While Loop\n```python\nhitung = 0\nwhile hitung < 5:\n    print(hitung)\n    hitung += 1\n```"],
                    ['title' => 'Fungsi dan Modul', 'duration_minutes' => 30, 'content' => "# Fungsi dan Modul\n\n## Membuat Fungsi\n```python\ndef sapa(nama):\n    return f'Halo, {nama}!'\n\npesan = sapa('Budi')\nprint(pesan)  # Halo, Budi!\n```\n\n## Parameter Default\n```python\ndef hitung_luas(panjang, lebar=10):\n    return panjang * lebar\n\nprint(hitung_luas(5))     # 50\nprint(hitung_luas(5, 3))  # 15\n```\n\n## Menggunakan Modul\n```python\nimport math\n\nprint(math.sqrt(16))  # 4.0\nprint(math.pi)        # 3.14159...\n```"],
                    ['title' => 'Proyek Mini: Kalkulator Sederhana', 'duration_minutes' => 20, 'content' => "# Proyek: Kalkulator Sederhana\n\nSaatnya praktik! Kita akan membuat kalkulator interaktif.\n\n```python\ndef kalkulator():\n    print('=== Kalkulator Sederhana ===')\n    \n    angka1 = float(input('Masukkan angka pertama: '))\n    operator = input('Operator (+, -, *, /): ')\n    angka2 = float(input('Masukkan angka kedua: '))\n    \n    if operator == '+':\n        hasil = angka1 + angka2\n    elif operator == '-':\n        hasil = angka1 - angka2\n    elif operator == '*':\n        hasil = angka1 * angka2\n    elif operator == '/':\n        if angka2 != 0:\n            hasil = angka1 / angka2\n        else:\n            print('Error: Tidak bisa dibagi nol!')\n            return\n    else:\n        print('Operator tidak valid!')\n        return\n    \n    print(f'Hasil: {angka1} {operator} {angka2} = {hasil}')\n\nkalkulator()\n```\n\nSelamat! Kamu sudah menyelesaikan kursus Python Dasar! 🎉"],
                ],
            ],
            [
                'title'           => 'UI/UX Design: Dari Konsep ke Prototype',
                'description'     => 'Kuasai prinsip desain antarmuka yang baik, user research, wireframing, dan prototyping menggunakan Figma untuk menciptakan produk digital yang intuitif.',
                'category'        => 'Design',
                'level'           => 'beginner',
                'thumbnail_emoji' => '🎨',
                'instructor_name' => 'Sarah Wijaya',
                'estimated_hours' => 10,
                'is_free'         => true,
                'lessons'         => [
                    ['title' => 'Prinsip Dasar UI/UX Design', 'duration_minutes' => 20, 'content' => "# Prinsip Dasar UI/UX Design\n\n## Apa itu UI vs UX?\n- **UI (User Interface)**: Tampilan visual produk — warna, tipografi, ikon, layout\n- **UX (User Experience)**: Keseluruhan pengalaman pengguna — kemudahan, kepuasan, efisiensi\n\n## 5 Prinsip Desain yang Baik\n1. **Hierarchy** — Tata urutan visual yang jelas\n2. **Consistency** — Elemen yang konsisten di seluruh produk\n3. **Accessibility** — Dapat digunakan semua orang\n4. **Feedback** — Respons terhadap aksi pengguna\n5. **Simplicity** — Sesederhana mungkin tanpa mengorbankan fungsi\n\n## Design Thinking Process\n1. Empathize → pahami pengguna\n2. Define → rumuskan masalah\n3. Ideate → brainstorm solusi\n4. Prototype → buat prototipe\n5. Test → uji dengan pengguna"],
                    ['title' => 'User Research & Persona', 'duration_minutes' => 25, 'content' => "# User Research & Persona\n\n## Mengapa User Research Penting?\nDesain yang baik dimulai dari memahami pengguna secara mendalam.\n\n## Metode User Research\n- **Interview** — Wawancara 1-on-1 dengan pengguna\n- **Survey** — Kuesioner untuk data kuantitatif\n- **Observation** — Amati pengguna menggunakan produk\n- **Usability Testing** — Uji kemudahan penggunaan\n\n## Membuat User Persona\nUser Persona adalah karakter fiksi yang merepresentasikan target pengguna.\n\n**Contoh Persona:**\n```\nNama: Budi Santoso, 28 tahun\nPekerjaan: Fresh Graduate\nGoal: Mencari pekerjaan pertama di bidang tech\nFrustration: Bingung cara membuat CV yang baik\nTech-savvy: Medium\n```\n\n## User Journey Map\nPetakan langkah-langkah yang dilakukan pengguna dari awal hingga tujuan tercapai."],
                    ['title' => 'Wireframing & Layout', 'duration_minutes' => 30, 'content' => "# Wireframing & Layout\n\n## Apa itu Wireframe?\nWireframe adalah sketsa kasar tampilan interface, fokus pada struktur bukan estetika.\n\n## Jenis Wireframe\n1. **Low-fidelity** — Sketsa tangan, cepat dan murah\n2. **Mid-fidelity** — Digital grayscale, lebih detail\n3. **High-fidelity** — Mendekati tampilan akhir\n\n## Prinsip Layout\n- **Grid System** — Gunakan 8px atau 12-column grid\n- **Whitespace** — Berikan ruang napas untuk elemen\n- **Alignment** — Ratakan elemen secara konsisten\n- **Proximity** — Elemen yang berhubungan harus berdekatan\n\n## Tools Wireframing\n- Figma (rekomendasi, gratis)\n- Sketch\n- Adobe XD\n- Balsamiq (low-fi)"],
                    ['title' => 'Prototyping di Figma', 'duration_minutes' => 35, 'content' => "# Prototyping di Figma\n\n## Setup Figma\n1. Daftar gratis di figma.com\n2. Buat file baru\n3. Pilih frame ukuran Mobile (390×844 untuk iPhone 14)\n\n## Komponen Dasar\n- **Frame** — Wadah halaman/screen\n- **Auto Layout** — Susun elemen otomatis\n- **Components** — Elemen yang bisa digunakan ulang\n- **Styles** — Warna, tipografi, efek yang konsisten\n\n## Membuat Prototype Interaktif\n1. Pilih elemen yang akan diklik\n2. Di panel Prototype, klik '+' pada Interactions\n3. Pilih trigger: 'On Click'\n4. Pilih action: 'Navigate to'\n5. Pilih frame tujuan\n\n## Sharing Prototype\nKlik tombol 'Share' → 'Copy link' → Bagikan ke tim atau penguji"],
                    ['title' => 'Design System & Handoff', 'duration_minutes' => 25, 'content' => "# Design System & Handoff\n\n## Apa itu Design System?\nKumpulan komponen, pola, dan panduan yang konsisten untuk seluruh produk.\n\n## Komponen Design System\n- **Color Palette** — Primary, secondary, semantic colors\n- **Typography** — Font, ukuran, weight, line-height\n- **Spacing** — Skala jarak yang konsisten\n- **Components** — Button, input, card, modal, dll\n- **Icons** — Library ikon yang konsisten\n\n## Membuat Color Palette\n```\nPrimary: #06CBE5 (Brand Cyan)\nSecondary: #0D1B3D (Deep Navy)\nSuccess: #0B7F53\nWarning: #B98007\nDanger: #B42318\nNeutral: #6C7A93\n```\n\n## Developer Handoff\n1. Gunakan Figma Dev Mode\n2. Pastikan semua komponen diberi nama yang jelas\n3. Tambahkan anotasi untuk interaksi kompleks\n4. Export asset dalam format yang tepat (SVG, PNG 2x)\n\nSelamat! Kamu sudah menyelesaikan kursus UI/UX Design! 🎨"],
                ],
            ],
            [
                'title'           => 'Data Analysis dengan Excel & Python',
                'description'     => 'Kuasai teknik analisis data menggunakan Excel dan Python (Pandas). Cocok untuk yang ingin berkarier di bidang business analyst atau data analyst.',
                'category'        => 'Data Science',
                'level'           => 'intermediate',
                'thumbnail_emoji' => '📊',
                'instructor_name' => 'Diana Putri',
                'estimated_hours' => 12,
                'is_free'         => true,
                'lessons'         => [
                    ['title' => 'Dasar-Dasar Analisis Data', 'duration_minutes' => 20, 'content' => "# Dasar-Dasar Analisis Data\n\n## Apa itu Data Analysis?\nProses memeriksa, membersihkan, dan memodelkan data untuk menemukan insight yang berguna.\n\n## Tipe Data\n- **Kuantitatif** — Angka (umur, pendapatan, jumlah)\n- **Kualitatif** — Kategori (jenis kelamin, kota, status)\n\n## Proses Analisis Data\n1. **Collect** — Kumpulkan data\n2. **Clean** — Bersihkan data kotor/missing\n3. **Explore** — Eksplorasi pola (EDA)\n4. **Analyze** — Terapkan teknik analisis\n5. **Visualize** — Buat visualisasi\n6. **Report** — Sampaikan insight\n\n## Tools yang Digunakan\n- Microsoft Excel / Google Sheets\n- Python (Pandas, NumPy, Matplotlib)\n- Tableau / Power BI (visualisasi lanjutan)"],
                    ['title' => 'Excel: Pivot Table & VLOOKUP', 'duration_minutes' => 30, 'content' => "# Excel: Pivot Table & VLOOKUP\n\n## Pivot Table\nAlat paling powerful di Excel untuk merangkum data dalam hitungan detik.\n\n**Cara Membuat:**\n1. Pilih data\n2. Insert → PivotTable\n3. Drag kolom ke area: Rows, Columns, Values, Filters\n\n**Contoh:** Hitung total penjualan per produk per bulan\n\n## Fungsi VLOOKUP\nMencari nilai di kolom dan mengembalikan nilai dari kolom lain.\n\n```excel\n=VLOOKUP(lookup_value, table_array, col_index, [range_lookup])\n\n# Contoh: Cari harga produk berdasarkan kode\n=VLOOKUP(A2, ProdukSheet!A:C, 3, FALSE)\n```\n\n## Fungsi Penting Lainnya\n- `SUMIF(range, criteria, sum_range)` — Jumlahkan dengan syarat\n- `COUNTIF(range, criteria)` — Hitung dengan syarat\n- `IF(condition, true, false)` — Kondisi"],
                    ['title' => 'Python Pandas: Load & Clean Data', 'duration_minutes' => 35, 'content' => "# Python Pandas: Load & Clean Data\n\n## Install Pandas\n```bash\npip install pandas openpyxl\n```\n\n## Load Data\n```python\nimport pandas as pd\n\n# Load CSV\ndf = pd.read_csv('data.csv')\n\n# Load Excel\ndf = pd.read_excel('data.xlsx', sheet_name='Sheet1')\n\n# Lihat data\nprint(df.head())       # 5 baris pertama\nprint(df.shape)        # (baris, kolom)\nprint(df.info())       # info tipe data\nprint(df.describe())   # statistik dasar\n```\n\n## Cleaning Data\n```python\n# Cek missing values\nprint(df.isnull().sum())\n\n# Hapus baris dengan missing value\ndf_clean = df.dropna()\n\n# Isi missing value\ndf['umur'].fillna(df['umur'].mean(), inplace=True)\n\n# Hapus duplikat\ndf.drop_duplicates(inplace=True)\n\n# Rename kolom\ndf.rename(columns={'nama_lama': 'nama_baru'}, inplace=True)\n```"],
                    ['title' => 'Visualisasi Data dengan Matplotlib', 'duration_minutes' => 30, 'content' => "# Visualisasi Data dengan Matplotlib\n\n## Install\n```bash\npip install matplotlib seaborn\n```\n\n## Bar Chart\n```python\nimport matplotlib.pyplot as plt\n\nkategori = ['Jan', 'Feb', 'Mar', 'Apr']\nnilai = [120, 150, 180, 130]\n\nplt.figure(figsize=(10, 6))\nplt.bar(kategori, nilai, color='#06CBE5')\nplt.title('Penjualan per Bulan')\nplt.xlabel('Bulan')\nplt.ylabel('Jumlah (juta)')\nplt.show()\n```\n\n## Line Chart\n```python\nplt.plot(kategori, nilai, marker='o', color='#0D1B3D', linewidth=2)\nplt.fill_between(range(len(nilai)), nilai, alpha=0.1)\n```\n\n## Seaborn untuk Distribusi\n```python\nimport seaborn as sns\n\nsns.histplot(df['umur'], bins=20, kde=True)\nsns.boxplot(x='kategori', y='nilai', data=df)\nsns.heatmap(df.corr(), annot=True, cmap='coolwarm')\n```"],
                    ['title' => 'Dashboard & Laporan Analisis', 'duration_minutes' => 25, 'content' => "# Dashboard & Laporan Analisis\n\n## Struktur Laporan yang Baik\n1. **Executive Summary** — Rangkuman 1 halaman untuk stakeholder\n2. **Temuan Utama** — 3-5 insight paling penting\n3. **Visualisasi** — Grafik yang mendukung argumen\n4. **Rekomendasi** — Tindakan yang disarankan\n5. **Metodologi** — Cara data dikumpulkan dan diproses\n\n## Membuat Dashboard di Google Sheets\n1. Siapkan data di sheet terpisah\n2. Buat Pivot Table untuk setiap metrik\n3. Insert chart dari pivot table\n4. Susun chart di sheet dashboard\n5. Tambahkan slicer untuk filter interaktif\n\n## Tips Presentasi Data\n- Pilih tipe grafik yang tepat untuk data yang ada\n- Batasi warna (max 3-4 warna)\n- Selalu tambahkan judul dan label yang jelas\n- Highlight angka penting\n- Ceritakan story di balik data\n\nSelamat! Kamu siap menjadi Data Analyst! 📊"],
                ],
            ],
            [
                'title'           => 'Digital Marketing & Personal Branding',
                'description'     => 'Pelajari strategi pemasaran digital modern, cara membangun personal brand yang kuat di LinkedIn, dan teknik content marketing yang efektif.',
                'category'        => 'Marketing',
                'level'           => 'beginner',
                'thumbnail_emoji' => '📢',
                'instructor_name' => 'Siti Rahayu',
                'estimated_hours' => 6,
                'is_free'         => true,
                'lessons'         => [
                    ['title' => 'Ekosistem Digital Marketing', 'duration_minutes' => 15, 'content' => "# Ekosistem Digital Marketing\n\n## Channel Digital Marketing\n- **SEO** — Optimasi mesin pencari\n- **SEM/Ads** — Iklan berbayar (Google, Meta)\n- **Social Media** — Instagram, LinkedIn, TikTok\n- **Email Marketing** — Newsletter dan campaign\n- **Content Marketing** — Blog, video, podcast\n\n## Funnel Marketing\n```\nAwareness → Consideration → Decision → Retention\n```\n\n## Metrik Penting\n- **Reach** — Berapa orang yang melihat konten\n- **Engagement** — Likes, comments, shares\n- **CTR** — Click-through rate\n- **Conversion** — Persentase yang melakukan aksi yang diinginkan\n- **ROI** — Return on investment"],
                    ['title' => 'Membangun Personal Brand di LinkedIn', 'duration_minutes' => 25, 'content' => "# Personal Brand di LinkedIn\n\n## Mengapa LinkedIn?\nLinkedIn adalah platform profesional #1 dengan 1 miliar pengguna. Rekruter aktif mencari kandidat di sini.\n\n## Optimasi Profil LinkedIn\n1. **Foto Profesional** — Background polos, wajah terlihat jelas\n2. **Headline** — Bukan hanya jabatan, tapi nilai yang kamu bawa\n   - ❌ 'Fresh Graduate'\n   - ✅ 'Aspiring Data Analyst | Python & Excel | Mencari peluang di tech'\n3. **About Section** — Ceritakan perjalanan dan ambisimu (max 300 karakter awal)\n4. **Experience** — Kuantifikasikan pencapaian\n   - ✅ 'Meningkatkan penjualan 30% dalam 3 bulan'\n5. **Skills & Endorsement** — Tambahkan skill yang relevan\n\n## Strategi Konten\n- Post 3-5x per minggu\n- Mix konten: insight industri, pengalaman pribadi, artikel\n- Engage dengan konten orang lain sebelum posting"],
                    ['title' => 'Content Marketing & Copywriting', 'duration_minutes' => 20, 'content' => "# Content Marketing & Copywriting\n\n## Formula Konten yang Menarik\n\n### AIDA\n- **A**ttention — Tarik perhatian di kalimat pertama\n- **I**nterest — Bangun ketertarikan dengan fakta/cerita\n- **D**esire — Ciptakan keinginan\n- **A**ction — Dorong aksi (CTA)\n\n## Tips Copywriting\n- Tulis untuk satu orang spesifik, bukan semua orang\n- Gunakan kalimat aktif, bukan pasif\n- Short sentences. Like this. Easy to read.\n- Gunakan angka dan data konkret\n- End dengan call-to-action yang jelas\n\n## Contoh Hook yang Kuat\n```\n❌ 'Hari ini saya ingin membahas tentang produktivitas'\n✅ 'Saya hampir menyerah setelah 3 bulan melamar kerja. Ini yang mengubahnya.'\n```"],
                ],
            ],
            [
                'title'           => 'Product Management: Dari Ide ke Produk',
                'description'     => 'Pelajari cara seorang Product Manager bekerja: dari riset pasar, mendefinisikan roadmap, berkolaborasi dengan tim, hingga meluncurkan produk yang dicintai pengguna.',
                'category'        => 'Product',
                'level'           => 'intermediate',
                'thumbnail_emoji' => '🚀',
                'instructor_name' => 'Budi Santoso',
                'estimated_hours' => 14,
                'is_free'         => false,
                'lessons'         => [
                    ['title' => 'Peran Product Manager', 'duration_minutes' => 20, 'content' => "# Peran Product Manager\n\n## PM adalah 'CEO Mini'\nPM bertanggung jawab atas keberhasilan produk namun tidak memiliki otoritas langsung atas tim.\n\n## Tanggung Jawab PM\n- Memahami kebutuhan user dan bisnis\n- Mendefinisikan visi dan strategi produk\n- Membuat dan mengelola product roadmap\n- Berkolaborasi dengan Engineering, Design, Marketing\n- Menganalisis data dan feedback pengguna\n- Memprioritaskan fitur\n\n## PM vs PO vs CPO\n- **PM (Product Manager)** — Mengelola satu atau beberapa fitur/produk\n- **PO (Product Owner)** — Fokus pada tim agile, mengelola backlog\n- **CPO (Chief Product Officer)** — Pemimpin seluruh strategi produk perusahaan\n\n## Skills yang Dibutuhkan\n- Analytical thinking\n- Communication\n- Technical understanding (tidak harus coding)\n- Empati terhadap pengguna\n- Prioritization"],
                    ['title' => 'Product Discovery & User Research', 'duration_minutes' => 30, 'content' => "# Product Discovery & User Research\n\n## Product Discovery\nProses memahami masalah yang perlu dipecahkan sebelum membangun solusi.\n\n## Jobs To Be Done (JTBD)\nFramework yang melihat produk dari sudut pandang 'pekerjaan' yang ingin diselesaikan pengguna.\n\n```\nKetika [situasi], saya ingin [motivasi], sehingga [hasil yang diharapkan]\n\nContoh:\nKetika melamar pekerjaan, saya ingin memiliki CV yang menonjol,\nsehingga saya bisa mendapat interview.\n```\n\n## Metode Discovery\n- **Customer Interview** — 1-on-1 selama 30-60 menit\n- **Survey** — Kuantitatif untuk validasi hipotesis\n- **Data Analysis** — Analisis behavior pengguna\n- **Competitive Analysis** — Pelajari kompetitor\n\n## Insight to Opportunity\n1. Kumpulkan data\n2. Sintesis temuan\n3. Buat opportunity tree\n4. Prioritaskan berdasarkan impact & effort"],
                    ['title' => 'Product Roadmap & Prioritization', 'duration_minutes' => 35, 'content' => "# Product Roadmap & Prioritization\n\n## Apa itu Roadmap?\nVisual plan yang menghubungkan visi produk dengan rencana eksekusi.\n\n## Jenis Roadmap\n- **Now-Next-Later** — Sederhana, cocok untuk startup\n- **Timeline-based** — Dengan estimasi waktu\n- **Outcome-based** — Fokus pada hasil, bukan fitur\n\n## Framework Prioritization\n\n### RICE Score\n```\nRICE = (Reach × Impact × Confidence) / Effort\n\nReach     = berapa user yang terdampak/bulan\nImpact    = 0.25 / 0.5 / 1 / 2 / 3\nConfidence= persentase yakin estimasi kita benar\nEffort    = person-months untuk implementasi\n```\n\n### MoSCoW\n- **Must Have** — Wajib ada\n- **Should Have** — Sebaiknya ada\n- **Could Have** — Bagus jika ada\n- **Won't Have** — Tidak dalam scope ini"],
                    ['title' => 'Agile & Scrum untuk PM', 'duration_minutes' => 25, 'content' => "# Agile & Scrum untuk PM\n\n## Agile Manifesto\nNilai-nilai inti:\n1. Individu & interaksi > proses & tools\n2. Software yang berjalan > dokumentasi\n3. Kolaborasi pelanggan > negosiasi kontrak\n4. Merespons perubahan > mengikuti rencana\n\n## Scrum Framework\n\n### Roles\n- **Product Owner** — Mengelola backlog\n- **Scrum Master** — Fasilitator tim\n- **Development Team** — Yang membangun produk\n\n### Events\n- **Sprint** — Iterasi 1-4 minggu\n- **Sprint Planning** — Rencanakan apa yang akan dibangun\n- **Daily Standup** — Update harian 15 menit\n- **Sprint Review** — Demo hasil sprint\n- **Retrospective** — Evaluasi cara kerja tim\n\n### Artifacts\n- **Product Backlog** — Semua item yang ingin dibangun\n- **Sprint Backlog** — Item untuk sprint ini\n- **Increment** — Produk yang bisa dirilis"],
                    ['title' => 'Product Launch & Metrics', 'duration_minutes' => 30, 'content' => "# Product Launch & Metrics\n\n## Go-To-Market Strategy\n1. **Define target audience** — Siapa yang akan pakai?\n2. **Value proposition** — Apa yang membedakan produk kita?\n3. **Pricing strategy** — Freemium, subscription, one-time?\n4. **Distribution channel** — App store, web, B2B sales?\n5. **Launch campaign** — Beta users, press release, influencer?\n\n## North Star Metric\nSatu metrik yang paling mencerminkan nilai yang produk berikan ke pengguna.\n\n```\nSpotify    → Minutes of music streamed\nAirbnb     → Nights booked\nFacebook   → Daily Active Users\nHirify     → Job placement success rate\n```\n\n## HEART Framework (Google)\n- **H**appiness — Kepuasan pengguna\n- **E**ngagement — Frekuensi penggunaan\n- **A**doption — Pengguna baru\n- **R**etention — Pengguna yang kembali\n- **T**ask Success — Berhasil menyelesaikan tugas\n\nSelamat menyelesaikan kursus Product Management! 🚀"],
                ],
            ],
            [
                'title'           => 'Public Speaking & Komunikasi Profesional',
                'description'     => 'Tingkatkan kemampuan berbicara di depan umum, presentasi yang persuasif, dan komunikasi efektif di lingkungan kerja profesional.',
                'category'        => 'Soft Skills',
                'level'           => 'beginner',
                'thumbnail_emoji' => '🎤',
                'instructor_name' => 'Rina Kusuma',
                'estimated_hours' => 5,
                'is_free'         => true,
                'lessons'         => [
                    ['title' => 'Mengatasi Rasa Takut Berbicara', 'duration_minutes' => 15, 'content' => "# Mengatasi Rasa Takut Berbicara\n\n## Kenyataan tentang Demam Panggung\nRasa gugup adalah NORMAL. Bahkan presenter berpengalaman pun merasakannya. Yang membedakan adalah cara mengelolanya.\n\n## Penyebab Rasa Takut\n- Takut dihakimi\n- Takut salah/lupa\n- Kurang persiapan\n- Pengalaman buruk di masa lalu\n\n## Teknik Mengatasi Gugup\n\n### Box Breathing\n```\nTarik napas 4 detik\nTahan 4 detik\nHembuskan 4 detik\nTahan 4 detik\n→ Ulangi 4 kali\n```\n\n### Power Pose\nSebelum presentasi, berdiri tegak dengan dada membusung selama 2 menit. Terbukti meningkatkan rasa percaya diri.\n\n### Reframe Rasa Gugup\nAlih-alih: 'Saya sangat gugup'\nGanti dengan: 'Saya sangat excited!'"],
                    ['title' => 'Struktur Presentasi yang Kuat', 'duration_minutes' => 20, 'content' => "# Struktur Presentasi yang Kuat\n\n## Formula Presentasi: SCR\n- **S**ituation — Konteks dan latar belakang\n- **C**omplication — Masalah atau tantangan\n- **R**esolution — Solusi yang kamu tawarkan\n\n## Opening yang Berkesan (30 detik pertama)\nOptions:\n- Mulai dengan pertanyaan provokatif\n- Fakta mengejutkan\n- Cerita singkat yang relatable\n- Quote yang relevan\n\n❌ **Jangan:** 'Perkenalkan nama saya... hari ini saya akan presentasi tentang...'\n\n✅ **Lakukan:** 'Bayangkan kamu sudah melamar 50 pekerjaan dan tidak ada satu pun yang merespons. Itu yang terjadi pada saya 2 tahun lalu. Dan inilah cara saya keluar dari situasi itu.'\n\n## Rule of Three\nOrang lebih mudah mengingat informasi yang dikelompokkan dalam tiga.\n'Ada 3 hal yang perlu kamu ketahui...'"],
                    ['title' => 'Body Language & Vokal', 'duration_minutes' => 20, 'content' => "# Body Language & Vokal\n\n## Body Language (55% dari komunikasi)\n\n### Postur\n- Berdiri tegak, kaki selebar bahu\n- Jangan menyilangkan tangan\n- Hadap ke audiens, bukan ke slide\n\n### Kontak Mata\n- Tatap satu orang selama 3-5 detik\n- Pindah ke orang lain secara bergantian\n- Jangan menghindari tatap mata\n\n### Gesture\n- Gunakan tangan untuk memperkuat poin\n- Hindari gesture yang berulang tanpa makna\n- Open palm = keterbukaan dan kejujuran\n\n## Vokal (38% dari komunikasi)\n\n### Variasi\n- **Tempo** — Lambat untuk poin penting, cepat untuk membangun energi\n- **Volume** — Lebih keras untuk penekanan\n- **Pitch** — Turunkan nada di akhir kalimat untuk otoritas\n- **Pause** — Diam sejenak setelah poin penting\n\n### Eliminasi Filler Words\n'Umm... eeee... jadi... ya...' → Ganti dengan DIAM."],
                ],
            ],
        ];

        foreach ($courses as $courseData) {
            $lessons = $courseData['lessons'];
            unset($courseData['lessons']);

            $course = SkillCourse::updateOrCreate(
                ['title' => $courseData['title']],
                $courseData
            );

            foreach ($lessons as $index => $lessonData) {
                SkillLesson::updateOrCreate(
                    [
                        'skill_course_id' => $course->id,
                        'order_number'    => $index + 1,
                    ],
                    [
                        'title'            => $lessonData['title'],
                        'content'          => $lessonData['content'],
                        'duration_minutes' => $lessonData['duration_minutes'],
                    ]
                );
            }
        }
    }
}
