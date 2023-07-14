<?php

namespace App\Http\Controllers\API\Murid;

use App\Models\Pesan;
use App\Models\Percakapan;
use Illuminate\Http\Request;
use App\Events\MessageCreated;
use App\Http\Controllers\Controller;

class KonselingController extends Controller
{
    public function show($user_one)
    {
        $user_two = auth()->user()->id;

        $percakapan = Percakapan::where(function ($query) use ($user_one, $user_two){
            $query->where(['user_one' => $user_one, 'user_two' => $user_two]);
        
        })->with('pesans')->first();

        return response()->json([
            'data' => $percakapan
        ]);
    }

    public function store(Request $request, Percakapan $percakapan)
    {
        $pesan = $percakapan->pesans()->create([
            'percakapan_id' => $percakapan->id,
            'isi' => $request->isi,
            'murid_id'=> auth()->user()->id,
            'guru_id' => $percakapan->user_one
        ]);

        MessageCreated::dispatch($pesan);

        return response()->json([
            'data' => $pesan,
            'status' => 'Success'
        ]);
    }
}
