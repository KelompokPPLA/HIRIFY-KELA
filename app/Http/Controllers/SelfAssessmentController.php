<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Assessment;
use App\Models\Question;
use Illuminate\Http\Request;

class SelfAssessmentController extends Controller
{
    /**
     * Tampilkan halaman soal self-assessment.
     */
    public function index()
    {
        $user        = auth()->user();
        $questions   = Question::all();
        $lastResult  = Assessment::where('user_id', $user->id)->latest()->first();
        $userAnswers = Answer::where('user_id', $user->id)
            ->pluck('score', 'question_id');

        return view('self-assessment.index', compact('questions', 'lastResult', 'userAnswers'));
    }

    /**
     * Simpan jawaban dan hitung skor.
     */
    public function store(Request $request)
    {
        $userId    = auth()->id();
        $questions = Question::all();

        $request->validate([
            'answers'   => 'required|array',
            'answers.*' => 'required|integer|min:1|max:5',
        ]);

        // Hapus jawaban lama
        Answer::where('user_id', $userId)->delete();

        $totalScore = 0;

        foreach ($request->answers as $questionId => $score) {
            Answer::create([
                'user_id'     => $userId,
                'question_id' => $questionId,
                'score'       => $score,
            ]);
            $totalScore += (int) $score;
        }

        // Tentukan kategori hasil
        $result = match (true) {
            $totalScore < 30  => 'Kurang',
            $totalScore <= 55 => 'Cukup',
            default           => 'Siap',
        };

        // Hapus hasil assessment lama, simpan yang baru
        Assessment::where('user_id', $userId)->delete();
        Assessment::create([
            'user_id'     => $userId,
            'total_score' => $totalScore,
            'result'      => $result,
        ]);

        return redirect()->route('assessment.result');
    }

    /**
     * Tampilkan hasil assessment.
     */
    public function result()
    {
        $userId     = auth()->id();
        $assessment = Assessment::where('user_id', $userId)->latest()->firstOrFail();
        $answers    = Answer::where('user_id', $userId)->with('question')->get();
        $maxScore   = Question::count() * 5;

        return view('self-assessment.result', compact('assessment', 'answers', 'maxScore'));
    }
}
