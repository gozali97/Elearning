<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Kelas;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // X -> kelas/angkatan, MIPA -> jurusan, 1 -> ruang kelas ke-n
        Kelas::create([
            'nama_kelas' => 'X MIPA 1',
            'jurusan_id' => '1'
        ]);
        Kelas::create([
            'nama_kelas' => 'X MIPA 2',
            'jurusan_id' => '1'
        ]);
        Kelas::create([
            'nama_kelas' => 'X MIPA 3',
            'jurusan_id' => '1'
        ]);

        Kelas::create([
            'nama_kelas' => 'X IPS 1',
            'jurusan_id' => '2'
        ]);
        Kelas::create([
            'nama_kelas' => 'X IPS 2',
            'jurusan_id' => '2'
        ]);
        Kelas::create([
            'nama_kelas' => 'X IPS 3',
            'jurusan_id' => '2'
        ]);
        
        Kelas::create([
            'nama_kelas' => 'X Agama',
            'jurusan_id' => '3'
        ]);

        Kelas::create([
            'nama_kelas' => 'XI MIPA 1',
            'jurusan_id' => '1'
        ]);
        Kelas::create([
            'nama_kelas' => 'XI MIPA 2',
            'jurusan_id' => '1'
        ]);
        Kelas::create([
            'nama_kelas' => 'XI MIPA 3',
            'jurusan_id' => '1'
        ]);

        Kelas::create([
            'nama_kelas' => 'XI IPS 1',
            'jurusan_id' => '2'
        ]);
        Kelas::create([
            'nama_kelas' => 'XI IPS 2',
            'jurusan_id' => '2'
        ]);
        Kelas::create([
            'nama_kelas' => 'XI IPS 3',
            'jurusan_id' => '2'
        ]);

        Kelas::create([
            'nama_kelas' => 'XI Agama',
            'jurusan_id' => '3'
        ]);

        Kelas::create([
            'nama_kelas' => 'XII MIPA 1',
            'jurusan_id' => '1'
        ]);
        Kelas::create([
            'nama_kelas' => 'XII MIPA 2',
            'jurusan_id' => '1'
        ]);
        Kelas::create([
            'nama_kelas' => 'XII MIPA 3',
            'jurusan_id' => '1'
        ]);

        Kelas::create([
            'nama_kelas' => 'XII IPS 1',
            'jurusan_id' => '2'
        ]);
        Kelas::create([
            'nama_kelas' => 'XII IPS 2',
            'jurusan_id' => '2'
        ]);
        Kelas::create([
            'nama_kelas' => 'XII IPS 3',
            'jurusan_id' => '2'
        ]);
                
        Kelas::create([
            'nama_kelas' => 'XII Agama',
            'jurusan_id' => '3'
        ]);
    }
}
