<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MataPelajaran;

class MataPelajaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // MataPelajaran::create([
            // 'nama_mapel' => "MATEMATIKA X",
            // 'deskripsi' => "Pelajaran Matematika dasar kelas X"
        // ]);
        MataPelajaran::create([
            'nama_mapel' => "Bahasa Indonesia",
            'deskripsi' => "Pelajaran Bahasa Indonesia dasar"
        ]);

        MataPelajaran::create([
            'nama_mapel' => "Bahasa Inggris (Wajib)",
            'deskripsi' => "Pelajaran Bahasa Inggris untuk MIPA"
        ]);

        MataPelajaran::create([
            'nama_mapel' => "Ekonomi (Wajib)",
            'deskripsi' => "Pelajaran Ekonomi untuk IPS"
        ]);

        MataPelajaran::create([
            'nama_mapel' => "Fikih",
            'deskripsi' => "Pelajaran Fikih"
        ]);

        MataPelajaran::create([
            'nama_mapel' => "Ekonomi (Lintas Minat)",
            'deskripsi' => "Pelajaran Ekonomi"
        ]);

        MataPelajaran::create([
            'nama_mapel' => "PPKn",
            'deskripsi' => "Pelajaran PPKn"
        ]);

        MataPelajaran::create([
            'nama_mapel' => "Sejarah Indonesia (Wajib)",
            'deskripsi' => "Pelajaran Sejarah Indonesia wajib"
        ]);

        MataPelajaran::create([
            'nama_mapel' => "Sejarah (Peminatan)",
            'deskripsi' => "Pelajaran Sejarah"
        ]);

        MataPelajaran::create([
            'nama_mapel' => "Aqidah Akhlak",
            'deskripsi' => "Pelajaran Aqidah Akhlak "
        ]);

        MataPelajaran::create([
            'nama_mapel' => "Qurán Hadist",
            'deskripsi' => "Pelajaran Qurán Hadist"
        ]);

        MataPelajaran::create([
            'nama_mapel' => "Penjasorkes",
            'deskripsi' => "Pelajaran Penjasorkes"
        ]);

        MataPelajaran::create([
            'nama_mapel' => "Bahasa Arab (Wajib)",
            'deskripsi' => "Pelajaran Bahasa Arab wajib"
        ]);

        MataPelajaran::create([
            'nama_mapel' => "Bahasa Jawa",
            'deskripsi' => "Pelajaran Bahasa Jawa"
        ]);

        MataPelajaran::create([
            'nama_mapel' => "Sosiologi",
            'deskripsi' => "Pelajaran Sosiologi"
        ]);

        MataPelajaran::create([
            'nama_mapel' => "Tahfidz",
            'deskripsi' => "Pelajaran Tahfidz"
        ]);

        MataPelajaran::create([
            'nama_mapel' => "Seni Budaya",
            'deskripsi' => "Pelajaran Seni Budaya"
        ]);

        MataPelajaran::create([
            'nama_mapel' => "Ushul Fiqih",
            'deskripsi' => "Pelajaran Ushul Fiqih"
        ]);
    }
}
