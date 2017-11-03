<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function getMapSvg(){


        return response(file_get_contents('./images/svg/korea.svg'));
    }
}
