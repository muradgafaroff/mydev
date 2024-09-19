<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ValueController extends Controller
{
    public function value()
    {

        return view('pages.value');

    }
}
