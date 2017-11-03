<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SlideController extends Controller
{
    public function index(Request $request){


        return view('slide/index',['date' => date('Y-m-d')]);
    }
}
