<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KeluargaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('keluargas')->insert([
            'id' => 1,
            'nama' => 'Official Alm. Ma. Haya',
            'jenis_kelamin' => 'Laki-Laki',
            'tempat_lahir' => 'Garut',
            'tanggal_lahir' => '02',
            'no_hp' => '0898',
            'alamat' => 'cihanja',
            'pekerjaan' => 'Pengurus',
            'nik' => '001',
            'keluarga_id' => '1',
            'hubungan' => '',
            'tugu' => '',
            'foto' => 'img/keluarga/50271431012020_female.jpg',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('keluargas')->insert([
            'id' => 2,
            'nama' => 'Alm. Ano',
            'jenis_kelamin' => 'Perempuan',
            'tempat_lahir' => 'Garut',
            'tanggal_lahir' => '02',
            'no_hp' => '0898',
            'alamat' => 'cihanja',
            'pekerjaan' => 'Tidak Bekerja',
            'nik' => '002',
            'keluarga_id' => '2',
            'hubungan' => '',
            'tugu' => '',
            'foto' => 'img/keluarga/50271431012020_female.jpg',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('keluargas')->insert([
            'id' => 3,
            'nama' => 'Alm. Ma Haya',
            'jenis_kelamin' => 'Perempuan',
            'tempat_lahir' => 'Garut',
            'tanggal_lahir' => '02',
            'no_hp' => '0898',
            'alamat' => 'cihanja',
            'pekerjaan' => 'Tidak Bekerja',
            'nik' => '003',
            'keluarga_id' => '2',
            'hubungan' => 'Anak',
            'tugu' => 'ya',
            'foto' => 'img/keluarga/50271431012020_female.jpg',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }
}
