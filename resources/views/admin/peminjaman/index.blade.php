@extends('layouts.admin')
@section('title', 'Peminjaman')
@section('link')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/content.css') }}">
    <link rel="stylesheet" href="{{ asset('css/universal.css') }}">
    <link rel="stylesheet" href="{{ asset('css/peminjaman.css') }}">
    <link rel="stylesheet" href="{{ asset('css/table.css') }}">
    <link rel="stylesheet" href="{{ asset('css/filter.css') }}">
    <link rel="stylesheet" href="{{ asset('css/modal.css') }}">
    <link rel="stylesheet" href="{{ asset('css/button.css') }}">
@endsection
@section('content')
    @php
        function badgeClass($status)
        {
            if ($status == 'batal') {
                return 'badge-soft-danger';
            } elseif ($status == 'menunggu') {
                return 'badge-soft-warning';
            } elseif ($status == 'siap diambil') {
                return 'badge-soft-success';
            } elseif ($status == 'aktif') {
                return 'badge-soft-primary';
            } else {
                return 'badge-soft-purple';
            }
        }
    @endphp
    <div class="pd-ltr-20 xs-pd-20-10">
        <div class="min-height-200px">
            <div class="page-header">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="title">
                            <h4>Data Peminjaman</h4>
                        </div>
                        <nav aria-label="breadcrumb" role="navigation">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <i class="bx bx-home"></i>
                                    <a href="{{ route('dashboardAdmin.index') }}">Dashboard Admin</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Data Peminjaman
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="col-12 mb-4 p-0">
                <div class="tab-system">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link {{ $tab == 'menunggu' ? 'active' : '' }} text-blue" data-toggle="tab"
                                href="#menunggu" role="tab" aria-selected="true">Menunggu</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $tab == 'siap-diambil' ? 'active' : '' }} text-blue" data-toggle="tab"
                                href="#siap-diambil" role="tab" aria-selected="false">Siap Diambil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $tab == 'aktif' ? 'active' : '' }} text-blue" data-toggle="tab"
                                href="#aktif" role="tab" aria-selected="false">Aktif</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $tab == 'proses-pengembalian' ? 'active' : '' }} text-blue"
                                data-toggle="tab" href="#proses-pengembalian" role="tab" aria-selected="false">Proses
                                Pengembalian</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $tab == 'batal' ? 'active' : '' }} text-blue" data-toggle="tab"
                                href="#batal" role="tab" aria-selected="false">Dibatalkan</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade tab-custom px-3 {{ $tab == 'menunggu' ? 'show active' : '' }}"
                            id="menunggu" role="tabpanel">
                            <div class="row  align-items-center">
                                <div class="col-md-6 col-12 mb-md-0">
                                    <div class="input-group mt-4 mb-0">
                                        <div id="search-wrapper-menunggu" class="pr-2"></div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12 d-flex gap-2 flex-wrap justify-content-md-end mt-2">
                                    <div id="show-entries-menunggu"></div>
                                </div>
                            </div>
                            <div class="pb-20 pt-1">
                                <div class="table-responsive">
                                    <table class="data-table table hover py-3 px-4 border-0 py-3 px-4 border-0"
                                        style="background: #e9edf9b1 !important; border-radius: 22px;" id="table-menunggu">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Nama Siswa</th>
                                                <th>Kelas</th>
                                                <th>Tanggal Pemakaian</th>
                                                <th>Batas Pengembalian</th>
                                                <th>Status</th>
                                                <th>Alat</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($peminjamanMenunggu as $index => $item)
                                                <tr>
                                                    <td>
                                                        <div class="no-badge">{{ $index + 1 }}.</div>
                                                    </td>
                                                    <td>{{ ucwords($item->siswa->nama_siswa) }}</td>
                                                    <td>{{ strtoupper($item->siswa->kelas) }}</td>
                                                    <td>{{ $item->tanggalPemakaianFormat() }}</td>
                                                    <td>{{ $item->batasPengembalianFormat() }}</td>
                                                    <td>
                                                        <span
                                                            class="badge {{ badgeClass($item->status_pinjam) }} px-3 py-2 rounded-pill">
                                                            {{ ucwords($item->status_pinjam) }}
                                                        </span>
                                                    </td>
                                                    <td class="td-detail">
                                                        <button class="btn-detail-soft btn-detail">
                                                            <span class="icon-wrap">
                                                                <i class="fas fa-plus"></i>
                                                            </span>
                                                        </button>
                                                        <div class="detail-alat mt-2" style="display:none;">
                                                            @foreach ($item->tipeAlat as $detail)
                                                                <div class="mb-3 pb-2 border-bottom">
                                                                    <div
                                                                        class="d-flex justify-content-between align-items-center">
                                                                        <span class="fw-semibold">
                                                                            {{ ucwords($detail->nama_tipe) }}
                                                                        </span>
                                                                        <small class="text-muted">
                                                                            x{{ $detail->pivot->quantity }}
                                                                        </small>
                                                                    </div>
                                                                    <div class="mt-2 ps-2">
                                                                        @foreach ($item->detailAlat->where('id_tipe', $detail->id_tipe) as $alat)
                                                                            <div class="text-muted small">
                                                                                • {{ $alat->kode_alat }}
                                                                            </div>
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <form action="{{ route('peminjaman.cancel', $item->id_pinjam) }}"
                                                            method="POST">
                                                            @csrf
                                                            <input type="hidden" name="tab" value="menunggu">
                                                            <button type="submit" class="btn-cancel-soft"
                                                                title="Batalkan">
                                                                <i class="fa-solid fa-circle-xmark"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade tab-custom px-3 {{ $tab == 'siap-diambil' ? 'show active' : '' }}"
                            id="siap-diambil" role="tabpanel">
                            <div class="row align-items-center">
                                <div class="col-md-6 col-12 mb-md-0">
                                    <div class="input-group mt-3 mb-0">
                                        <div id="search-wrapper-siap-diambil" class="pr-2"></div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12 d-flex gap-2 flex-wrap justify-content-md-end mt-2">
                                    <div id="show-entries-siap-diambil"></div>
                                </div>
                            </div>
                            <div class="pb-20 pt-1">
                                <div class="table-responsive">
                                    <table class="data-table table hover py-3 px-4 border-0" id="table-siap-diambil"
                                        style="background: #e9edf9b1 !important; border-radius: 22px;">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Nama Siswa</th>
                                                <th>Kelas</th>
                                                <th>Tanggal Pemakaian</th>
                                                <th>Batas Pengembalian</th>
                                                <th>Status</th>
                                                <th>Alat</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($peminjamanSiapDiambil as $index => $item)
                                                <tr>
                                                    <td>
                                                        <div class="no-badge">{{ $index + 1 }}.</div>
                                                    </td>
                                                    <td>{{ ucwords($item->siswa->nama_siswa) }}</td>
                                                    <td>{{ strtoupper($item->siswa->kelas) }}</td>
                                                    <td>{{ $item->tanggalPemakaianFormat() }}</td>
                                                    <td>{{ $item->batasPengembalianFormat() }}</td>
                                                    <td>
                                                        <span
                                                            class="badge {{ badgeClass($item->status_pinjam) }} px-3 py-2 rounded-pill">
                                                            {{ ucwords($item->status_pinjam) }}
                                                        </span>
                                                    </td>
                                                    <td class="td-detail">
                                                        <button class="btn-detail-soft btn-detail">
                                                            <span class="icon-wrap">
                                                                <i class="fas fa-plus"></i>
                                                            </span>
                                                        </button>
                                                        <div class="detail-alat mt-2" style="display:none;">
                                                            @foreach ($item->tipeAlat as $detail)
                                                                <div class="mb-3 pb-2 border-bottom">
                                                                    <div
                                                                        class="d-flex justify-content-between align-items-center">
                                                                        <span class="fw-semibold">
                                                                            {{ ucwords($detail->nama_tipe) }}
                                                                        </span>
                                                                        <small class="text-muted">
                                                                            x{{ $detail->pivot->quantity }}
                                                                        </small>
                                                                    </div>
                                                                    <div class="mt-2 ps-2">
                                                                        @foreach ($item->detailAlat->where('id_tipe', $detail->id_tipe) as $alat)
                                                                            <div class="text-muted small">
                                                                                • {{ $alat->kode_alat }}
                                                                            </div>
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="action-group">
                                                            <form
                                                                action="{{ route('peminjaman.cancel', $item->id_pinjam) }}"
                                                                method="POST" class="m-0">
                                                                @csrf
                                                                <input type="hidden" name="tab"
                                                                    value="siap-diambil">
                                                                <button type="submit" class="btn-cancel-soft"
                                                                    title="Batalkan">
                                                                    <i class="fa-solid fa-circle-xmark"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade tab-custom px-3 {{ $tab == 'aktif' ? 'show active' : '' }}"
                            id="aktif" role="tabpanel">
                            <div class="row align-items-center">
                                <div class="col-md-6 col-12 mb-md-0">
                                    <div class="input-group mt-3 mb-0">
                                        <div id="search-wrapper-aktif" class="pr-2"></div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12 d-flex gap-2 flex-wrap justify-content-md-end mt-2">
                                    <div id="show-entries-aktif"></div>
                                </div>
                            </div>
                            <div class="pb-20 pt-1">
                                <div class="table-responsive">
                                    <table class="data-table table hover py-3 px-4 border-0" id="table-aktif"
                                        style="background: #e9edf9b1 !important; border-radius: 22px;">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>ID Peminjaman</th>
                                                <th>Nama Siswa</th>
                                                <th>Kelas</th>
                                                <th>Tanggal Pemakaian</th>
                                                <th>Batas Pengembalian</th>
                                                <th>Keterlambatan</th>
                                                <th>Status</th>
                                                <th>Alat</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($peminjamanAktif as $index => $item)
                                                <tr>
                                                    <td>
                                                        <div class="no-badge">{{ $index + 1 }}.</div>
                                                    </td>
                                                    <td>PJM-0{{ $item->id_pinjam }}</td>
                                                    <td>{{ ucwords($item->siswa->nama_siswa) }}</td>
                                                    <td>{{ strtoupper($item->siswa->kelas) }}</td>
                                                    <td>{{ $item->tanggalPemakaianFormat() }}</td>
                                                    <td>{{ $item->batasPengembalianFormat() }}</td>
                                                    <td>
                                                        @if ($item->terlambat())
                                                            <span class="badge badge-soft-danger rounded-pill">
                                                                Terlambat
                                                            </span>
                                                            <div class="menit-terlambat mt-1 ml-1">
                                                                {{ $item->keterlambatanText() }}
                                                            </div>
                                                        @else
                                                            <span class=" badge badge-soft-success rounded-pill">
                                                                Tepat Waktu
                                                            </span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="badge {{ badgeClass($item->status_pinjam) }} px-3 py-2 rounded-pill">
                                                            {{ ucwords($item->status_pinjam) }}
                                                        </span>
                                                    </td>
                                                    <td class="td-detail">
                                                        <button class="btn-detail-soft btn-detail">
                                                            <span class="icon-wrap">
                                                                <i class="fas fa-plus"></i>
                                                            </span>
                                                        </button>
                                                        <div class="detail-alat mt-2" style="display:none;">
                                                            @foreach ($item->tipeAlat as $detail)
                                                                <div class="mb-3 pb-2 border-bottom">
                                                                    <div
                                                                        class="d-flex justify-content-between align-items-center">
                                                                        <span class="fw-semibold">
                                                                            {{ ucwords($detail->nama_tipe) }}
                                                                        </span>
                                                                        <small class="text-muted">
                                                                            x{{ $detail->pivot->quantity }}
                                                                        </small>
                                                                    </div>
                                                                    <div class="mt-2 ps-2">
                                                                        @foreach ($item->detailAlat->where('id_tipe', $detail->id_tipe) as $alat)
                                                                            <div class="text-muted small">
                                                                                • {{ $alat->kode_alat }}
                                                                            </div>
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade tab-custom px-3 {{ $tab == 'proses-pengembalian' ? 'show active' : '' }}"
                            id="proses-pengembalian" role="tabpanel">
                            <div class="row align-items-center">
                                <div class="col-md-6 col-12 mb-md-0">
                                    <div class="input-group mt-3 mb-0">
                                        <div id="search-wrapper-proses-pengembalian" class="pr-2"></div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12 d-flex gap-2 flex-wrap justify-content-md-end mt-2">
                                    <div id="show-entries-proses-pengembalian"></div>
                                </div>
                            </div>
                            <div class="pb-20 pt-1">
                                <div class="table-responsive">
                                    <table class="data-table table hover py-3 px-4 border-0"
                                        id="table-proses-pengembalian"
                                        style="background: #e9edf9b1 !important; border-radius: 22px;">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>ID Peminjaman</th>
                                                <th>Nama Siswa</th>
                                                <th>Kelas</th>
                                                <th>Tanggal Pemakaian</th>
                                                <th>Batas Pengembalian</th>
                                                <th>Keterlambatan</th>
                                                <th>Status</th>
                                                <th>Alat</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($peminjamanProsesPengembalian as $index => $item)
                                                <tr>
                                                    <td>
                                                        <div class="no-badge">{{ $index + 1 }}.</div>
                                                    </td>
                                                    <td>PJM-0{{ $item->id_pinjam }}</td>
                                                    <td>{{ ucwords($item->siswa->nama_siswa) }}</td>
                                                    <td>{{ strtoupper($item->siswa->kelas) }}</td>
                                                    <td>{{ $item->tanggalPemakaianFormat() }}</td>
                                                    <td>{{ $item->batasPengembalianFormat() }}</td>
                                                    <td>
                                                        @if ($item->terlambat())
                                                            <span class="badge badge-soft-danger rounded-pill">
                                                                Terlambat
                                                            </span>
                                                            <div class="menit-terlambat mt-1 ml-1">
                                                                {{ $item->keterlambatanText() }}
                                                            </div>
                                                        @else
                                                            <span class=" badge badge-soft-success rounded-pill">
                                                                Tepat Waktu
                                                            </span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="badge {{ badgeClass($item->status_pinjam) }} px-3 py-2 rounded-pill">
                                                            {{ ucwords($item->status_pinjam) }}
                                                        </span>
                                                    </td>
                                                    <td class="td-detail">
                                                        <button class="btn-detail-soft btn-detail">
                                                            <span class="icon-wrap">
                                                                <i class="fas fa-plus"></i>
                                                            </span>
                                                        </button>
                                                        <div class="detail-alat mt-2" style="display:none;">
                                                            @foreach ($item->tipeAlat as $detail)
                                                                <div class="mb-3 pb-2 border-bottom">
                                                                    <div
                                                                        class="d-flex justify-content-between align-items-center">
                                                                        <span class="fw-semibold">
                                                                            {{ ucwords($detail->nama_tipe) }}
                                                                        </span>
                                                                        <small class="text-muted">
                                                                            x{{ $detail->pivot->quantity }}
                                                                        </small>
                                                                    </div>
                                                                    <div class="mt-2 ps-2">
                                                                        @foreach ($item->detailAlat->where('id_tipe', $detail->id_tipe) as $alat)
                                                                            <div class="text-muted small">
                                                                                • {{ $alat->kode_alat }}
                                                                            </div>
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn-validasi-soft" title="Validasi"
                                                            data-toggle="modal" data-target="#modal-validasi"
                                                            data-id-pinjam="{{ $item->id_pinjam }}"
                                                            data-nama-siswa="{{ ucwords($item->siswa->nama_siswa) }}"
                                                            data-kelas="{{ strtoupper($item->siswa->kelas) }}"
                                                            data-tanggal-mulai="{{ $item->tanggalPeminjamanFormat() }}"
                                                            data-batas-kembali="{{ $item->batasKembaliFormat() }}"
                                                            data-terlambat="{{ $item->terlambat() ? 1 : 0 }}"
                                                            data-terlambat-text="{{ $item->keterlambatanText() }}"
                                                            data-alat='@json($item->detailAlat->load('tipeAlat'))'>
                                                            <i class="fa-solid fa-check-to-slot"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade tab-custom px-3 {{ $tab == 'batal' ? 'show active' : '' }}"
                            id="batal" role="tabpanel">
                            <div class="row align-items-center">
                                <div class="col-md-6 col-12 mb-md-0">
                                    <div class="input-group mt-3 mb-0">
                                        <div id="search-wrapper-batal" class="pr-2"></div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12 d-flex gap-2 flex-wrap justify-content-md-end mt-2">
                                    <div id="show-entries-batal"></div>
                                </div>
                            </div>
                            <div class="pb-20 pt-1">
                                <div class="table-responsive">
                                    <table class="data-table table hover py-3 px-4 border-0" id="table-batal"
                                        style="background: #e9edf9b1 !important; border-radius: 22px;">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Nama Siswa</th>
                                                <th>Kelas</th>
                                                <th>Tanggal Pemakaian</th>
                                                <th>Batas Pengembalian</th>
                                                <th>Alat</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($peminjamanBatal as $index => $item)
                                                <tr>
                                                    <td>
                                                        <div class="no-badge">{{ $index + 1 }}.</div>
                                                    </td>
                                                    <td>{{ ucwords($item->siswa->nama_siswa) }}</td>
                                                    <td>{{ strtoupper($item->siswa->kelas) }}</td>
                                                    <td>{{ $item->tanggalPemakaianFormat() }}</td>
                                                    <td>{{ $item->batasPengembalianFormat() }}</td>
                                                    <td class="td-detail">
                                                        <button class="btn-detail-soft btn-detail">
                                                            <span class="icon-wrap">
                                                                <i class="fas fa-plus"></i>
                                                            </span>
                                                        </button>
                                                        <div class="detail-alat mt-2" style="display:none;">
                                                            @foreach ($item->tipeAlat as $detail)
                                                                <div class="mb-3 pb-2 border-bottom">
                                                                    <div
                                                                        class="d-flex justify-content-between align-items-center">
                                                                        <span class="fw-semibold">
                                                                            {{ ucwords($detail->nama_tipe) }}
                                                                        </span>
                                                                        <small class="text-muted">
                                                                            x{{ $detail->pivot->quantity }}
                                                                        </small>
                                                                    </div>
                                                                    <div class="mt-2 ps-2">
                                                                        @foreach ($item->detailAlat->where('id_tipe', $detail->id_tipe) as $alat)
                                                                            <div class="text-muted small">
                                                                                • {{ $alat->kode_alat }}
                                                                            </div>
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="badge {{ badgeClass($item->status_pinjam) }} px-3 py-2 rounded-pill">
                                                            {{ ucwords($item->status_pinjam) }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('modal')
    <div class="modal fade modal-validasi" id="modal-validasi" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content modal-premium">
                <div class="modal-header">
                    <div>
                        <h5 class="modal-title fw-bold text-white">
                            <i class="fa-solid fa-file-zipper mr-2"></i>
                            Validasi Pengembalian
                        </h5>
                        <p class="text-white mb-0 small">
                            Periksa tipe alat, kode, dan kondisi masing-masing item alat
                        </p>
                    </div>
                    <button type="button" class="close text-white" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <form id="form-validasi" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="pinjam-card mb-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="info-item">
                                        <span>ID Pinjam</span>
                                        <strong id="v-id-pinjam">-</strong>
                                    </div>
                                    <div class="info-item">
                                        <span>Nama Siswa</span>
                                        <strong id="v-nama-siswa">-</strong>
                                    </div>
                                    <div class="info-item">
                                        <span>Kelas</span>
                                        <strong id="v-kelas">-</strong>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-item">
                                        <span>Tanggal Pinjam</span>
                                        <strong id="v-tanggal-mulai">-</strong>
                                    </div>
                                    <div class="info-item">
                                        <span>Batas Kembali</span>
                                        <strong id="v-batas-kembali">-</strong>
                                    </div>
                                    <div class="info-item">
                                        <span>Keterlambatan & Kelengkapan</span>
                                        <strong id="v-terlambat">-</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-wrapper">
                            <div class="table-head">
                                <span>Tipe Alat</span>
                            </div>
                            <div id="v-alat"></div>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-back" data-dismiss="modal">
                            <i class="fa-solid fa-arrow-left"></i>Batal
                        </button>
                        <button type="submit" class="btn btn-universal">
                            <i class="fa fa-thumbs-up mr-1"></i>
                            Validasi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="cancel-success" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content text-center p-4">
                <div class="modal-body font-18">
                    <h3 class="mb-20">Berhasil!</h3>
                    <div class="mb-30">
                        <img src="{{ asset('deskap/vendors/images/success.png') }}" alt="success" />
                    </div>
                    <p id="cancel-success-text"></p>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="validasi-success" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content text-center p-4">
                <div class="modal-body font-18">
                    <h3 class="mb-20">Berhasil!</h3>
                    <div class="mb-30">
                        <img src="{{ asset('deskap/vendors/images/success.png') }}" alt="success" />
                    </div>
                    <p id="validasi-success-text"></p>
                </div>
            </div>
        </div>
    </div>


@endsection
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/peminjaman.js') }}"></script>
    <script>
        $(document).ready(function() {
            @if (session('cancel_success'))
                $('#cancel-success-text').html(
                    '{{ session('cancel_success') }}'
                );

                $('#cancel-success').modal('show');

                setTimeout(function() {
                    $('#cancel-success').modal('hide');
                }, 3000);
            @endif

            @if (session('cancel_error'))
                toastr.error("{{ session('cancel_error') }}", "Terjadi Kesalahan", {
                    timeOut: 5000,
                    progressBar: true,
                    closeButton: true
                });
            @endif

            @if (session('validasi_success'))
                $('#validasi-success-text').html(
                    'Peminjaman dengan ID Pinjam <strong>{{ session('validasi_success') }}</strong> berhasil divalidasi'
                );

                $('#validasi-success').modal('show');

                setTimeout(function() {
                    $('#validasi-success').modal('hide');
                }, 3000);
            @endif

            @if (session('validasi_error'))
                toastr.error("{{ session('validasi_error') }}", "Terjadi Kesalahan", {
                    timeOut: 5000,
                    progressBar: true,
                    closeButton: true
                });
            @endif
        });
    </script>
@endpush

{{-- @extends('layouts.admin')
@section('title', 'Peminjaman')
@section('link')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/content.css') }}">
    <link rel="stylesheet" href="{{ asset('css/universal.css') }}">
    <link rel="stylesheet" href="{{ asset('css/peminjaman.css') }}">
    <link rel="stylesheet" href="{{ asset('css/table.css') }}">
    <link rel="stylesheet" href="{{ asset('css/filter.css') }}">
    <link rel="stylesheet" href="{{ asset('css/modal.css') }}">
    <link rel="stylesheet" href="{{ asset('css/button.css') }}">
@endsection
@section('content')
    @php
        function badgeClass($status)
        {
            if ($status == 'batal') {
                return 'badge-soft-danger';
            } elseif ($status == 'menunggu') {
                return 'badge-soft-warning';
            } elseif ($status == 'siap diambil') {
                return 'badge-soft-success';
            } elseif ($status == 'aktif') {
                return 'badge-soft-primary';
            } else {
                return 'badge-soft-purple';
            }
        }
    @endphp
    <div class="pd-ltr-20 xs-pd-20-10">
        <div class="min-height-200px">
            <div class="page-header">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="title">
                            <h4>Data Peminjaman</h4>
                        </div>
                        <nav aria-label="breadcrumb" role="navigation">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <i class="bx bx-home"></i>
                                    <a href="{{ route('dashboardAdmin.index') }}">Dashboard Admin</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Data Peminjaman
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="col-12 mb-4 p-0">
                <div class="tab-system">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link {{ $tab == 'menunggu' ? 'active' : '' }} text-blue" data-toggle="tab"
                                href="#menunggu" role="tab" aria-selected="true">Menunggu</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $tab == 'siap-diambil' ? 'active' : '' }} text-blue" data-toggle="tab"
                                href="#siap-diambil" role="tab" aria-selected="false">Siap Diambil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $tab == 'aktif' ? 'active' : '' }} text-blue" data-toggle="tab"
                                href="#aktif" role="tab" aria-selected="false">Aktif</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $tab == 'proses-pengembalian' ? 'active' : '' }} text-blue"
                                data-toggle="tab" href="#proses-pengembalian" role="tab" aria-selected="false">Proses
                                Pengembalian</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $tab == 'batal' ? 'active' : '' }} text-blue" data-toggle="tab"
                                href="#batal" role="tab" aria-selected="false">Dibatalkan</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade tab-custom px-3 {{ $tab == 'menunggu' ? 'show active' : '' }}"
                            id="menunggu" role="tabpanel">
                            <div class="row align-items-center">
                                <div class="col-md-6 col-12 mb-md-0">
                                    <div class="input-group mt-4 mb-0">
                                        <div id="search-wrapper-menunggu" class="pr-2"></div>

                                    </div>
                                </div>
                                <div class="col-md-6 col-12 d-flex gap-2 flex-wrap justify-content-md-end mt-2">
                                    <div id="show-entries-menunggu"></div>
                                </div>
                            </div>
                            <div class="pb-20 pt-1">
                                <div class="table-responsive">
                                    <table class="data-table table hover py-3 px-4 border-0 py-3 px-4 border-0"
                                        style="background: #e9edf9b1 !important; border-radius: 22px;" id="table-menunggu"
                                        style="background: #e9edf9b1 !important; border-radius: 22px;">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Nama Siswa</th>
                                                <th>Kelas</th>
                                                <th>Tanggal Pemakaian</th>
                                                <th>Batas Pengembalian</th>
                                                <th>Status</th>
                                                <th>Alat</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($peminjamanMenunggu as $index => $item)
                                                <tr>
                                                    <td>
                                                        <div class="no-badge">{{ $index + 1 }}.</div>
                                                    </td>
                                                    <td>{{ ucwords($item->siswa->nama_siswa) }}</td>
                                                    <td>{{ strtoupper($item->siswa->kelas) }}</td>
                                                    <td>{{ $item->tanggalPemakaianFormat() }}</td>
                                                    <td>{{ $item->batasPengembalianFormat() }}</td>
                                                    <td>
                                                        <span
                                                            class="badge {{ badgeClass($item->status_pinjam) }} px-3 py-2 rounded-pill">
                                                            {{ ucwords($item->status_pinjam) }}
                                                        </span>
                                                    </td>
                                                    <td class="td-detail">
                                                        <button class="btn-detail-soft btn-detail">
                                                            <span class="icon-wrap">
                                                                <i class="fas fa-plus"></i>
                                                            </span>
                                                        </button>
                                                        <div class="detail-alat mt-2" style="display:none;">
                                                            @foreach ($item->tipeAlat as $detail)
                                                                <div class="mb-3 pb-2 border-bottom">
                                                                    <div
                                                                        class="d-flex justify-content-between align-items-center">
                                                                        <span class="fw-semibold">
                                                                            {{ ucwords($detail->nama_tipe) }}
                                                                        </span>
                                                                        <small class="text-muted">
                                                                            x{{ $detail->pivot->quantity }}
                                                                        </small>
                                                                    </div>
                                                                    <div class="mt-2 ps-2">
                                                                        @foreach ($item->detailAlat->where('id_tipe', $detail->id_tipe) as $alat)
                                                                            <div class="text-muted small">
                                                                                • {{ $alat->kode_alat }}
                                                                            </div>
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <form action="{{ route('peminjaman.cancel', $item->id_pinjam) }}"
                                                            method="POST">
                                                            @csrf
                                                            <input type="hidden" name="tab" value="menunggu">
                                                            <button type="submit" class="btn-cancel-soft"
                                                                title="Batalkan">
                                                                <i class="fa-solid fa-circle-xmark"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade tab-custom px-3 {{ $tab == 'siap-diambil' ? 'show active' : '' }}"
                            id="siap-diambil" role="tabpanel">
                            <div class="row align-items-center">
                                <div class="col-md-6 col-12 mb-md-0">
                                    <div class="input-group mt-3 mb-0">
                                        <div id="search-wrapper-siap-diambil" class="pr-2"></div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12 d-flex gap-2 flex-wrap justify-content-md-end mt-2">
                                    <div id="show-entries-siap-diambil"></div>
                                </div>
                            </div>
                            <div class="pb-20 pt-1">
                                <div class="table-responsive">
                                    <table class="data-table table hover py-3 px-4 border-0" id="table-siap-diambil"
                                        style="background: #e9edf9b1 !important; border-radius: 22px;">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Nama Siswa</th>
                                                <th>Kelas</th>
                                                <th>Tanggal Pemakaian</th>
                                                <th>Batas Pengembalian</th>
                                                <th>Status</th>
                                                <th>Alat</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($peminjamanSiapDiambil as $index => $item)
                                                <tr>
                                                    <td>
                                                        <div class="no-badge">{{ $index + 1 }}.</div>
                                                    </td>
                                                    <td>{{ ucwords($item->siswa->nama_siswa) }}</td>
                                                    <td>{{ strtoupper($item->siswa->kelas) }}</td>
                                                    <td>{{ $item->tanggalPemakaianFormat() }}</td>
                                                    <td>{{ $item->batasPengembalianFormat() }}</td>
                                                    <td>
                                                        <span
                                                            class="badge {{ badgeClass($item->status_pinjam) }} px-3 py-2 rounded-pill">
                                                            {{ ucwords($item->status_pinjam) }}
                                                        </span>
                                                    </td>
                                                    <td class="td-detail">
                                                        <button class="btn-detail-soft btn-detail">
                                                            <span class="icon-wrap">
                                                                <i class="fas fa-plus"></i>
                                                            </span>
                                                        </button>
                                                        <div class="detail-alat mt-2" style="display:none;">
                                                            @foreach ($item->tipeAlat as $detail)
                                                                <div class="mb-3 pb-2 border-bottom">
                                                                    <div
                                                                        class="d-flex justify-content-between align-items-center">
                                                                        <span class="fw-semibold">
                                                                            {{ ucwords($detail->nama_tipe) }}
                                                                        </span>
                                                                        <small class="text-muted">
                                                                            x{{ $detail->pivot->quantity }}
                                                                        </small>
                                                                    </div>
                                                                    <div class="mt-2 ps-2">
                                                                        @foreach ($item->detailAlat->where('id_tipe', $detail->id_tipe) as $alat)
                                                                            <div class="text-muted small">
                                                                                • {{ $alat->kode_alat }}
                                                                            </div>
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="action-group">
                                                            <form
                                                                action="{{ route('peminjaman.cancel', $item->id_pinjam) }}"
                                                                method="POST" class="m-0">
                                                                @csrf
                                                                <input type="hidden" name="tab"
                                                                    value="siap-diambil">
                                                                <button type="submit" class="btn-cancel-soft"
                                                                    title="Batalkan">
                                                                    <i class="fa-solid fa-circle-xmark"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade tab-custom px-3 {{ $tab == 'aktif' ? 'show active' : '' }}"
                            id="aktif" role="tabpanel">
                            <div class="row align-items-center">
                                <div class="col-md-6 col-12 mb-md-0">
                                    <div class="input-group mt-3 mb-0">
                                        <div id="search-wrapper-aktif" class="pr-2"></div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12 d-flex gap-2 flex-wrap justify-content-md-end mt-2">
                                    <div id="show-entries-aktif"></div>
                                </div>
                            </div>
                            <div class="pb-20 pt-1">
                                <div class="table-responsive">
                                    <table class="data-table table hover py-3 px-4 border-0" id="table-aktif"
                                        style="background: #e9edf9b1 !important; border-radius: 22px;">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>ID Peminjaman</th>
                                                <th>Nama Siswa</th>
                                                <th>Kelas</th>
                                                <th>Tanggal Pemakaian</th>
                                                <th>Batas Pengembalian</th>
                                                <th>Keterlambatan</th>
                                                <th>Status</th>
                                                <th>Alat</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($peminjamanAktif as $index => $item)
                                                <tr>
                                                    <td>
                                                        <div class="no-badge">{{ $index + 1 }}.</div>
                                                    </td>
                                                    <td>PJM-0{{ $item->id_pinjam }}</td>
                                                    <td>{{ ucwords($item->siswa->nama_siswa) }}</td>
                                                    <td>{{ strtoupper($item->siswa->kelas) }}</td>
                                                    <td>{{ $item->tanggalPemakaianFormat() }}</td>
                                                    <td>{{ $item->batasPengembalianFormat() }}</td>
                                                    <td>
                                                        @if ($item->terlambat())
                                                            <span class="badge badge-soft-danger rounded-pill">
                                                                Terlambat
                                                            </span>
                                                            <div class="menit-terlambat mt-1 ml-1">
                                                                {{ $item->keterlambatanText() }}
                                                            </div>
                                                        @else
                                                            <span class=" badge badge-soft-success rounded-pill">
                                                                Tepat Waktu
                                                            </span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="badge {{ badgeClass($item->status_pinjam) }} px-3 py-2 rounded-pill">
                                                            {{ ucwords($item->status_pinjam) }}
                                                        </span>
                                                    </td>
                                                    <td class="td-detail">
                                                        <button class="btn-detail-soft btn-detail">
                                                            <span class="icon-wrap">
                                                                <i class="fas fa-plus"></i>
                                                            </span>
                                                        </button>
                                                        <div class="detail-alat mt-2" style="display:none;">
                                                            @foreach ($item->tipeAlat as $detail)
                                                                <div class="mb-3 pb-2 border-bottom">
                                                                    <div
                                                                        class="d-flex justify-content-between align-items-center">
                                                                        <span class="fw-semibold">
                                                                            {{ ucwords($detail->nama_tipe) }}
                                                                        </span>
                                                                        <small class="text-muted">
                                                                            x{{ $detail->pivot->quantity }}
                                                                        </small>
                                                                    </div>
                                                                    <div class="mt-2 ps-2">
                                                                        @foreach ($item->detailAlat->where('id_tipe', $detail->id_tipe) as $alat)
                                                                            <div class="text-muted small">
                                                                                • {{ $alat->kode_alat }}
                                                                            </div>
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade tab-custom px-3 {{ $tab == 'proses-pengembalian' ? 'show active' : '' }}"
                            id="proses-pengembalian" role="tabpanel">
                            <div class="row align-items-center">
                                <div class="col-md-6 col-12 mb-md-0">
                                    <div class="input-group mt-3 mb-0">
                                        <div id="search-wrapper-proses-pengembalian" class="pr-2"></div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12 d-flex gap-2 flex-wrap justify-content-md-end mt-2">
                                    <div id="show-entries-proses-pengembalian"></div>
                                </div>
                            </div>
                            <div class="pb-20 pt-1">
                                <div class="table-responsive">
                                    <table class="data-table table hover py-3 px-4 border-0"
                                        id="table-proses-pengembalian"
                                        style="background: #e9edf9b1 !important; border-radius: 22px;">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>ID Peminjaman</th>
                                                <th>Nama Siswa</th>
                                                <th>Kelas</th>
                                                <th>Tanggal Pemakaian</th>
                                                <th>Batas Pengembalian</th>
                                                <th>Keterlambatan</th>
                                                <th>Status</th>
                                                <th>Alat</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($peminjamanProsesPengembalian as $index => $item)
                                                <tr>
                                                    <td>
                                                        <div class="no-badge">{{ $index + 1 }}.</div>
                                                    </td>
                                                    <td>PJM-0{{ $item->id_pinjam }}</td>
                                                    <td>{{ ucwords($item->siswa->nama_siswa) }}</td>
                                                    <td>{{ strtoupper($item->siswa->kelas) }}</td>
                                                    <td>{{ $item->tanggalPemakaianFormat() }}</td>
                                                    <td>{{ $item->batasPengembalianFormat() }}</td>
                                                    <td>
                                                        @if ($item->terlambat())
                                                            <span class="badge badge-soft-danger rounded-pill">
                                                                Terlambat
                                                            </span>
                                                            <div class="menit-terlambat mt-1 ml-1">
                                                                {{ $item->keterlambatanText() }}
                                                            </div>
                                                        @else
                                                            <span class=" badge badge-soft-success rounded-pill">
                                                                Tepat Waktu
                                                            </span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="badge {{ badgeClass($item->status_pinjam) }} px-3 py-2 rounded-pill">
                                                            {{ ucwords($item->status_pinjam) }}
                                                        </span>
                                                    </td>
                                                    <td class="td-detail">
                                                        <button class="btn-detail-soft btn-detail">
                                                            <span class="icon-wrap">
                                                                <i class="fas fa-plus"></i>
                                                            </span>
                                                        </button>
                                                        <div class="detail-alat mt-2" style="display:none;">
                                                            @foreach ($item->tipeAlat as $detail)
                                                                <div class="mb-3 pb-2 border-bottom">
                                                                    <div
                                                                        class="d-flex justify-content-between align-items-center">
                                                                        <span class="fw-semibold">
                                                                            {{ ucwords($detail->nama_tipe) }}
                                                                        </span>
                                                                        <small class="text-muted">
                                                                            x{{ $detail->pivot->quantity }}
                                                                        </small>
                                                                    </div>
                                                                    <div class="mt-2 ps-2">
                                                                        @foreach ($item->detailAlat->where('id_tipe', $detail->id_tipe) as $alat)
                                                                            <div class="text-muted small">
                                                                                • {{ $alat->kode_alat }}
                                                                            </div>
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn-validasi-soft" title="Validasi"
                                                            data-toggle="modal" data-target="#modal-validasi"
                                                            data-id-pinjam="{{ $item->id_pinjam }}"
                                                            data-nama-siswa="{{ ucwords($item->siswa->nama_siswa) }}"
                                                            data-kelas="{{ strtoupper($item->siswa->kelas) }}"
                                                            data-tanggal-mulai="{{ $item->tanggalPeminjamanFormat() }}"
                                                            data-batas-kembali="{{ $item->batasKembaliFormat() }}"
                                                            data-terlambat="{{ $item->terlambat() ? 1 : 0 }}"
                                                            data-terlambat-text="{{ $item->keterlambatanText() }}"
                                                            data-alat='@json($item->detailAlat->load('tipeAlat'))'>
                                                            <i class="fa-solid fa-check-to-slot"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade tab-custom px-3 {{ $tab == 'batal' ? 'show active' : '' }}"
                            id="batal" role="tabpanel">
                            <div class="row align-items-center">
                                <div class="col-md-6 col-12 mb-md-0">
                                    <div class="input-group mt-3 mb-0">
                                        <div id="search-wrapper-batal" class="pr-2"></div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12 d-flex gap-2 flex-wrap justify-content-md-end mt-2">
                                    <div id="show-entries-batal"></div>
                                </div>
                            </div>
                            <div class="pb-20 pt-1">
                                <div class="table-responsive">
                                    <table class="data-table table hover py-3 px-4 border-0" id="table-batal"
                                        style="background: #e9edf9b1 !important; border-radius: 22px;">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Nama Siswa</th>
                                                <th>Kelas</th>
                                                <th>Tanggal Pemakaian</th>
                                                <th>Batas Pengembalian</th>
                                                <th>Alat</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($peminjamanBatal as $index => $item)
                                                <tr>
                                                    <td>
                                                        <div class="no-badge">{{ $index + 1 }}.</div>
                                                    </td>
                                                    <td>{{ ucwords($item->siswa->nama_siswa) }}</td>
                                                    <td>{{ strtoupper($item->siswa->kelas) }}</td>
                                                    <td>{{ $item->tanggalPemakaianFormat() }}</td>
                                                    <td>{{ $item->batasPengembalianFormat() }}</td>
                                                    <td class="td-detail">
                                                        <button class="btn-detail-soft btn-detail">
                                                            <span class="icon-wrap">
                                                                <i class="fas fa-plus"></i>
                                                            </span>
                                                        </button>
                                                        <div class="detail-alat mt-2" style="display:none;">
                                                            @foreach ($item->tipeAlat as $detail)
                                                                <div class="mb-3 pb-2 border-bottom">
                                                                    <div
                                                                        class="d-flex justify-content-between align-items-center">
                                                                        <span class="fw-semibold">
                                                                            {{ ucwords($detail->nama_tipe) }}
                                                                        </span>
                                                                        <small class="text-muted">
                                                                            x{{ $detail->pivot->quantity }}
                                                                        </small>
                                                                    </div>
                                                                    <div class="mt-2 ps-2">
                                                                        @foreach ($item->detailAlat->where('id_tipe', $detail->id_tipe) as $alat)
                                                                            <div class="text-muted small">
                                                                                • {{ $alat->kode_alat }}
                                                                            </div>
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="badge {{ badgeClass($item->status_pinjam) }} px-3 py-2 rounded-pill">
                                                            {{ ucwords($item->status_pinjam) }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('modal')
    <div class="modal fade modal-validasi" id="modal-validasi" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content modal-premium">
                <div class="modal-header">
                    <div>
                        <h5 class="modal-title fw-bold text-white">
                            <i class="fa-solid fa-file-zipper mr-2"></i>
                            Validasi Pengembalian
                        </h5>
                        <p class="text-white mb-0 small">
                            Periksa tipe alat, kode, dan kondisi masing-masing item alat
                        </p>
                    </div>
                    <button type="button" class="close text-white" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <form id="form-validasi" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="pinjam-card mb-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="info-item">
                                        <span>ID Pinjam</span>
                                        <strong id="v-id-pinjam">-</strong>
                                    </div>
                                    <div class="info-item">
                                        <span>Nama Siswa</span>
                                        <strong id="v-nama-siswa">-</strong>
                                    </div>
                                    <div class="info-item">
                                        <span>Kelas</span>
                                        <strong id="v-kelas">-</strong>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-item">
                                        <span>Tanggal Pinjam</span>
                                        <strong id="v-tanggal-mulai">-</strong>
                                    </div>
                                    <div class="info-item">
                                        <span>Batas Kembali</span>
                                        <strong id="v-batas-kembali">-</strong>
                                    </div>
                                    <div class="info-item">
                                        <span>Keterlambatan & Kelengkapan</span>
                                        <strong id="v-terlambat">-</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-wrapper">
                            <div class="table-head">
                                <span>Tipe Alat</span>
                            </div>
                            <div id="v-alat"></div>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-back" data-dismiss="modal">
                            <i class="fa-solid fa-arrow-left"></i>Batal
                        </button>
                        <button type="submit" class="btn btn-universal">
                            <i class="fa fa-thumbs-up mr-1"></i>
                            Validasi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="cancel-success" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content text-center p-4">
                <div class="modal-body font-18">
                    <h3 class="mb-20">Berhasil!</h3>
                    <div class="mb-30">
                        <img src="{{ asset('deskap/vendors/images/success.png') }}" alt="success" />
                    </div>
                    <p id="cancel-success-text"></p>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="validasi-success" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content text-center p-4">
                <div class="modal-body font-18">
                    <h3 class="mb-20">Berhasil!</h3>
                    <div class="mb-30">
                        <img src="{{ asset('deskap/vendors/images/success.png') }}" alt="success" />
                    </div>
                    <p id="validasi-success-text"></p>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/peminjaman.js') }}"></script>
    <script>
        $(document).ready(function() {
            @if (session('cancel_success'))
                $('#cancel-success-text').html(
                    '{{ session('cancel_success') }}'
                );

                $('#cancel-success').modal('show');

                setTimeout(function() {
                    $('#cancel-success').modal('hide');
                }, 3000);
            @endif

            @if (session('cancel_error'))
                toastr.error("{{ session('cancel_error') }}", "Terjadi Kesalahan", {
                    timeOut: 5000,
                    progressBar: true,
                    closeButton: true
                });
            @endif

            @if (session('validasi_success'))
                $('#validasi-success-text').html(
                    'Peminjaman dengan ID Pinjam <strong>{{ session('validasi_success') }}</strong> berhasil divalidasi'
                );

                $('#validasi-success').modal('show');

                setTimeout(function() {
                    $('#validasi-success').modal('hide');
                }, 3000);
            @endif

            @if (session('validasi_error'))
                toastr.error("{{ session('validasi_error') }}", "Terjadi Kesalahan", {
                    timeOut: 5000,
                    progressBar: true,
                    closeButton: true
                });
            @endif
        });
    </script>
@endpush --}}
