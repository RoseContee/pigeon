<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index() {
        return view('index');
    }

    public function privacy() {
        return view('privacy');
    }

    public function terms() {
        return view('terms');
    }

    public function how() {
        return view('how');
    }
}
