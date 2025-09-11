<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Cv;

class CvController extends Controller
{
    public function create(){
        return view('cv.form');
    }

    public function preview(Request $request){
        $data = $request->validate([
            'first_name'=>'required|string|max:255',
            'last_name'=>'required|string|max:255',
            'email'=>'required|email',
            'phone'=>'nullable|string|max:50',
            'profile_image'=>'nullable|image|max:2048',
            'work_experience'=>'nullable|array',
            'education'=>'nullable|array',
            'skills'=>'nullable|array',
            'hobbies'=>'nullable|array',
            'languages'=>'nullable|array',
            'extra_curriculum_activities'=>'nullable|array',
        ]);

        // Saglabā profile image
        if($request->hasFile('profile_image')){
            $data['profile_image'] = $request->file('profile_image')->store('profile_images','public');
        }

        // Saglabā lietotāja CV DB
        $cv = Cv::updateOrCreate(
            ['user_id'=>auth()->id()],
            $data
        );

        return view('cv.preview', compact('data'));
    }

    public function pdf(Request $request){
        $data = $request->all();
        $pdf = Pdf::loadView('cv.pdf', compact('data'));
        return $pdf->download('cv.pdf');
    }
}
