@extends('layouts.siswa')
@section('title', 'Scan & Input Alat')
@section('link')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/universal.css') }}">
    <link rel="stylesheet" href="{{ asset('css/add.css') }}">
    <link rel="stylesheet" href="{{ asset('css/button.css') }}">
@endsection
@section('content')
    <div class="pd-ltr-20 xs-pd-20-10">
        <div class="min-height-200px">
            <div class="page-header">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <nav aria-label="breadcrumb" role="navigation">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <i class="fa-solid fa-house"></i>
                                    <a href="{{ route('dashboardSiswa.index') }}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="{{ route('peminjamanSiswa.index') }}">Peminjaman</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="#">Proses Pengembalian</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Scan QR Code
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="row g-4 justify-content-center" style="margin-top: 20px;">
                <div class="col-lg-5">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-primary text-white card-scan">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-qr-code-scan me-2"></i>
                                <strong style="font-size: 20px; font-weight: 800;" class="judul-scan">Scan QR / Input Kode</strong>
                            </div>

                            <!-- ROW 2 -->
                            <div class="small mt-1 text-scan">
                                Gunakan kamera atau masukkan kode alat secara manual
                            </div>
                        </div>
                        <div>



                        </div>
                        <div class="card-body p-3">
                            <div class="scanner-wrapper">
                                <div id="reader" class="scanner-box"></div>

                                <div id="emptyScanState" class="scanner-overlay text-center pt-2 pb-3">
                                    <div style="font-size: 50px;">📷</div>
                                    <h6 class="mt-2 text-reader" style="color: #2e6e9c">Scanner Siap Digunakan</h6>
                                    <p class="text-muted mb-0" style="font-size: 12px">
                                        Tekan tombol untuk mulai scan QR Code
                                    </p>
                                </div>
                            </div>

                            <div class="scan-control mb-2">
                                <button type="button" id="btnScan" onclick="toggleScanner()"
                                    class="btn-scan-toggle btn-success mt-3">
                                    <i class="bi bi-camera-video-fill"></i> Mulai Scan
                                </button>

                            </div>
                            <div class="input-group manual-group mt-3 mb-2">
                                <input type="text" id="input-manual" class="form-control"
                                    placeholder="Masukkan kode alat">
                                <button class="btn btn-universal" id="add-manual">
                                    <i class="bi bi-plus-lg"></i>
                                    Tambah
                                </button>
                            </div>
                            <small class="scan-note">
                                Scan QR atau input manual
                            </small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="card inventory-card shadow-sm border-0">
                        <div class="card-header inventory-header text-white card-pinjam">

                            <div class="d-flex justify-content-between align-items-start pinjam-header">

                                <!-- LEFT SIDE -->
                                <div class="pinjam-left">

                                    <!-- ROW 1 -->
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-box-seam me-2"></i>
                                        <strong style="font-size: 20px; font-weight: 800;" class="judul-scan">Alat Dipinjam</strong>
                                    </div>

                                    <!-- ROW 2 -->
                                    <div class="small mt-1 text-scan">
                                        Scan semua alat sebelum pengembalian
                                    </div>

                                </div>


                                <!-- RIGHT SIDE -->
                                <!-- RIGHT SIDE -->
                                <div class="pinjam-right">

                                    <div class="pinjam-id-badge">
                                        <i class="bi bi-receipt" style="margin-right: 0px;"></i>
                                        <span class="text-pesan">ID Pinjam: </span>
                                        <strong class="text-pesan">PJM-0{{ $peminjaman->id_pinjam }}</strong>
                                    </div>

                                    <div class="progress-box " id="progressScan">
                                        0 / 0
                                    </div>

                                </div>

                            </div>

                        </div>
                        <div class="card-body inventory-scroll p-3">




                            <!-- LIST INVENTORY -->
                            <div id="peminjaman-checkpoint">
                                @foreach ($peminjaman->tipeAlat as $detail)
                                    <div class="inventory-item mb-3 px-3 py-2 rounded-3 border bg-white shadow-sm"
                                        data-id-tipe="{{ $detail->id_tipe }}">

                                        <div class="item-top d-flex justify-content-between">
                                            <div>
                                                <h6 class="mb-0 fw-semibold scan-nama-tipe">
                                                    {{ ucwords($detail->nama_tipe) }}
                                                </h6>
                                                <small class="text-muted scan-nama-jenis">
                                                    {{ ucwords($detail->jenisAlat->nama_jenis) }}
                                                </small>
                                            </div>

                                            <span class="qty-badge px-2 py-1 rounded ">
                                                x{{ $detail->pivot->quantity }}
                                            </span>
                                        </div>

                                        <div class="code-box mt-2">
                                            <span class="label scan-kode-alat">Kode Alat</span>
                                            <div class="codes">
                                                @foreach ($peminjaman->detailAlat->where('id_tipe', $detail->id_tipe) as $alat)
                                                    <span class="code py-1 px-2">
                                                        {{ $alat->kode_alat }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        </div>



                                    </div>
                                @endforeach
                            </div>

                        </div>
                    </div>
                </div>
                {{-- <div class="col-lg-5">
                    <div class="card inventory-card shadow-sm border-0">
                        <div class="card-header inventory-header text-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div>
                                        <i class="bi bi-box-seam me-2"></i>
                                        <strong>Alat Dipesan</strong>
                                    </div>
                                    <div class="small mt-1">
                                        Batas Pengembalian:
                                        <strong>
                                            {{ \Carbon\Carbon::parse($peminjaman->tanggal_selesai . ' ' . $peminjaman->jam_selesai)->translatedFormat('d F Y H:i') }}
                                        </strong>
                                    </div>
                                </div>
                                <span class="badge bg-light" id="progressScan">
                                    0 / 0
                                </span>
                            </div>
                        </div>
                        <div class="card-body inventory-scroll p-3">
                            <div id="peminjaman-checkpoint">
                                @foreach ($peminjaman->tipeAlat as $detail)
                                    <div class="inventory-item">
                                        <div class="item-top">
                                            <div>
                                                <h6 class="mb-0">{{ ucwords($detail->nama_tipe) }}</h6>
                                                <small
                                                    class="text-muted">{{ ucwords($detail->jenisAlat->nama_jenis) }}</small>
                                            </div>
                                            <span class="qty-badge">x{{ $detail->pivot->quantity }}</span>
                                        </div>
                                        <div class="code-box mt-2">
                                            <span class="label">Kode Alat</span>
                                            <div class="codes">
                                            </div>
                                        </div>
                                        <div class="status-bar mt-3 alat-checkpoint" data-tipe="{{ $detail->nama_tipe }}">
                                            @for ($i = 0; $i < $detail->pivot->quantity; $i++)
                                                <i class="bi bi-check-circle-fill scan-check text-secondary"></i>
                                            @endfor
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>
            {{-- <div class="row g-4 justify-content-center" style="margin-top: 20px;">
                <div class="col-lg-5">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-primary text-white">
                            <i class="bi bi-qr-code-scan me-2"></i> Scan QR / Input Kode
                        </div>
                        <div class="card-body p-3">
                            <div id="reader" class="mb-2 scanner-box"></div>
                            <div class="scan-control mb-2">
                                <button type="button" id="btnScan" onclick="toggleScanner()" class="btn-scan-toggle">
                                    Stop Scan
                                </button>
                            </div>
                            <div class="input-group manual-group mt-3 mb-2">
                                <input type="text" id="input-manual" class="form-control"
                                    placeholder="Masukkan kode alat">
                                <button class="btn btn-universal" id="add-manual">
                                    <i class="bi bi-plus-lg"></i>
                                    Tambah
                                </button>
                            </div>
                            <small class="scan-note">
                                Scan QR atau input manual
                            </small>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="card inventory-card shadow-sm border-0">
                        <div class="card-header inventory-header text-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="bi bi-tools me-2"></i>
                                    <strong>Alat Dipinjam</strong>
                                </div>
                                <span class="badge bg-light" id="progressScan">
                                    0 / 0
                                </span>
                            </div>
                        </div>
                        <div class="card-body inventory-scroll p-3">
                            <div id="peminjaman-checkpoint">
                                @foreach ($peminjaman->tipeAlat as $detail)
                                    <div class="inventory-item">
                                        <div class="item-top">
                                            <div>
                                                <h6 class="mb-0">{{ ucwords($detail->nama_tipe) }}</h6>
                                                <small class="text-muted">
                                                    {{ ucwords($detail->jenisAlat->nama_jenis) }}
                                                </small>
                                            </div>
                                            <span class="qty-badge">
                                                x{{ $detail->pivot->quantity }}
                                            </span>
                                        </div>
                                        <div class="code-box mt-2">
                                            <span class="label">Kode Alat</span>
                                            <div class="codes">
                                                @foreach ($peminjaman->detailAlat->where('id_tipe', $detail->id_tipe) as $alat)
                                                    <span class="code py-1 px-2">
                                                        {{ $alat->kode_alat }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="status-bar mt-3 alat-checkpoint" data-id-tipe="{{ $detail->id_tipe }}">
                                            @for ($i = 0; $i < $detail->pivot->quantity; $i++)
                                                <i class="bi bi-check-circle-fill scan-check text-secondary"></i>
                                            @endfor
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
    <form id="form-pinjam" method="POST" action="{{ route('prosesPengembalian.scan', $peminjaman->id_pinjam) }}">
        @csrf
        @method('PUT')
        <input type="hidden" name="alat" id="alat">
        <button type="button" class="btn btn-success fixed-confirm-btn" id="btn-konfirmasi" onclick="submitPinjam()">
            <i class="fa fa-thumbs-up mr-1"></i> Konfirmasi
        </button>
    </form>
@endsection
@push('scripts')
    <script src="{{ asset('js/html5-qrcode.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        let daftarKodePeminjaman = @json($peminjaman->detailAlat->pluck('kode_alat'));
        let daftarPeminjaman = @json($peminjaman->tipeAlat);
        let successSoundPath = "{{ asset('sounds/success.mp3') }}";
    </script>
    <script src="{{ asset('js/scanKembali.js') }}"></script>
    <script>
        $(document).ready(function() {
            @if (session('prosesPengembalianScan_error'))
                toastr.error(
                    'Proses pengembalian alat dengan ID Pinjam PJM-0{{ session('prosesPengembalianScan_error') }} gagal dilakukan!',
                    "Terjadi Kesalahan", {
                        timeOut: 5000,
                        progressBar: true,
                        closeButton: true
                    });
            @endif
        });
    </script>
@endpush
