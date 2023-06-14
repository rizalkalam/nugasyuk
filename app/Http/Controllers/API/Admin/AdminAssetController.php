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

    public function hapus_asset($id)
    {
        $file_path = Asset::where('id', $id)->value('file_asset');
        Storage::delete($file_path);

        $asset = Asset::where('id', $id)->first();
        $asset->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data asset berhasil dihapus',
        ]);
    }
}
