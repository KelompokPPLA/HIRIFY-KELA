<?php

namespace App\Http\Controllers;

use App\Models\Cv;
use Barryvdh\DomPDF\Facade\Pdf;

class DownloadController extends Controller
{
    public function downloadPdf($id)
    {
        $cv = Cv::findOrFail($id);

        $pdf = Pdf::loadView('cv.presentasi.show', compact('cv'));

        return $pdf->download('CV-'.$cv->id.'.pdf');
    }
}