<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Data Alat</title>
    <style>
        {!! file_get_contents(public_path('css/export.css')) !!}
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
        <h3>LAPORAN DATA ALAT</h3>
    </div>

    <div style="text-align:center;">
        <div class="subtitle">
            Update Terakhir: {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
        </div>
    </div>
    <table>
        <thead>
            <tr>
                <th width="5%">No.</th>
                <th width="25%">Jenis Alat</th>
                <th width="25%">Tipe Alat</th>
                <th width="15%">Stok</th>
                <th width="15%">Lokasi Rak</th>
                <th width="15%">Total Alat</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($tipes as $idJenis => $group)
                @php
                    $rowspan = $group->count();
                    $totalAlat = $group->sum('stok');
                    $first = true;
                @endphp

                @foreach ($group as $tipe)
                    <tr>
                        @if ($first)
                            <td rowspan="{{ $rowspan }}">{{ $loop->parent->iteration }}.</td>

                            <td rowspan="{{ $rowspan }}">
                                {{ ucwords($tipe->jenisAlat->nama_jenis) }}
                            </td>

                            @php $first = false; @endphp
                        @endif

                        <td>{{ ucwords($tipe->nama_tipe) }}</td>
                        <td>{{ $tipe->stok }}</td>
                        <td>{{ ucwords($tipe->lokasi_rak) }}</td>

                        @if ($loop->first)
                            <td rowspan="{{ $rowspan }}">
                                {{ $totalAlat }}
                            </td>
                        @endif
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
</body>

</html>
