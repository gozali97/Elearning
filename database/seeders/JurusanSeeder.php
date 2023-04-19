<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Jurusan;

class JurusanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Jurusan::create(['nama_jurusan' => 'MIPA']);
        Jurusan::create(['nama_jurusan' => 'IPS']);
        Jurusan::create(['nama_jurusan' => 'AGAMA']);
    }
}
