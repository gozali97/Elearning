<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Jurusan;
use App\Models\MataPelajaran;
use App\Models\Materi;
use App\Models\Tugas;
use App\Models\DetailTugas;
use App\Models\Komentar;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        Role::create(['name' => 'admin']);
        Role::create(['name' => 'guru']);
        Role::create(['name' => 'siswa']);

        User::create([
            'name' => 'Rafi',
            'no_hp' => '083838383',
            'role_id' => '1',
            'gambar' => '',
            'email' => 'rafi@gmail.com',
            'email_verified_at' => now(),
            'password' => 'coba'
        ]);

        Siswa::create([
            'username' => 'Rafi',
            'role_id' => '1',
            'gambar' => '',
            'kelas_id' => '',
            'password' => '123456',
            'name' => 'Raafi Azizan Aim'
        ]);
                
        Jurusan::create(['name' => 'MIPA']);
        Jurusan::create(['name' => 'IPS']);
        Jurusan::create(['name' => 'AGAMA']);
        
        Kelas::create([
            // 10 -> kelas/angkatan, MIPA -> jurusan, 1 -> ruang kelas ke-n
            'name' => '10 MIPA 1',
            'jurusan_id' => '1'
        ]);

        MataPelajaran::create([
            'jurusan_id' => '',
            'guru_id' => '',
            'kode_mapel' => '100101', 
            'name' => 'MATEMATIKA'
        ]);

        MataPelajaran::create([
            'jurusan_id' => '',
            'guru_id' => '',
            'kode_mapel' => '100102', //10 -> kelas, 01 -> jurusan, 02 -> kode matkul
            'name' => 'KIMIA'
        ]);

        Materi::create([
            'mapel_id' => '',
            'name' => 'Catatan',
            'deskripsi' => 'Tolong Kirim datanya segera',
            'inp_materi' => '',
            'create' => now()
        ]);
        
        Tugas::create([
            'materi_id' => '',
            'name' => 'Wajib dikerjakan',
            'deskripsi' => "Carikan sebuah makna dari ungkapan 'TONGKOSONG NYARING BUNYINYA",
            'batasan_waktu' => now(),
            'create' => now()
        ]);

        DetailTugas::create([
            'tugas_id' => '',
            'siswa_id' => '',
            'file' => '',
            'nilai' => 100,
            'submit' => now()
        ]);
        
        Komentar::create([
            'detail_tugas_id' => '',
            'guru_id' => '',
            'komentar' => 'bagus, lanjutkan prestasi membanggakan mu nak',
            'create' => now()
        ]);
    }
}