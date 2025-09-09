<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class CvController extends Controller
{
    /**
     * Show CV creation form
     */
    public function create()
    {
        return view('cv.form');
    }

    /**
     * Preview CV with user data
     */
    public function preview(Request $request)
    {
        $data = $request->all(); // visi form dati
        return view('cv.preview', compact('data'));
    }

    /**
     * Generate PDF from CV
     */
    public function pdf(Request $request)
    {
        $data = json_decode($request->data, true); // parse JSON no hidden input
        $pdf = Pdf::loadView('cv.pdf', compact('data'));
        $filename = ($data['first_name'] ?? 'CV') . '.pdf';
        return $pdf->download($filename);
    }
}
