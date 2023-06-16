<?php

namespace App\Http\Controllers\API\Admin;

use App\Models\Asset;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
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
            'file_asset' => 'required|mimes:jpg,png,jpeg,svg|file|size:2048',
            'file_vector' => 'required|mimes:jpg,png,jpeg,svg|file|size:2048',
            'vector' => 'required'
        ]);

        //image
        $file_asset = $request->file('file_asset');
        $nama_asset = $file_asset->getClientOriginalName();

        //vector
        $file_vector = $request->file('file_vector');
        $nama_vector = $file_vector->getClientOriginalName();

        $data = Asset::create([
            'file_asset' => $berkas->storeAs('assets', $nama_asset)
        ]);

        return response()->json([
            'message' => 'Data asset baru berhasil dibuat',
            'data' => $data,
        ]);
    }

    public function hapus_asset($id)
    {
        $file_asset = Asset::where('id', $id)->value('file_asset');
        Storage::delete($file_asset);

        $file_vector = Asset::where('id', $id)->value('file_vector');
        Storage::delete($file_vector);

        $asset = Asset::where('id', $id)->first();
        $asset->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data asset berhasil dihapus',
        ]);
    }
}
