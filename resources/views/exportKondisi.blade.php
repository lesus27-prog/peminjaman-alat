<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Kondisi Alat</title>
    <style>
        {!! file_get_contents(public_path('css/export.css')) !!} table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        th {
            background: #d9e2f3;
            font-weight: bold;
            text-align: center;
            border: 1px solid #000;
            padding: 8px;
        }

        td {
            border: 1px solid #000;
            padding: 6px;
            vertical-align: middle;
        }

        .jenis-header {
            background: #c8c8c8;
            color: black;
            font-weight: bold;
            text-align: left;
            font-size: 13px;
            padding: 8px;
        }

        .text-center {
            text-align: center;
        }

        tbody tr:nth-child(odd),
        tbody tr:nth-child(even) {
            background: none !important;
        }

        table th {
            background-color: #eaeaea;
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
        <h3>LAPORAN KONDISI ALAT BERMASALAH</h3>
    </div>

    <div style="text-align:center;">
        <div class="subtitle">
            Update Terakhir: {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
        </div>
    </div>
    @foreach ($kondisi as $namaJenis => $items)
        <table>
            <tr>
                <td colspan="5" class="jenis-header text-center">
                    {{ strtoupper($namaJenis) }}
                </td>
            </tr>

            <tr>
                <th width="8%">No.</th>
                <th width="35%">Tipe Alat</th>
                <th width="18%">Kode Alat</th>
                <th width="24%">Kondisi</th>
                <th width="15%">Total</th>
            </tr>

            @php
                $no = 1;
                $groupTipe = $items->groupBy('id_tipe');
            @endphp

            @foreach ($groupTipe as $tipe)
                @php
                    $rowspan = $tipe->count();
                @endphp

                @foreach ($tipe as $index => $alat)
                    <tr>

                        @if ($index == 0)
                            <td rowspan="{{ $rowspan }}" class="text-center">
                                {{ $no++ }}.
                            </td>

                            <td rowspan="{{ $rowspan }}">
                                {{ ucwords($alat->tipeAlat->nama_tipe) }}
                            </td>
                        @endif

                        <td class="text-center">
                            {{ $alat->kode_alat }}
                        </td>

                        <td>
                            {{ ucwords($alat->kondisi_alat) }}
                        </td>

                        @if ($index == 0)
                            <td rowspan="{{ $rowspan }}" class="text-center">
                                {{ $rowspan }}
                            </td>
                        @endif

                    </tr>
                @endforeach
            @endforeach
        </table>
    @endforeach
</body>

</html>
