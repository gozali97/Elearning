<?php

namespace App\Imports;

use App\Models\Siswa;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SiswaImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

        $user = new User();
        $user->name = $row['nama'];
        $user->role_id = 3;
        $user->email = $row['email'];
        $user->password = Hash::make('12345678');
        $user->save();

        $siswaCount = Siswa::count();
        $nomorUrutan = $siswaCount + 1;
        $nis = 'SA' . str_pad($nomorUrutan, 3, '0', STR_PAD_LEFT);

        $siswa = new Siswa();
        $siswa->nis = $nis;
        $siswa->email = $row['email'];
        $siswa->kelas_id = $row['kelas_id'];
        $siswa->jurusan_id = $row['jurusan_id'];
        $siswa->jenis_kelamin = $row['jenis_kelamin'];
        $siswa->no_hp = $row['no_hp'];
        $siswa->alamat = $row['alamat'];
        $siswa->save();

        return $siswa;
    }

}
