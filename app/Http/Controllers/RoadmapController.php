<?php

namespace App\Http\Controllers;

use App\Models\Roadmap;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RoadmapController extends Controller
{
    /**
     * Data roadmap per bidang karier.
     */
    private function getRoadmapData(): array
    {
        return [
            'Web Developer' => [
                ['step_order' => 1, 'step_title' => 'Fundamental Web', 'description' => 'Pelajari dasar-dasar HTML, CSS, dan JavaScript untuk membangun fondasi yang kuat.', 'skills' => ['HTML5', 'CSS3', 'JavaScript ES6+'], 'tools' => ['VS Code', 'Browser DevTools', 'Git'], 'activities' => ['Buat halaman HTML statis', 'Styling dengan CSS Flexbox/Grid', 'Latihan JavaScript dasar']],
                ['step_order' => 2, 'step_title' => 'Frontend Framework', 'description' => 'Kuasai framework modern untuk membangun antarmuka yang dinamis dan reaktif.', 'skills' => ['React.js', 'Vue.js', 'Tailwind CSS'], 'tools' => ['Node.js', 'npm/yarn', 'Vite'], 'activities' => ['Bangun SPA pertama Anda', 'Implementasi state management', 'Konsumsi REST API']],
                ['step_order' => 3, 'step_title' => 'Backend Development', 'description' => 'Pelajari server-side programming untuk membangun API dan logika bisnis.', 'skills' => ['PHP/Laravel', 'Node.js/Express', 'REST API'], 'tools' => ['Postman', 'MySQL', 'Redis'], 'activities' => ['Buat CRUD API', 'Implementasi JWT auth', 'Desain database relasional']],
                ['step_order' => 4, 'step_title' => 'DevOps & Deployment', 'description' => 'Pahami proses deployment dan manajemen infrastruktur modern.', 'skills' => ['Docker', 'CI/CD', 'Linux'], 'tools' => ['GitHub Actions', 'Nginx', 'VPS/Cloud'], 'activities' => ['Deploy aplikasi ke cloud', 'Setup pipeline CI/CD', 'Konfigurasi server Linux']],
            ],
            'Data Scientist' => [
                ['step_order' => 1, 'step_title' => 'Matematika & Statistika', 'description' => 'Bangun fondasi matematika yang diperlukan untuk machine learning.', 'skills' => ['Statistika', 'Aljabar Linear', 'Kalkulus'], 'tools' => ['Khan Academy', 'Coursera', 'Jupyter'], 'activities' => ['Pelajari distribusi probabilitas', 'Latihan regresi linear', 'Analisis data deskriptif']],
                ['step_order' => 2, 'step_title' => 'Python for Data', 'description' => 'Kuasai Python dan ekosistem data science untuk analisis data.', 'skills' => ['Python', 'Pandas', 'NumPy', 'Matplotlib'], 'tools' => ['Jupyter Notebook', 'Google Colab', 'Anaconda'], 'activities' => ['Eksplorasi dataset publik', 'Visualisasi data', 'Data cleaning & preprocessing']],
                ['step_order' => 3, 'step_title' => 'Machine Learning', 'description' => 'Pelajari algoritma ML dan penerapannya pada data nyata.', 'skills' => ['Scikit-learn', 'TensorFlow', 'Feature Engineering'], 'tools' => ['Kaggle', 'MLflow', 'Weights & Biases'], 'activities' => ['Ikuti kompetisi Kaggle', 'Bangun model klasifikasi', 'Evaluasi performa model']],
                ['step_order' => 4, 'step_title' => 'Data Engineering & MLOps', 'description' => 'Pahami deployment model dan pipeline data untuk production.', 'skills' => ['SQL', 'Spark', 'Airflow', 'Docker'], 'tools' => ['BigQuery', 'Databricks', 'FastAPI'], 'activities' => ['Deploy model sebagai API', 'Bangun data pipeline', 'Monitor model di production']],
            ],
            'UI/UX Designer' => [
                ['step_order' => 1, 'step_title' => 'Dasar Desain', 'description' => 'Pelajari prinsip-prinsip desain visual yang menjadi fondasi UI/UX.', 'skills' => ['Tipografi', 'Teori Warna', 'Layout & Komposisi'], 'tools' => ['Figma', 'Adobe Color', 'Pinterest'], 'activities' => ['Analisis desain aplikasi populer', 'Buat moodboard', 'Latihan wireframing']],
                ['step_order' => 2, 'step_title' => 'UX Research', 'description' => 'Kuasai metode riset pengguna untuk membuat desain berbasis data.', 'skills' => ['User Interview', 'Usability Testing', 'Persona'], 'tools' => ['Maze', 'Hotjar', 'Google Forms'], 'activities' => ['Lakukan user interview', 'Buat user persona', 'Analisis competitor']],
                ['step_order' => 3, 'step_title' => 'UI Design & Prototyping', 'description' => 'Buat desain antarmuka yang indah dan prototype yang interaktif.', 'skills' => ['Figma Advanced', 'Design System', 'Micro-interaction'], 'tools' => ['Figma', 'Principle', 'Lottie'], 'activities' => ['Redesign aplikasi nyata', 'Buat design system', 'Bangun prototype interaktif']],
                ['step_order' => 4, 'step_title' => 'Portfolio & Karier', 'description' => 'Bangun portofolio yang kuat untuk melamar posisi UI/UX Designer.', 'skills' => ['Case Study Writing', 'Storytelling', 'Presentation'], 'tools' => ['Behance', 'Notion', 'Medium'], 'activities' => ['Tulis 3 case study', 'Publish di Behance', 'Siapkan untuk interview']],
            ],
            'Digital Marketing' => [
                ['step_order' => 1, 'step_title' => 'Fundamental Marketing', 'description' => 'Pelajari konsep dasar pemasaran digital dan ekosistemnya.', 'skills' => ['Marketing Funnel', 'Customer Journey', 'Branding'], 'tools' => ['Google Analytics', 'Meta Business Suite', 'Canva'], 'activities' => ['Analisis campaign brand besar', 'Setup Google Analytics', 'Buat content calendar']],
                ['step_order' => 2, 'step_title' => 'SEO & Content Marketing', 'description' => 'Kuasai teknik optimasi mesin pencari dan pembuatan konten.', 'skills' => ['SEO On-Page', 'Keyword Research', 'Content Writing'], 'tools' => ['Ahrefs', 'SEMrush', 'Google Search Console'], 'activities' => ['Audit website SEO', 'Buat artikel SEO-friendly', 'Riset keyword kompetitor']],
                ['step_order' => 3, 'step_title' => 'Paid Advertising', 'description' => 'Pelajari iklan berbayar di platform digital utama.', 'skills' => ['Google Ads', 'Meta Ads', 'Retargeting'], 'tools' => ['Google Ads Manager', 'Meta Ads Manager', 'Facebook Pixel'], 'activities' => ['Jalankan campaign percobaan', 'Optimasi Cost Per Click', 'A/B testing iklan']],
                ['step_order' => 4, 'step_title' => 'Analytics & Strategi', 'description' => 'Analisis data untuk mengoptimalkan strategi marketing.', 'skills' => ['Data-Driven Marketing', 'A/B Testing', 'ROI Analysis'], 'tools' => ['Looker Studio', 'Tableau', 'HubSpot'], 'activities' => ['Buat dashboard marketing', 'Presentasi laporan kinerja', 'Susun strategi growth hacking']],
            ],
            'Mobile Developer' => [
                ['step_order' => 1, 'step_title' => 'Fundamental Pemrograman', 'description' => 'Kuasai bahasa pemrograman dasar untuk pengembangan mobile.', 'skills' => ['Dart/Kotlin/Swift', 'OOP', 'Git'], 'tools' => ['VS Code', 'Android Studio', 'Xcode'], 'activities' => ['Buat aplikasi Hello World', 'Pelajari OOP concepts', 'Latihan version control']],
                ['step_order' => 2, 'step_title' => 'Framework Mobile', 'description' => 'Pelajari framework untuk membangun aplikasi mobile cross-platform atau native.', 'skills' => ['Flutter', 'React Native', 'State Management'], 'tools' => ['Flutter SDK', 'Expo', 'Android Emulator'], 'activities' => ['Bangun aplikasi to-do list', 'Integrasi dengan API', 'Implementasi navigasi']],
                ['step_order' => 3, 'step_title' => 'Backend Integration', 'description' => 'Integrasikan aplikasi mobile dengan layanan backend dan cloud.', 'skills' => ['REST API', 'Firebase', 'Push Notification'], 'tools' => ['Firebase', 'Postman', 'Dio/Axios'], 'activities' => ['Implementasi login dengan Firebase', 'Buat fitur realtime', 'Tambahkan push notification']],
                ['step_order' => 4, 'step_title' => 'Publish & Monetisasi', 'description' => 'Pahami proses publikasi aplikasi ke app store dan strategi monetisasi.', 'skills' => ['App Store Optimization', 'In-App Purchase', 'Analytics'], 'tools' => ['Google Play Console', 'App Store Connect', 'Firebase Analytics'], 'activities' => ['Publish aplikasi ke Play Store', 'Implementasi in-app ads', 'Monitor performa aplikasi']],
            ],
        ];
    }

    /**
     * Tampilkan roadmap milik user yang sedang login.
     */
    public function index()
    {
        $user    = auth()->user();
        $roadmap = Roadmap::where('user_id', $user->id)->orderBy('step_order')->get();

        $careerFields    = array_keys($this->getRoadmapData());
        $selectedCareer  = $roadmap->first()?->career_field ?? null;
        $completedCount  = $roadmap->where('is_completed', true)->count();
        $totalCount      = $roadmap->count();
        $progressPercent = $totalCount > 0 ? round(($completedCount / $totalCount) * 100) : 0;

        return view('roadmap-karier.index', compact(
            'roadmap',
            'careerFields',
            'selectedCareer',
            'completedCount',
            'totalCount',
            'progressPercent'
        ));
    }

    /**
     * Simpan pilihan karier dan generate roadmap steps.
     */
    public function store(Request $request)
    {
        $request->validate([
            'career_field' => 'required|string',
        ]);

        $userId      = auth()->id();
        $careerField = $request->career_field;
        $allData     = $this->getRoadmapData();

        if (! isset($allData[$careerField])) {
            return back()->withErrors(['career_field' => 'Bidang karier tidak ditemukan.']);
        }

        // Hapus roadmap lama user ini
        Roadmap::where('user_id', $userId)->delete();

        // Buat roadmap baru berdasarkan pilihan
        foreach ($allData[$careerField] as $step) {
            Roadmap::create([
                'id'           => Str::uuid()->toString(),
                'user_id'      => $userId,
                'career_field' => $careerField,
                'step_title'   => $step['step_title'],
                'description'  => $step['description'],
                'skills'       => $step['skills'],
                'tools'        => $step['tools'],
                'activities'   => $step['activities'],
                'is_completed' => false,
                'step_order'   => $step['step_order'],
            ]);
        }

        return redirect()->route('roadmap-karier')->with('success', "Roadmap {$careerField} berhasil dibuat!");
    }

    /**
     * Update status selesai untuk satu step.
     */
    public function update(Request $request, string $id)
    {
        $step = Roadmap::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $step->update(['is_completed' => ! $step->is_completed]);

        return back()->with('success', $step->is_completed ? 'Step ditandai selesai!' : 'Step dibuka kembali.');
    }
}
