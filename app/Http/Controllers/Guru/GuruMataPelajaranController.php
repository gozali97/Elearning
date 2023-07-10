<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Http\Controllers\NotifikasiController;
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
    private $notifikasi;

    public function __construct()
    {
        $this->notifikasi = new NotifikasiController();
    }

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

        // dd($data);
        return view('guru.mapel.detail', compact('data', 'jadwal'));
    }

    public function store(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'nama' => 'required|max:255',
                'deskripsi' => 'required',
                'file' => 'nullable|array',
                'file.*' => 'mimes:docx,ppt,jpg,pdf|max:10240',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator);
            }

            $files = [];
            if ($request->hasFile('file')) {
                foreach ($request->file('file') as $uploadedFile) {
                    $filename = $request->nama . '_' . uniqid() . '.' . $uploadedFile->extension();
                    $path = $uploadedFile->move('assets/dokumen', $filename);
                    $files[] = $filename;
                }
            }

            Materi::create([
                'jadwal_id' => $request->jadwal_id,
                'nama_materi' => $request->nama,
                'deskripsi' => $request->deskripsi,
                'path_file' => implode(',', $files), // Mengubah array menjadi string dipisahkan oleh koma
            ]);

            $notif = '';
            if ($this->notifikasi->setNotifikasiByTopic('Penambahan Materi', "Materi dengan nama '" . $request->nama . "' telah ditambahkan", $request->jadwal_id)['terkirim']) {
                $notif = ' Notif berhasil dikirim.';
            } else {
                $notif = ' Notif gagal dikirim.';
            }

            return redirect()->route('guru.listajar.view', $request->jadwal_id)->with('success', 'Data Materi Pelajaran berhasil ditambahkan.' . $notif);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data materi.' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $data = Materi::where('id_materi', $id)->first();
            $message = '';
            $notif = '';

            if ($request->hasFile('file')) {

                if (file_exists(public_path('assets/dokumen/' . $data->path_file))) {
                    unlink(public_path('assets/dokumen/' . $data->path_file));
                }

                $file = $request->nama . '.' . $request->file->extension();
                $path = $request->file('file')->move('assets/img', $file);

                $data->path_file = $file;
                $message = "File materi pada Materi '" . $request->nama . "' telah diupdate";
            }

            if ($data->nama_materi !== $request->nama) {
                if ($message) {
                    $message = $message . ", dan nama Materi sebelumnya '" . $data->nama_materi . "'";
                } else {
                    $message = "Nama Materi '" . $data->nama_materi . "' telah diubah namanya menjadi '" . $request->nama . "'";
                }
            }

            if ($data->deskripsi !== $request->deskripsi) {
                if ($message) {
                    $message = $message . ', dengan deskripsi telah diupdate';
                } else if ($data->nama_materi === $request->nama) {
                    $message = "Deskripsi telah diupdate pada Materi '" . $data->nama_materi . "'";
                }
            }

            $data->nama_materi = $request->nama;
            $data->deskripsi = $request->deskripsi;
            $data->save();

            if ($message) {
                if ($this->notifikasi->setNotifikasiByTopic('Perubahan Materi', $message, $data->jadwal_id)['terkirim']) {
                    $notif = ' Notif berhasil dikirim.';
                } else {
                    $notif = ' Notif gagal dikirim.';
                }
            }

            return redirect()->route('guru.listajar.view', $data->jadwal_id)->with('success', 'Materi Pelajaran berhasil diupdate.' . $notif);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui data materi.' . $e->getMessage());
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
        $message = $data->nama_materi;
        $notif = '';

        $data->delete();

        if ($this->notifikasi->setNotifikasiByTopic('Materi dihapus', "Materi dengan nama '" . $message . "' telah dihapus", $data->jadwal_id)['terkirim']) {
            $notif = ' Notif berhasil dikirim.';
        } else {
            $notif = ' Notif gagal dikirim.';
        }

        return redirect()->route('guru.listajar.view', $data->jadwal_id)->with('success', 'Materi berhasil dihapus.' . $notif);
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

            $notif = '';
            if ($this->notifikasi->setNotifikasiByTopic('Penambahan Tugas', "Tugas '"
                . $request->nama . "' telah ditambahkan, segera cek!", $request->jadwal_id)['terkirim']) {
                $notif = ' Notif berhasil dikirim';
            } else {
                $notif = ' Notif gagal dikirim';
            }

            // if ($this->notifikasi->setScheduledDatetime(
            //     'Tenggat Tugas',
            //     "Deatline Tugas '"
            //         . $request->nama . "' tersisa 45 menit, tolong dicek kembali tugas yang anda kumpulkan",
            //     $request->jadwal_id,
            //     $request->tanggal_selesai . ' 23:14:30'
            // )['terkirim']) {
            //     $notif = $notif . ", Schedule berhasil diatur.";
            // } else {
            //     $notif = $notif . ", Schedule gagal diatur.";
            // }

            return redirect()->route('guru.listajar.view', $request->jadwal_id)->with('success', 'Tugas berhasil ditambahkan.' . $notif);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data tugas.' . $e->getMessage());
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

            return redirect()->route('guru.listajar.view', $data->jadwal_id)->with('success', 'Tugas berhasil diupdate.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui data tugas.' . $e->getMessage());
        }
    }

    public function viewTugas($tugas_id, $mapel_id)
    {

        $email = Auth::user()->email;
        $guru = Guru::where('email', $email)->first();

        $data = Siswa::query()
            ->join('users', 'users.email', 'siswa.email')
            ->join('jadwal_pelajaran', 'jadwal_pelajaran.kelas_id', 'siswa.kelas_id')
            ->where('guru_id', $guru->nip)
            ->where('mapel_id', $mapel_id)
            ->get();

        $tugas = DetailTugas::query()
            ->join('tugas', 'tugas.id_tugas', 'detail_tugas.tugas_id')
            ->join('materi', 'materi.id_materi', 'tugas.materi_id')
            ->whereIn('detail_tugas.siswa_id', $data->pluck('nis'))
            ->where('tugas.id_tugas', $tugas_id)
            ->get();

        $data = $data->map(function ($item) use ($tugas) {
            $item->tugas = collect($tugas)->filter(function ($tugasItem) use ($item) {
                return $tugasItem['siswa_id'] == $item->nis;
            })->values();
            return $item;
        });

        // dd($data);
        return view('guru.mapel.upload-siswa', compact('data'));
    }

    public function nilaiTugasSiswa(Request $request)
    {
        try {
            $data = DetailTugas::where('id_detail_tugas', $request->id_tugas)->first();

            $data->nilai = $request->nilai;
            $data->save();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat menyimpan nilai']);
        }
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
