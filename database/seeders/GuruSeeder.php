<?php

namespace Database\Seeders;

use App\Models\Guru;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class GuruSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $guru = Guru::create([
            // 'id'=>'1',
            'nama_guru'=>'Joko Arianto',
            'email'=>'jokoarysbi@gmail.com',
            'password'=>bcrypt('2023_Joko_0111'),
            'niy'=>'0111',
            'alamat'=>'Fajar Indah, Surakarta',
            'nomor_tlp'=>'085842220006',
            'foto_profile'=>'gambar_profile_guru/mrjack.jpg',
            'kode_id'=>1,
            // 'role_id'=>2
        ]);

        $guru->assignRole('guru_biasa');

        $guru = Guru::create([
            // 'id'=>'2',
            'nama_guru'=>'Rizki Hidayat',
            'email'=>'rizkiganteng@gmail.com',
            'password'=>bcrypt('2023_Rizki_0112'),
            'niy'=>'0112',
            'alamat'=>'Ngemplak, Boyolali',
            'nomor_tlp'=>'085728838642',
            'foto_profile'=>'gambar_profile_guru/mrrizky.jpg',
            'kode_id'=>2,
            // 'mapel2_id'=>3
        ]);

        $guru->assignRole('guru_biasa');

        $guru = Guru::create([
            // 'id'=>'3',
            'nama_guru'=>'Musfiq Amrullah',
            'email'=>'mrmusfiq@gmail.com',
            'password'=>bcrypt('2023_Musfiq_0113'),
            'niy'=>'0113',
            'alamat'=>'Gatak, Sukoharjo',
            'nomor_tlp'=>'081676893341',
            'foto_profile'=>'gambar_profile_guru/musfiq.jpg',
            'kode_id'=>4,
        ]);

        $guru->assignRole('guru_biasa');

        $guru = Guru::create([
             // 'id'=>'4',
             'nama_guru'=>'Lestari',
             'email'=>'estes@gmail.com',
             'password'=>bcrypt('2023_Lestari_0114'),
             'niy'=>'0114',
             'alamat'=>'Colomadu, Karanganyar',
             'nomor_tlp'=>'085647511650',
             'foto_profile'=>'gambar_profile_guru/lestari.jpg',
             'kode_id'=>5,
        ]);

        $guru->assignRole('guru_biasa');

        $guru = Guru::create([
            // 'id'=>'5',
            'nama_guru'=>'Isyana Putri',
            'email'=>'isyana@gmail.com',
            'password'=>bcrypt('2023_Isyana_0115'),
            'niy'=>'0115',
            'alamat'=>'Simo, Boyolali',
            'nomor_tlp'=>'089844872221',
            'foto_profile'=>'gambar_profile_guru/picturesshot.jpg',
            'kode_id'=>6,
        ]);

        $guru->assignRole('guru_biasa');

        $guru = Guru::create([
            // 'id'=>'6'
            'nama_guru'=>'Hana Cinta Saraswati',
            'email'=>'heycinta@gmail.com',
            'password'=>bcrypt('2023_Hana_0116'),
            'niy'=>'0116',
            'alamat'=>'Pasar Kliwon, Surakarta',
            'nomor_tlp'=>'085155370503',
            'foto_profile'=>'gambar_profile_guru/ustdz-hana.jpg',
            'kode_id'=>7,
        ]);

        $guru->assignRole('guru_biasa');

        $guru = Guru::create([
            // 'id'=>'7',
            'nama_guru'=>'Sandita',
            'email'=>'sandita@gmail.com',
            'password'=>bcrypt('2023_Sandita_0117'),
            'niy'=>'0117',
            'alamat'=>'Banjarsari, Surakarta',
            'nomor_tlp'=>'089523051222',
            'foto_profile'=>'gambar_profile_guru/sandita.jpg',
            'kode_id'=>8,
            // 'role_id'=>2
        ]);

        $guru->assignRole('guru_biasa');

        $bk = Guru::create([
            // 'id'=>'8',
            'nama_guru'=>'Ana Ramadhani',
            'email'=>'anarmdhn@gmail.com',
            'password'=>bcrypt('2023_Ana_0118'),
            'niy'=>'0118',
            'alamat'=>'Palur, Sukoharjo',
            'nomor_tlp'=>'085789895342',
            'foto_profile'=>'gambar_profile_guru/alyssaseobandono.jpg',
            'kode_id'=>9,
            // 'role_id'=>2
        ]);

        $bk->assignRole('guru_bk');

        $bk = Guru::create([
            // 'id'=>'9',
            'nama_guru'=>'Widyasih',
            'email'=>'asih@gmail.com',
            'password'=>bcrypt('2023_Widyasih_0119'),
            'niy'=>'0119',
            'alamat'=>'Begajah, Sukoharjo',
            'nomor_tlp'=>'085789796121',
            'foto_profile'=>'gambar_profile_guru/alyssaseobandono.jpg',
            'kode_id'=>10,
            // 'role_id'=>2
        ]);

        $bk->assignRole('guru_bk');
    }
}
