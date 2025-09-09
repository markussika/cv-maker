<?php

namespace App\Http\Controllers;

class TemplateController extends Controller
{
    public function index()
    {
        return view('templates.index');
    }
}
