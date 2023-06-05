<?php

namespace App\Http\Controllers\API\Admin;

use App\Models\Asset;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AdminAssetController extends Controller
{
    public function index()
    {
        $data = Asset::get();

        return response()->json([
            'success' => true,
            'message' => 'List data asset',
            'data' => $data,
        ]);
    }

    public function buat_asset(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'file_asset' => 'required|mimes:jpg,png,jpeg,svg'
        ]);

        $berkas = $request->file('file_asset');
        $nama = $berkas->getClientOriginalName();

        $data = Asset::create([
            'file_asset' => $berkas->storeAs('assets', $nama)
        ]);

        return response()->json([
            'message' => 'Data asset baru berhasil dibuat',
            'data' => $data,
        ]);
    }

    public function edit_asset(Request $request)
    {
        // $validator = Validator::make($request->all(),[
        //     'file_asset' => 'required|mimes:jpg,png,jpeg,svg'
        // ]);

        // if ($validator->fails()) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => $validator->errors(),
        //         'data' => [],
        //     ]);
        // }

        // try {
        //     $data = Asset::where('id', $id)->first();

        //     $berkas = $request->file('file_asset');
        //     $nama = $berkas->getClientOriginalName();

        //     $data->update([
        //         'file_asset' => '',
        //     ])
        // } catch (\Throwable $th) {
        //     //throw $th;
        // }
    }

    public function hapus_asset()
    {

    }
}
