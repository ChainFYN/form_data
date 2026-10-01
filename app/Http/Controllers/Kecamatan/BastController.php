<?php

namespace App\Http\Controllers\Kecamatan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BastController extends Controller
{
    public function index()
    {
        return view('kecamatan.bast.index');
    }
}
