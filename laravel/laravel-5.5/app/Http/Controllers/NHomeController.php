<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NHomeController extends Controller
{
    //
    public function __invoke() {
        // TODO: Implement __invoke() method.
        return view('components');
    }
}
