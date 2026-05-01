<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\SelfAssessment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class SelfAssessmentController extends Controller
{
    private function authUser()
    {
        return JWTAuth::parseToken()->authenticate();
    }

    public static function questions(): array
    {
        return [
            ['id' => 1,  'category' => 'Technical',    'text' => 'Seberapa mahir kamu dalam bahasa pemrograman atau tools teknis di bidangmu?'],
            ['id' => 2,  'category' => 'Technical',    'text' => 'Seberapa baik kamu memahami konsep arsitektur sistem atau desain solusi?'],
            ['id' => 3,  'category' => 'Analytical',   'text' => 'Seberapa baik kamu menganalisis data atau informasi untuk memecahkan masalah?'],
            ['id' => 4,  'category' => 'Analytical',   'text' => 'Seberapa mudah kamu mengidentifikasi pola atau tren dari informasi yang kompleks?'],
            ['id' => 5,  'category' => 'Communication','text' => 'Seberapa efektif kamu menyampaikan ide atau hasil kerja kepada tim?'],
            ['id' => 6,  'category' => 'Communication','text' => 'Seberapa baik kamu menulis dokumen teknis atau presentasi profesional?'],
            ['id' => 7,  'category' => 'Collaboration','text' => 'Seberapa baik kamu bekerja sama dalam tim lintas fungsi?'],
            ['id' => 8,  'category' => 'Collaboration','text' => 'Seberapa mudah kamu menerima dan memberikan feedback konstruktif?'],
            ['id' => 9,  'category' => 'Adaptability', 'text' => 'Seberapa cepat kamu mempelajari teknologi atau metode baru?'],
            ['id' => 10, 'category' => 'Adaptability', 'text' => 'Seberapa baik kamu mengelola perubahan prioritas atau tekanan deadline?'],
        ];
    }

    public function getQuestions(): JsonResponse
    {
        $this->authUser();
        return ResponseHelper::jsonResponse(true, 'Pertanyaan berhasil dimuat.', self::questions(), 200);
    }

    public function index(): JsonResponse
    {
        $user    = $this->authUser();
        $history = SelfAssessment::where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->limit(5)
            ->get()
            ->map(fn ($a) => [
                'id'          => $a->id,
                'score'       => $a->score,
                'level'       => $this->scoreLevel($a->score),
                'answers'     => json_decode($a->answers_json, true),
                'category_scores' => json_decode($a->category_scores_json, true),
                'created_at'  => $a->created_at->format('d M Y, H:i'),
            ]);

        return ResponseHelper::jsonResponse(true, 'Riwayat assessment berhasil dimuat.', $history, 200);
    }

    public function store(Request $request): JsonResponse
    {
        $user = $this->authUser();

        $request->validate([
            'answers'   => 'required|array|min:10',
            'answers.*' => 'required|integer|min:1|max:5',
        ]);

        $answers  = $request->answers;
        $questions = self::questions();

        $categoryTotals = [];
        $categoryCount  = [];
        foreach ($questions as $q) {
            $val = $answers[$q['id'] - 1] ?? $answers[$q['id']] ?? 3;
            $cat = $q['category'];
            $categoryTotals[$cat] = ($categoryTotals[$cat] ?? 0) + (int) $val;
            $categoryCount[$cat]  = ($categoryCount[$cat]  ?? 0) + 1;
        }

        $categoryScores = [];
        foreach ($categoryTotals as $cat => $total) {
            $categoryScores[$cat] = round(($total / ($categoryCount[$cat] * 5)) * 100);
        }

        $overallScore = round(array_sum($categoryScores) / count($categoryScores));

        $assessment = SelfAssessment::create([
            'user_id'             => $user->id,
            'answers_json'        => json_encode(array_values($answers)),
            'category_scores_json'=> json_encode($categoryScores),
            'score'               => $overallScore,
        ]);

        return ResponseHelper::jsonResponse(true, 'Assessment berhasil disimpan.', [
            'id'              => $assessment->id,
            'score'           => $overallScore,
            'level'           => $this->scoreLevel($overallScore),
            'category_scores' => $categoryScores,
        ], 201);
    }

    private function scoreLevel(int $score): string
    {
        return match (true) {
            $score >= 85 => 'Sangat Baik',
            $score >= 70 => 'Baik',
            $score >= 55 => 'Cukup',
            $score >= 40 => 'Perlu Ditingkatkan',
            default      => 'Masih Berkembang',
        };
    }
}
