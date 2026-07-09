@extends('layouts.kabeng')
@section('link')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/content.css') }}">
    <link rel="stylesheet" href="{{ asset('css/universal.css') }}">
    <link rel="stylesheet" href="{{ asset('css/table.css') }}">
    <link rel="stylesheet" href="{{ asset('css/button.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/filter.css') }}">
@endsection
@section('content')
    <div class="pd-ltr-20 xs-pd-20-10">
        <div class="min-height-200px">
            <div class="dashboard-grid">
                <div class="stat-card">
                    <div class="stat-icon bg-blue">
                        <i class="fa-solid fa-user-graduate"></i>
                    </div>
                    <div class="stat-info">
                        <p>Total Siswa</p>
                        <h3 class="counter" data-target={{ $siswa }}>{{ $siswa }}</h3>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon bg-purple">
                        <i class="fa-solid fa-screwdriver-wrench"></i>
                    </div>
                    <div class="stat-info">
                        <p>Alat Layak Pakai</p>
                        <h3 class="counter" data-target={{ $alat }}>{{ $alat }}</h3>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon bg-orange">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                    </div>
                    <div class="stat-info">
                        <p>Alat Bermasalah</p>
                        <h3 class="counter" data-target={{ $alatBermasalah }}>{{ $alatBermasalah }}</h3>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon bg-orange">
                        <i class="bi bi-box-seam"></i>
                    </div>
                    <div class="stat-info">
                        <p>Total Jenis</p>
                        <h3 class="counter" data-target={{ $jenis }}>{{ $jenis }}</h3>
                    </div>
                </div>
            </div>

            <div class="row g-3">
                <div class="col-md-6 mb-0 box-jenis">
                    <div class="pd-20 card-kondisi card-box card-jenis">
                        <h4 class="h4 text-dark d-flex align-items-center gap-2">
                            Distribusi Jenis Alat

                        </h4>
                        <hr class="my-1">

                        <div id="chart8"></div>

                        <hr class="m-0">

                        <div class="table-responsive">
                            <table class="data-table table hover multiple-select-row py-0 px-1 border-0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Jenis</th>
                                        <th>Tipe Alat</th>

                                        <th>Stok</th>

                                    </tr>
                                </thead>
                                <tbody id="list-alat">
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">
                                            Klik chart untuk melihat data
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
                <div class="col-md-6 mb-0 px-2 card-alat-pinjam">
                    <div class="pd-20 card-box height-100-p booking-card">

                        <h4 class="h4 text-dark d-flex align-items-center gap-2">
                            5 Alat Paling Sering Dipinjam
                        </h4>

                        <hr class="my-1">

                        <div id="chart-top-alat"></div>

                    </div>
                </div>

            </div>

            <div class="pd-20 card-box height-100-p lacak-card">
                <h4 class="h4 text-dark d-flex align-items-center gap-2">
                    Lacak Penggunaan Alat
                </h4>
                <hr class="my-1">
                <div class="lacak-header p-2 mt-2">

                    {{-- <form action="{{ route('tracking.alat') }}" method="GET"> --}}
                    <div class="row align-items-end">




                        <div class="col-md-7">
                            <label class="form-label label">Kode alat</label>

                            <div class="input-wrapper">
                                <button class="filter-btn" id="filterBtn" data-toggle="modal" data-target="#filterModal">
                                    <i class="fa fa-sliders"></i>
                                    <span class="filter-badge" id="filterBadge">0</span>
                                </button>

                                <input type="text" name="kode_alat" class="form-control input-with-icon" id="kode-alat"
                                    placeholder="Masukkan kode alat...">
                            </div>
                        </div>
                        <div class="col-md-3">

                            <button id="btn-tracking-search" class="btn btn-universal w-100 p-1" type="button">
                                <i class="fa fa-search"></i>Search
                            </button>
                        </div>
                    </div>
                    {{-- </form> --}}
                </div>
                <div class="lacak-content" id="lacak-content">

                    <!-- SUMMARY (hidden awal) -->
                    <div class="mini-track-grid mb-3 d-none" id="track-summary"></div>

                    <!-- TABLE (hidden awal) -->
                    <div class="table-wrapper d-none" id="track-table-wrapper">

                        <table class="data-table table hover multiple-select-row py-0 px-2 border-0"
                            style="background: #e9edf9b1 !important; border-radius: 22px;">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>ID Peminjaman</th>
                                    <th>Nama</th>
                                    <th>Kelas</th>
                                    <th>Tanggal Pinjam</th>
                                    <th>Tanggal Kembali</th>
                                    <th>Keterlambatan</th>
                                    <th>Kondisi Kembali</th>
                                    <th>Catatan</th>
                                </tr>
                            </thead>

                            <tbody id="track-table"></tbody>
                        </table>

                    </div>

                    <div class="text-center py-5 empty-state" id="track-empty">

                        <div style="font-size: 55px;">🔎</div>

                        <h5 class="mt-3" style="color: #296087;">
                            Lacak Alat
                        </h5>

                        <p class="text-muted mb-0" style="font-size: 13px; font-weight: 500;">
                            Masukkan kode alat untuk mulai pencarian
                        </p>
                    </div>
                    <!-- LOADING SPINNER -->
                    <div class="text-center py-5 d-none" id="track-loading">
                        <div class="spinner-border text-primary" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                        <p class="mt-2" style="font-size: 13px;">
                            Mencari data...
                        </p>
                    </div>
                </div>

            </div>
            {{-- <div class="pd-20 card-box box-peminjaman">
                <h4 class="h4 text-dark">
                    Peminjaman Tiap Bulan
                </h4>

                <hr class="my-1">

                <div id="chart-peminjaman-bulan"></div>
            </div> --}}
        </div>
    </div>
@endsection
@section('modal')
    <div class="modal fade" id="filterModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-white">
                        <i class="fa fa-filter mr-2"></i> Filter Data
                    </h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="filter-card mb-3">
                        <div class="filter-label-wrapper mb-2">
                            <i class="bi bi-calendar-check filter-icon"></i>
                            <div class="filter-label">Range Tanggal</div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div style="font-size:11px;color:#6b7280;margin-bottom:4px;">Start</div>
                                <input type="text" id="startDate" class="form-control search-box filter-input"
                                    placeholder="📅 Pilih tanggal">
                            </div>

                            <div class="col-6">
                                <div style="font-size:11px;color:#6b7280;margin-bottom:4px;">End</div>
                                <input type="text" id="endDate" class="form-control search-box filter-input"
                                    placeholder="📅 Pilih tanggal">
                            </div>
                        </div>
                    </div>
                    <div class="filter-card">
                        <div class="filter-label-wrapper">
                            <i class="bi bi-exclamation-triangle filter-icon"></i>
                            <div class="filter-label">Kondisi Kembali</div>
                        </div>
                        <select id="filterKondisi" class="form-control filterKondisi filter-input">
                            <option value="">All Kondisi</option>
                            <option value="baik">Baik</option>
                            <option value="perlu perbaikan">Perlu Perbaikan</option>
                            <option value="rusak">Rusak</option>
                            <option value="hilang">Hilang</option>
                        </select>
                    </div>
                </div>
                <div class=" footer modal-footer justify-content-between">
                    <button class="btn btn-light btn-back"><i class="bi bi-arrow-counterclockwise"></i>Reset</button>
                    <button class="btn btn-primary btn-universal" id="apply-filter"><i
                            class="bi bi-check2-circle"></i>Terapkan</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('deskap/src/plugins/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('deskap/vendors/scripts/apexcharts-setting.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>
    {{-- <script>
        window.summary = @json($summary);
        window.detail = @json($detail);
    </script> --}}
    <script src="{{ asset('js/dashboard.js') }}"></script>
    <script>
        function ucwords(str) {
            return str.replace(/\b\w/g, char => char.toUpperCase());
        }
        var optionsBulanan = {

            series: [{
                name: 'Peminjaman',
                data: @json($pinjamBulanan)
            }],

            chart: {
                type: 'area',
                height: 380,

                toolbar: {
                    show: false
                },

                zoom: {
                    enabled: false
                }
            },

            colors: ['#2563EB'],

            fill: {
                type: 'gradient',

                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.45,
                    opacityTo: 0.05,
                    stops: [0, 100]
                }
            },

            stroke: {
                curve: 'smooth',
                width: 4
            },

            markers: {
                size: 6,
                strokeWidth: 3,
                hover: {
                    size: 9
                }
            },

            dataLabels: {
                enabled: false
            },

            xaxis: {
                categories: [
                    'Jan', 'Feb', 'Mar', 'Apr',
                    'Mei', 'Jun', 'Jul', 'Agu',
                    'Sep', 'Okt', 'Nov', 'Des'
                ],

                labels: {
                    style: {
                        colors: '#6B7280',
                        fontSize: '12px',
                        fontWeight: 600
                    }
                },

                axisBorder: {
                    show: false
                },

                axisTicks: {
                    show: false
                }
            },

            yaxis: {

                title: {
                    text: 'Jumlah Peminjaman',

                    style: {
                        color: '#111827',
                        fontSize: '13px',
                        fontWeight: 700
                    }
                },

                labels: {
                    formatter: function(val) {
                        return parseInt(val);
                    },

                    style: {
                        colors: '#6B7280',
                        fontSize: '12px'
                    }
                }
            },

            grid: {
                borderColor: '#E5E7EB',
                strokeDashArray: 5,
                padding: {
                    left: 10,
                    right: 10
                }
            },

            tooltip: {
                theme: 'light',

                y: {
                    formatter: function(val) {
                        return val + " peminjaman";
                    }
                }
            },

            states: {
                hover: {
                    filter: {
                        type: 'darken',
                        value: 0.85
                    }
                }
            },

            legend: {
                show: false
            }
        };

        new ApexCharts(
            document.querySelector("#chart-peminjaman-bulan"),
            optionsBulanan
        ).render();

        let namaAlat = [];
        let jumlahDipinjam = [];

        @foreach ($topAlat as $alat)
            namaAlat.push("{{ ucwords($alat->nama_tipe) }}");
            jumlahDipinjam.push({{ $alat->total_dipinjam }});
        @endforeach

        var options = {
            series: [{
                name: 'Dipinjam',
                data: jumlahDipinjam
            }],

            chart: {
                type: 'bar',
                height: 450,

                toolbar: {
                    show: false // hilangkan menu hamburger
                }
            },
            // legend: {
            //     show: false
            // },

            colors: ["#4E6FAE", "#6B8FD6", "#7FA8F8", "#9DC2FF", "#C9DCFF"],

            plotOptions: {
                bar: {
                    borderRadius: 6,
                    columnWidth: '45%',
                    distributed: true
                }
            },

            dataLabels: {
                enabled: true,
                style: {
                    colors: ['#ffffff'],
                    fontSize: '12px',
                    fontWeight: 600
                }
            },

            xaxis: {
                categories: namaAlat,

                labels: {
                    style: {
                        colors: '#6B7280',
                        fontSize: '12px',
                        fontWeight: 500
                    }
                }
            },

            yaxis: {
                min: 0,

                tickAmount: 5,

                title: {
                    text: 'Dipinjam',
                    offsetX: -6,
                    style: {
                        color: '#000000',
                        fontSize: '13px',
                        fontWeight: 700

                    }
                },

                labels: {
                    formatter: function(val) {
                        return parseInt(val); // tanpa desimal
                    },

                    style: {
                        colors: '#6B7280',
                        fontSize: '12px'
                    }
                }
            },

            grid: {
                borderColor: '#E5E7EB',
                strokeDashArray: 4
            },

            tooltip: {
                y: {
                    formatter: function(val) {
                        return val + " kali";
                    }
                }
            }
        };

        var chart = new ApexCharts(
            document.querySelector("#chart-top-alat"),
            options
        );

        chart.render();

        let summary = @json($summaryJenis);
        let detail = @json($detailJenis);
        var options = {
            chart: {
                type: 'donut',
                height: 320,
                toolbar: {
                    show: false
                },

                events: {
                    dataPointSelection: function(event, chartContext, config) {

                        let jenis = summary[config.dataPointIndex].nama_jenis;

                        let hasil = detail.filter(item =>
                            item.nama_jenis.toLowerCase().trim() === jenis.toLowerCase().trim()
                        );

                        let html = '';

                        if (hasil.length === 0) {

                            html = `
                        <tr>
                            <td colspan="4" class="text-center text-muted">
                                Tidak ada data
                            </td>
                        </tr>
                    `;

                        } else {

                            $.each(hasil[0].tipe_alat, function(i, item) {

                                html += `
                            <tr>
                                <td>
                                    <div class="no-badge">
                                        ${i + 1}.
                                    </div>
                                </td>
  <td>
              
               ${jenis.replace(/\b\w/g, c => c.toUpperCase())}
             
            </td>
                                <td>
                                    ${item.nama_tipe
    ? item.nama_tipe.replace(/\b\w/g, c => c.toUpperCase())
    : '-'}
                                </td>

                              
                                <td>
                                    ${item.stok ?? 0}
                                </td>
                            </tr>
                        `;
                            });

                        }

                        $('#list-alat').html(html);
                    }
                }
            },

            series: summary.map(item => item.tipe_alat_count),

            labels: summary.map(item => ucwords(item.nama_jenis)),

            colors: ["#3c6497", "#4f83c2", "#60a5fa", "#93c5fd", "#dbeafe",
                "#1d4ed8", "#2563eb", "#1e40af", "#0ea5e9", "#38bdf8",

                "#22c55e", "#16a34a", "#15803d", "#86efac", "#bbf7d0",
                "#84cc16", "#65a30d", "#4d7c0f",

                "#f59e0b", "#fbbf24", "#d97706", "#fcd34d", "#fde68a",

                "#ef4444", "#dc2626", "#b91c1c", "#fca5a5", "#fecaca",

                "#8b5cf6", "#7c3aed", "#6d28d9", "#c4b5fd", "#ddd6fe",

                "#06b6d4", "#0891b2", "#0e7490", "#67e8f9", "#a5f3fc",

                "#ec4899", "#db2777", "#be185d", "#f9a8d4", "#fbcfe8",

                "#334155", "#475569", "#64748b", "#94a3b8", "#cbd5e1"
            ],

            stroke: {
                width: 5,
                colors: ['#fff']
            },

            plotOptions: {
                pie: {
                    expandOnClick: true,

                    donut: {
                        size: '55%',

                        labels: {
                            show: true,

                            name: {
                                show: true,
                                fontSize: '16px',
                                fontWeight: 600
                            },

                            value: {
                                show: true,
                                fontSize: '22px',
                                fontWeight: 700
                            },

                            total: {
                                show: true,
                                label: 'Total Jenis',
                                fontSize: '15px',
                                fontWeight: 600,

                                formatter: function() {
                                    return summary.length;
                                }
                            }
                        }
                    }
                }
            },

            dataLabels: {
                enabled: true,
                style: {
                    fontSize: '13px',
                    fontWeight: 'bold'
                }
            },

            legend: {
                position: 'bottom',
                fontSize: '14px'
            },

            states: {
                hover: {
                    filter: {
                        type: 'lighten',
                        value: 0.08
                    }
                }
            }
        };

        var chart = new ApexCharts(
            document.querySelector("#chart8"),
            options
        );

        chart.render();





        $(document).ready(function() {




            // ===== COUNTER =====
            function animateCounter($counter) {
                const target = +$counter.data("target");
                const duration = 1200;
                const startTime = performance.now();

                function animate(time) {
                    const progress = Math.min((time - startTime) / duration, 1);
                    const ease = 1 - Math.pow(1 - progress, 3);

                    const value = Math.floor(ease * target);
                    $counter.text(value.toLocaleString("id-ID"));

                    if (progress < 1) {
                        requestAnimationFrame(animate);
                    } else {
                        $counter.text(target.toLocaleString("id-ID"));
                    }
                }

                requestAnimationFrame(animate);
            }

            // ===== INTERSECTION OBSERVER =====
            const observer = new IntersectionObserver(entries => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {

                        const $counter = $(entry.target).find(".counter");

                        if (!$(entry.target).hasClass("animated")) {
                            animateCounter($counter);
                            $(entry.target).addClass("animated");
                        }

                    }
                });
            }, {
                threshold: 0.6
            });

            $(".stat-card").each(function() {
                observer.observe(this);
            });

        });
    </script>
@endpush
