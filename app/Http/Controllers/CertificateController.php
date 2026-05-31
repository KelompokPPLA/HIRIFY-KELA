<?php

namespace App\Http\Controllers;

use App\Models\TrainingCertificate;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CertificateController extends Controller
{
    public function index()
    {
        $certificates = TrainingCertificate::where('user_id', Auth::id())
            ->orderByDesc('issued_at')
            ->get();

        $totalCertificates = $certificates->count();
        $latestCertificate = $certificates->first();

        return view('certificates.index', compact('certificates', 'totalCertificates', 'latestCertificate'));
    }

    public function show(int $id)
    {
        $certificate = TrainingCertificate::where('user_id', Auth::id())
            ->findOrFail($id);

        return view('certificates.show', compact('certificate'));
    }

    public function download(int $id)
    {
        $certificate = TrainingCertificate::where('user_id', Auth::id())
            ->findOrFail($id);

        $pdf = Pdf::loadView('certificates.pdf', compact('certificate'))
            ->setPaper('a4', 'landscape');

        $filename = 'Sertifikat-' . str_replace(' ', '-', $certificate->course_title) . '-Hirify.pdf';

        return $pdf->download($filename);
    }

    public function generateForCompleted()
    {
        $user = Auth::user();

        $completedEnrollments = \App\Models\SkillEnrollment::with('course')
            ->where('user_id', $user->id)
            ->whereNotNull('completed_at')
            ->get();

        $generated = 0;
        foreach ($completedEnrollments as $enrollment) {
            if ($enrollment->course) {
                $existing = \App\Models\TrainingCertificate::where('user_id', $user->id)
                    ->where('skill_course_id', $enrollment->skill_course_id)
                    ->first();
                if (! $existing) {
                    \App\Models\TrainingCertificate::issueForEnrollment($user, $enrollment->course);
                    $generated++;
                }
            }
        }

        return redirect()->route('certificates.index')
            ->with('success', $generated > 0
                ? "{$generated} sertifikat berhasil digenerate!"
                : 'Semua sertifikat sudah tersedia.');
    }

    public function verify(Request $request)
    {
        $code = $request->query('code');

        if (! $code) {
            return view('certificates.verify', ['certificate' => null, 'searched' => false]);
        }

        $certificate = TrainingCertificate::where('verification_code', strtoupper($code))->first();

        return view('certificates.verify', [
            'certificate' => $certificate,
            'searched'    => true,
            'code'        => $code,
        ]);
    }
}
