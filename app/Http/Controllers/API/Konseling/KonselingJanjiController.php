<?php

namespace App\Http\Controllers\API\Konseling;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KonselingJanjiController extends Controller
{
    public function index()
    {
        return response()->json([
            "success" => true,
            "message" => "Data muncul",
            "data" => "tes"
        ], 200);
    }
}
