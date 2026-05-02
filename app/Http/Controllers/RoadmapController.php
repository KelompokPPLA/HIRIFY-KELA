<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class RoadmapController extends Controller
{
    private function authUser()
    {
        return JWTAuth::parseToken()->authenticate();
    }

    private static function paths(): array
    {
        return [
            [
                'id' => 'frontend', 'title' => 'Frontend Developer', 'icon' => '🖥️',
                'description' => 'Kuasai HTML, CSS, JavaScript, dan framework modern untuk membangun UI yang responsif dan interaktif.',
                'duration' => '6-12 bulan', 'level' => 'Pemula - Menengah',
                'milestones' => [
                    ['step' => 1, 'title' => 'HTML & CSS Dasar', 'desc' => 'Semantic HTML, Flexbox, Grid, Responsive Design'],
                    ['step' => 2, 'title' => 'JavaScript Fundamental', 'desc' => 'ES6+, DOM Manipulation, Fetch API, Async/Await'],
                    ['step' => 3, 'title' => 'Version Control', 'desc' => 'Git, GitHub, branching strategy, pull requests'],
                    ['step' => 4, 'title' => 'React / Vue.js', 'desc' => 'Component-based UI, State management, Routing'],
                    ['step' => 5, 'title' => 'Build Tools & Testing', 'desc' => 'Webpack/Vite, Jest, unit & integration testing'],
                    ['step' => 6, 'title' => 'Portfolio & Job Ready', 'desc' => '3+ projects, CV ATS, GitHub profile, interview prep'],
                ],
            ],
            [
                'id' => 'backend', 'title' => 'Backend Developer', 'icon' => '⚙️',
                'description' => 'Bangun API yang robust dan skalabel menggunakan PHP Laravel, Node.js, atau Python.',
                'duration' => '6-12 bulan', 'level' => 'Pemula - Menengah',
                'milestones' => [
                    ['step' => 1, 'title' => 'Pemrograman Dasar', 'desc' => 'PHP/Python/Node.js fundamentals, OOP principles'],
                    ['step' => 2, 'title' => 'Database & SQL', 'desc' => 'MySQL/PostgreSQL, query optimization, indexing'],
                    ['step' => 3, 'title' => 'RESTful API', 'desc' => 'REST principles, HTTP methods, authentication (JWT)'],
                    ['step' => 4, 'title' => 'Framework', 'desc' => 'Laravel/Express/Django, MVC pattern, middleware'],
                    ['step' => 5, 'title' => 'Security & Performance', 'desc' => 'OWASP top 10, caching, rate limiting'],
                    ['step' => 6, 'title' => 'Deployment', 'desc' => 'Docker, CI/CD, cloud deployment (AWS/GCP)'],
                ],
            ],
            [
                'id' => 'fullstack', 'title' => 'Full Stack Developer', 'icon' => '🚀',
                'description' => 'Kombinasikan skill frontend dan backend untuk membangun aplikasi web end-to-end.',
                'duration' => '12-18 bulan', 'level' => 'Menengah - Mahir',
                'milestones' => [
                    ['step' => 1, 'title' => 'Frontend Fundamentals', 'desc' => 'HTML, CSS, JavaScript, React/Vue'],
                    ['step' => 2, 'title' => 'Backend Fundamentals', 'desc' => 'Node.js/Laravel, REST API, database'],
                    ['step' => 3, 'title' => 'Database Design', 'desc' => 'Schema design, normalization, migrations'],
                    ['step' => 4, 'title' => 'Authentication & Security', 'desc' => 'JWT, OAuth, HTTPS, input validation'],
                    ['step' => 5, 'title' => 'DevOps Basics', 'desc' => 'Git, Docker, basic CI/CD pipeline'],
                    ['step' => 6, 'title' => 'Full Project', 'desc' => 'Build & deploy complete SaaS application'],
                ],
            ],
            [
                'id' => 'datascience', 'title' => 'Data Scientist', 'icon' => '📊',
                'description' => 'Analisis data, bangun model ML, dan ciptakan insight bisnis yang berharga.',
                'duration' => '9-15 bulan', 'level' => 'Pemula - Mahir',
                'milestones' => [
                    ['step' => 1, 'title' => 'Python & Statistics', 'desc' => 'Python, NumPy, Pandas, descriptive statistics'],
                    ['step' => 2, 'title' => 'Data Visualization', 'desc' => 'Matplotlib, Seaborn, Tableau, storytelling with data'],
                    ['step' => 3, 'title' => 'SQL & Database', 'desc' => 'Advanced SQL queries, data warehousing concepts'],
                    ['step' => 4, 'title' => 'Machine Learning', 'desc' => 'Scikit-learn, regression, classification, clustering'],
                    ['step' => 5, 'title' => 'Deep Learning', 'desc' => 'TensorFlow/PyTorch, neural networks, NLP basics'],
                    ['step' => 6, 'title' => 'MLOps & Portfolio', 'desc' => 'Model deployment, Kaggle competitions, projects'],
                ],
            ],
            [
                'id' => 'uiux', 'title' => 'UI/UX Designer', 'icon' => '🎨',
                'description' => 'Rancang pengalaman pengguna yang intuitif dan antarmuka yang indah secara visual.',
                'duration' => '6-9 bulan', 'level' => 'Pemula - Menengah',
                'milestones' => [
                    ['step' => 1, 'title' => 'Design Fundamentals', 'desc' => 'Typography, color theory, layout, visual hierarchy'],
                    ['step' => 2, 'title' => 'UX Research', 'desc' => 'User interviews, personas, journey mapping, usability testing'],
                    ['step' => 3, 'title' => 'Wireframing', 'desc' => 'Low-fidelity wireframes, information architecture'],
                    ['step' => 4, 'title' => 'Figma Mastery', 'desc' => 'Components, auto-layout, prototyping, design systems'],
                    ['step' => 5, 'title' => 'Interaction Design', 'desc' => 'Micro-interactions, animation principles, handoff'],
                    ['step' => 6, 'title' => 'Portfolio & Case Studies', 'desc' => '3+ case studies, Behance/Dribbble, interview ready'],
                ],
            ],
            [
                'id' => 'digitalmarketing', 'title' => 'Digital Marketing', 'icon' => '📣',
                'description' => 'Kuasai strategi pemasaran digital untuk mendorong pertumbuhan bisnis online.',
                'duration' => '4-8 bulan', 'level' => 'Pemula - Menengah',
                'milestones' => [
                    ['step' => 1, 'title' => 'Marketing Fundamentals', 'desc' => 'Consumer behavior, brand strategy, marketing mix'],
                    ['step' => 2, 'title' => 'SEO & Content', 'desc' => 'On-page SEO, keyword research, content strategy'],
                    ['step' => 3, 'title' => 'Social Media Marketing', 'desc' => 'Platform strategy, content calendar, community management'],
                    ['step' => 4, 'title' => 'Paid Advertising', 'desc' => 'Google Ads, Meta Ads, campaign optimization'],
                    ['step' => 5, 'title' => 'Analytics & Data', 'desc' => 'Google Analytics, conversion tracking, A/B testing'],
                    ['step' => 6, 'title' => 'Growth Strategy', 'desc' => 'Funnel optimization, retention, email marketing'],
                ],
            ],
        ];
    }

    public function index(): JsonResponse
    {
        $user    = $this->authUser();
        $profile = $user->profile;
        $selectedPath = $profile?->career_path ?? null;

        return ResponseHelper::jsonResponse(true, 'Roadmap berhasil dimuat.', [
            'paths'         => self::paths(),
            'selected_path' => $selectedPath,
        ], 200);
    }

    public function select(Request $request): JsonResponse
    {
        $user = $this->authUser();

        $request->validate(['path_id' => 'required|string|max:50']);

        $pathIds = array_column(self::paths(), 'id');
        if (!in_array($request->path_id, $pathIds)) {
            return ResponseHelper::jsonResponse(false, 'Path tidak valid.', null, 422);
        }

        if ($user->profile) {
            $user->profile->update(['career_path' => $request->path_id]);
        } else {
            $user->profile()->create(['first_name' => explode(' ', $user->name)[0], 'career_path' => $request->path_id]);
        }

        return ResponseHelper::jsonResponse(true, 'Jalur karier berhasil dipilih.', ['selected_path' => $request->path_id], 200);
    }
}
