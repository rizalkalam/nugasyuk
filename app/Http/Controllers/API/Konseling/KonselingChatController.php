<?php

namespace App\Http\Controllers\API\Konseling;

use App\Models\Percakapan;
use Illuminate\Http\Request;
use App\Events\MessageCreated;
use App\Http\Controllers\Controller;

class KonselingChatController extends Controller
{
    public function show($user_two)
    {
        $user_one = auth()->user()->id;

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
            'murid_id'=> $percakapan->user_two,
            'guru_id' => auth()->user()->id,
        ]);

        broadcast(new MessageCreated($pesan));
        
        return response()->json([
            'data' => $pesan,
            'status' => 'Success'
        ]);
    }
}
