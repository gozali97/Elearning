<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\DetailTugas;
use App\Models\Guru;
use App\Models\JadwalPelajaran;
use App\Models\Materi;
use App\Models\Siswa;
use App\Models\Tugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class GuruMataPelajaranController extends Controller
{
    public function index()
    {

        $id = Auth::user()->email;
        $user = Guru::query()->join('users', 'users.email', 'guru.email')->where('guru.email', $id)->first();


        $data = JadwalPelajaran::query()
            ->join('kelas', 'kelas.id_kelas', 'jadwal_pelajaran.kelas_id')
            ->join('mata_pelajarans', 'mata_pelajarans.kode_mapel', 'jadwal_pelajaran.mapel_id')
            ->join('guru', 'guru.nip', 'jadwal_pelajaran.guru_id')
            ->join('users', 'users.email', 'guru.email')
            ->where('jadwal_pelajaran.guru_id', $user->nip)
            ->get();

        return view('guru.mapel.index', compact('data'));
    }

    public function view($id)
    {

        $jadwal = JadwalPelajaran::query()
            ->join('mata_pelajarans', 'mata_pelajarans.kode_mapel', 'jadwal_pelajaran.mapel_id')
            ->where('kode_jadwal', $id)->first();


        $data = Materi::query()
            ->join('jadwal_pelajaran', 'jadwal_pelajaran.kode_jadwal', 'materi.jadwal_id')
            ->leftJoin('tugas', 'tugas.materi_id', 'materi.id_materi')
            ->select('materi.*', 'tugas.id_tugas', 'tugas.nama_tugas', 'tugas.file_tugas', 'jadwal_pelajaran.*')
            ->where('materi.jadwal_id', $id)
            ->get();


        return view('guru.mapel.detail', compact('data', 'jadwal'));
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nama' => 'required|max:255',
                'deskripsi' => 'required',
                'file' => 'required|mimes:docx,ppt,jpg,pdf|max:10240',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator);
            }

            $file  = $request->nama . '.' . $request->file->extension();
            $path       = $request->file('file')->move('assets/dokumen', $file);

            Materi::create([
                'jadwal_id' => $request->jadwal_id,
                'nama_materi' => $request->nama,
                'deskripsi' => $request->deskripsi,
                'path_file' => $file,
            ]);

            return redirect()->route('guru.listajar.view', $request->jadwal_id)->with('success', 'Data Materi Pelajaran berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data materi.'. $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $data = Materi::where('id_materi', $id)->first();

            if ($request->hasFile('file')) {

                if (file_exists(public_path('assets/dokumen/' . $data->path_file))) {
                    unlink(public_path('assets/dokumen/' . $data->path_file));
                }

                $file = $request->nama . '.' . $request->file->extension();
                $path = $request->file('file')->move('assets/img', $file);

                $data->path_file = $file;
            }

            $data->nama_materi = $request->nama;
            $data->deskripsi = $request->deskripsi;
            $data->save();

            return redirect()->route('guru.listajar.view', $data->jadwal_id)->with('success', 'Materi Pelajaran berhasil diupdate.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui data materi.'. $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $data = Materi::where('id_materi', $id)->first();

        if (!$data) {
            return redirect()->back()->with('error', 'Materi tidak ditemukan.');
        }
        $filePath = public_path('assets/dokumen/' . $data->path_file);
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        $data->delete();

        return redirect()->route('guru.listajar.view', $data->jadwal_id)->with('success', 'Materi berhasil dihapus.');
    }


    public function storeTugas(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'nama' => 'required|max:255',
                'deskripsi' => 'required',
                'file' => 'required|mimes:docx,ppt,jpg,pdf|max:10240',
                'tanggal_mulai' => 'required',
                'tanggal_selesai' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator);
            }

            $file  = $request->nama . '.' . $request->file->extension();
            $path       = $request->file('file')->move('assets/tugas', $file);

            Tugas::create([
                'materi_id' => $request->materi_id,
                'nama_tugas' => $request->nama,
                'deskripsi' => $request->deskripsi,
                'file_tugas' => $file,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
            ]);

            return redirect()->route('guru.listajar.view', $request->jadwal_id)->with('success', 'Tugas berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data tugas.'. $e->getMessage());
        }
    }

    public function updateTugas(Request $request, $id)
    {
        try {
            $data = Materi::where('kode_mapel', $id)->first();

            if ($request->hasFile('file')) {

                if (file_exists(public_path('assets/dokumen/' . $data->path_file))) {
                    unlink(public_path('assets/dokumen/' . $data->path_file));
                }

                $file = $request->nama . '.' . $request->file->extension();
                $path = $request->file('file')->move('assets/img', $file);

                $data->path_file = $file;
            }

            $data->nama_materi = $request->nama;
            $data->deskripsi = $request->deskripsi;
            $data->save();

            return redirect()->route('guru.listajar.view', $data->jadwal_id)->with('success', 'Materi Pelajaran berhasil diupdate.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui data materi.'. $e->getMessage());
        }
    }

    public function viewTugas($id)
    {

        $data = DetailTugas::query()
            ->join('tugas', 'tugas.id_tugas', 'detail_tugas.tugas_id')
            ->join('siswa', 'siswa.nis', 'detail_tugas.siswa_id')
            ->join('users', 'users.email', 'siswa.email')
            ->join('materi', 'materi.id_materi', 'tugas.materi_id')
            ->where('tugas.id_tugas', $id)
            ->get();
            // dd($data);
        return view('guru.mapel.upload-siswa', compact('data'));
    }

    public function viewSiswa($id)
    {

        $data = Siswa::query()
            ->join('kelas', 'kelas.id_kelas', 'siswa.kelas_id')
            ->join('users', 'users.email', 'siswa.email')
            ->join('jadwal_pelajaran', 'jadwal_pelajaran.kelas_id', 'kelas.id_kelas')
            ->join('mata_pelajarans', 'mata_pelajarans.kode_mapel', 'jadwal_pelajaran.mapel_id')
            ->where('mata_pelajarans.kode_mapel', $id)
            ->get();

            // dd($data);

        return view('guru.mapel.viewSiswa', compact('data'));
    }
}
