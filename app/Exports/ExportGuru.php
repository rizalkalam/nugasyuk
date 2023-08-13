<?php

namespace App\Exports;

use App\Models\Guru;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Http\Resources\ExcelDataGuruResource;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ExportGuru implements FromCollection, WithHeadings, ShouldAutoSize, Responsable
{
    /**
    * @return \Illuminate\Support\Collection
    */

    use Exportable;

    private $fileName = 'nugasyuk_dataguru.xlsx';

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
        $db_guru = Guru::select([
            'id',
            'nama_guru',
            'email',
            'password',
            'niy',
            'alamat',
            'nomor_tlp',
            'foto_profile',
            'kode_id'
        ])->get();

        $data = ExcelDataGuruResource::collection($db_guru);
        return $data;
    }

    public function headings(): array
    {
        return [
            '#',
            'nama_guru',
            'email',
            'password',
            'niy',
            'alamat',
            'nomor_tlp',
            'foto_profile',
            'kode_id'
        ];
    }
}
