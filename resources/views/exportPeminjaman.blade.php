<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Peminjaman</title>
    <style>
        {!! file_get_contents(public_path('css/export.css')) !!} ul {
            margin: 0;
            padding-left: 18px;
        }

        li {
            font-size: 13px;
            line-height: 1.4;
        }

        table {

            table-layout: fixed;
        }
    </style>
</head>

<body>
    <div class="kop">
        <div class="kop-left">
            <img src="{{ public_path('logo-smkn7-resmi.jpg') }}" class="logo">
        </div>
        <div class="kop-center">
            <div class="sekolah">SMK NEGERI 7 SURABAYA</div>
            <div class="jurusan">Jurusan Teknik Komputer & Jaringan</div>
            <div class="alamat">Jl. Pawiyatan No.2, Bubutan, Surabaya, Jawa Timur 60174</div>
            <div class="alamat">Telp: (031) 534240 | Email: smknegeri7sby@yahoo.com</div>
        </div>
        <div class="kop-right"></div>
    </div>
    <div class="line">
        <div class="top"></div>
        <div class="bottom"></div>
    </div>
    <div class="title">
        <h3>LAPORAN PEMINJAMAN</h3>
    </div>

    <div style="text-align:center;">
        <div class="subtitle">
            Range Tanggal:
            @if (request('start') && request('end'))
                {{ \Carbon\Carbon::parse(request('start'))->format('d M Y') }}
                -
                {{ \Carbon\Carbon::parse(request('end'))->format('d M Y') }}
            @else
                Semua Data
            @endif
        </div>
    </div>
    <table>
        <thead>
            <tr>
                <th style="width:5%;">No.</th>
                <th style="width:20%;">Nama Siswa</th>
                <th style="width:15%;">Kelas</th>
                <th style="width:15%;">Tipe Alat</th>
                <th style="width:15%;">Tanggal Pinjam</th>
                <th style="width:15%;">Keterlambatan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}.</td>
                    <td class="text-left">{{ ucwords($item->siswa->nama_siswa) }}</td>
                    <td>{{ strtoupper($item->siswa->kelas) }}</td>
                    <td class="text-left">
                        <ul>
                            @foreach ($item->tipeAlat as $alat)
                                <li>{{ ucwords($alat->nama_tipe) }}</li>
                            @endforeach
                        </ul>

                    </td>
                    <td>
                        {{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M Y') }}
                    </td>
                    <td>
                        @if ($item->is_terlambat == 1)
                            Terlambat
                        @else
                            Tepat Waktu
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
