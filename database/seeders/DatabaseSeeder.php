<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Models\Siswa;
use App\Models\Guru;


class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RoleSeeder::class,
            JurusanSeeder::class,
            KelasSeeder::class,
            MataPelajaranSeeder::class,
            JadwalPelajaranSeeder::class,
        ]);

        User::create([
            'name' => 'Gozali',
            'role_id' => '3',
            'jenis_kelamin' => 'Laki-Laki',
            'email' => 'gozali@gmail.com',
            'password' => Hash::make('Gozali2626')
        ]);

        Siswa::create([
            'kelas_id' => 4,
            'jurusan_id' => 2,
            'email' => 'gozali@gmail.com',
            'NIS' => '2343',
            'alamat' => 'Jl. Kabupaten'
        ]);

        User::create([
            'name' => 'Adi',
            'role_id' => '3',
            'jenis_kelamin' => 'Laki-Laki',
            'email' => 'adi@gmail.com',
            'password' => Hash::make('adiadi213')
        ]);

        Siswa::create([
            'kelas_id' => 7,
            'jurusan_id' => 3,
            'email' => 'adi@gmail.com',
            'NIS' => '2344',
            'alamat' => 'Jl. Bringharjo'
        ]);

        User::create([
            'name' => 'Rafi',
            'role_id' => '3',
            'jenis_kelamin' => 'Laki-Laki',
            'email' => 'rafi@gmail.com',
            'password' => Hash::make('cobalahmengerti')
        ]);

        Siswa::create([
            'kelas_id' => 2,
            'jurusan_id' => 1,
            'email' => 'rafi@gmail.com',
            'NIS' => '2345',
            'alamat' => 'Jl. uty'
        ]);

        User::create([
            'name' => 'Dra. Netty Indarti',
            'role_id' => '2',
            'jenis_kelamin' => 'Perempuan',
            'email' => 'Netty@gmail.com',
            'password' => Hash::make('Netty@gmail.com')
        ]);

        Guru::create([
            'email' => 'Netty@gmail.com',
            'NIP' => '196505311993032001',
            'jabatan_guru' => 'Guru Madya'
        ]);

        User::create([
            'name' => 'Dra. Iis Aisyah',
            'role_id' => '2',
            'jenis_kelamin' => 'Perempuan',
            'email' => 'Iis@gmail.com',
            'password' => Hash::make('Iis@gmail.com')
        ]);

        Guru::create([
            'email' => 'Iis@gmail.com',
            'NIP' => '196602261994032001',
            'jabatan_guru' => 'Guru Madya'
        ]);

        User::create([
            'name' => 'Siti Aminah, S.Ag.',
            'role_id' => '2',
            'jenis_kelamin' => 'Perempuan',
            'email' => 'Siti@gmail.com',
            'password' => Hash::make('Siti@gmail.com')
        ]);

        Guru::create([
            'email' => 'Siti@gmail.com',
            'NIP' => '196909071995032001',
            'jabatan_guru' => 'Guru Madya'
        ]);

        User::create([
            'name' => 'Drs. Subardi',
            'role_id' => '2',
            'jenis_kelamin' => 'Laki-laki',
            'email' => 'Subardi@gmail.com',
            'password' => Hash::make('Subardi@gmail.com')
        ]);

        Guru::create([
            'email' => 'Subardi@gmail.com',
            'NIP' => '196807171994121001',
            'jabatan_guru' => 'Guru Madya'
        ]);

        User::create([
            'name' => 'Rini Widayati, S.Pd.',
            'role_id' => '2',
            'jenis_kelamin' => 'Perempuan',
            'email' => 'Rini@gmail.com',
            'password' => Hash::make('Rini@gmail.com')
        ]);

        Guru::create([
            'email' => 'Rini@gmail.com',
            'NIP' => '197106151998022006',
            'jabatan_guru' => 'Guru Madya'
        ]);

        User::create([
            'name' => 'Jemirah, S.Pd.',
            'role_id' => '2',
            'jenis_kelamin' => 'Perempuan',
            'email' => 'Jemirah@gmail.com',
            'password' => Hash::make('Jemirah@gmail.com')
        ]);

        Guru::create([
            'email' => 'Jemirah@gmail.com',
            'NIP' => '196305251999032001',
            'jabatan_guru' => 'Guru Madya'
        ]);

        User::create([
            'name' => 'Mudrikah, M.Pd.I.',
            'role_id' => '2',
            'jenis_kelamin' => 'Laki-laki',
            'email' => 'Mudrikah@gmail.com',
            'password' => Hash::make('Mudrikah@gmail.com')
        ]);

        Guru::create([
            'email' => 'Mudrikah@gmail.com',
            'NIP' => '197202042007012025',
            'jabatan_guru' => 'Guru Muda'
        ]);


        User::create([
            'name' => 'Muhammad Abdul Latif, S.Pd',
            'role_id' => '2',
            'jenis_kelamin' => 'Laki-laki',
            'email' => 'Abdul@gmail.com',
            'password' => Hash::make('Abdul@gmail.com')
        ]);
        
        Guru::create([
            'email' => 'Abdul@gmail.com',
            'NIP' => '199410232019031010',
            'jabatan_guru' => 'Calon Guru Ahli Pertama'
        ]);

        User::create([
            'name' => "Fathna Sa'adati Choliliyah, S.S.",
            'role_id' => '2',
            'jenis_kelamin' => 'Perempuan',
            'email' => 'Fathna@gmail.com',
            'password' => Hash::make('Fathna@gmail.com')
        ]);

        Guru::create([
            'email' => 'Fathna@gmail.com',
            'NIP' => '199507082019032010',
            'jabatan_guru' => 'Calon Guru Ahli Pertama'
        ]);

        User::create([
            'name' => 'Ety Widyarisma Utami, S.Pd.',
            'role_id' => '2',
            'jenis_kelamin' => 'Perempuan',
            'email' => 'Ety@gmail.com',
            'password' => Hash::make('Ety@gmail.com')
        ]);

        Guru::create([
            'email' => 'Ety@gmail.com',
            'jabatan_guru' => 'GTT'
        ]);

        User::create([
            'name' => 'Dwi Wahyuningsih, S,Pd',
            'role_id' => '2',
            'jenis_kelamin' => 'Perempuan',
            'email' => 'Dwi@gmail.com',
            'password' => Hash::make('Dwi@gmail.com')
        ]);

        Guru::create([
            'email' => 'Dwi@gmail.com',
            'NIP' => '197606252009122001',
            'jabatan_guru' => 'Guru Muda'
        ]);

        User::create([
            'name' => 'Karina Huka, S.Pd.',
            'role_id' => '2',
            'jenis_kelamin' => 'Perempuan',
            'email' => 'Karina@gmail.com',
            'password' => Hash::make('Karina@gmail.com')
        ]);

        Guru::create([
            'email' => 'Karina@gmail.com',
            'jabatan_guru' => 'GTT'
        ]);

        User::create([
            'name' => 'Muh Nur Kholis, S.Pd.',
            'role_id' => '2',
            'jenis_kelamin' => 'Laki-laki',
            'email' => 'Nur@gmail.com',
            'password' => Hash::make('Nur@gmail.com')
        ]);

        Guru::create([
            'email' => 'Nur@gmail.com',
            'jabatan_guru' => 'GTT'
        ]);
    }
}