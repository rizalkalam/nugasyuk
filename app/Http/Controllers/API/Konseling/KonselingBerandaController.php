<?php

namespace App\Http\Controllers\API\Konseling;

use App\Models\Guru;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class KonselingBerandaController extends Controller
{
    public function index()
    {
        $data = Guru::where('id', auth()->user()->id)->get();
        return response()->json([
            "data" => $data
        ], 200);
    }
}
