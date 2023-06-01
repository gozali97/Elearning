<!DOCTYPE html>
<html>

<head>
    <title>Laporan Nilai Siswa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid black;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #dddddd;
        }

        .footer {
            text-align: left;
            float: right;
        }
    </style>
</head>

<body>
    <h2 style="text-align:center;">Laporan Nilai Siswa</h2>
        <h5 style="text-align:center;">Mata Pelajaran {{$mapel->nama_mapel}}</h5>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                 @for ($i= 1; $i<=10 ;$i++)
                <th>Tugas {{$i}}</th>
                @endfor
            </tr>
        </thead>
        <tbody>
            @if ($data->isEmpty())
                <tr>
                    <td colspan="6" style="font-weight: bold; text-align: center;">Tidak ada data</td>
                </tr>
            @else
                @foreach ($data as $d)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $d->name }}</td>
                       @php
                            $nomor = 1;
                        @endphp
                        @foreach ($d->tugas as $tugas)
                            @php
                            $nomor+=1
                        @endphp
                        <td>{{ $tugas->nilai }}</td>
                        @endforeach
                            @for($i=$nomor; $i<=10; $i++) 
                            <td>0</td>
                        @endfor
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
    <div class="footer">
        <p>Sleman, {{ date('d F Y') }}</p>
        <p>Mengetahui, <br> Kepala Sekolah MAN 5</p>
        <br>
        <br>
        <p>Dr. Purnomo</p>
    </div>
</body>

</html>
