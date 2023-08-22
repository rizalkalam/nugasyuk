<?php

namespace App\Exports;

use App\Models\Guru;
use App\Models\Murid;
use App\Http\Resources\ExcelDataGuruResource;
use App\Http\Resources\ExcelDataMuridResource;
use Maatwebsite\Excel\Concerns\FromCollection;

class MuridExport implements FromCollection, WithHeadings, ShouldAutoSize, Responsable
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;

    private $fileName = 'nugasyuk_datamurid.xlsx';

    private $response = [
        'success' => true,
        'message' => 'berhasil export data',
    ];

    private $headers = [
        'Content-Type' => 'application/json',
        'ngrok-skip-browser-warning'=>'any'
    ];  
    
    public function collection()
    {
        $db_murid = Murid::select([
            'id',
            'nis',
            'nama_panggilan',
            'nama_siswa',
            'email',
            'password',
            'alamat',
            'foto_profile',
            'kelas_id'
        ])->get();

        $data = ExcelDataMuridResource::collection($db_murid);
        return $data;
    }

    public function headings(): array
    {
        return [
            'id',
            'nis',
            'nama_panggilan',
            'nama_siswa',
            'email',
            'password',
            'alamat',
            'nama_wali',
            'email_wali',
            'password_wali',
            'foto_profile',
            'kelas'
        ];
    }
}
