@extends('layouts.admin')
@section('link')
    {{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/content.css') }}">
    <link rel="stylesheet" href="{{ asset('css/universal.css') }}">
    <link rel="stylesheet" href="{{ asset('css/button.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/filter.css') }}">
    <link rel="stylesheet" href="{{ asset('css/table.css') }}">
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
                        <i class="fa-solid fa-hand-holding"></i>
                    </div>
                    <div class="stat-info">
                        <p>Alat Dipinjam</p>
                        <h3 class="counter" data-target={{ $alatDipinjam }}>{{ $alatDipinjam }}</h3>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon bg-indigo">
                        <i class="fa-solid fa-clock"></i>
                    </div>
                    <div class="stat-info">
                        <p>Terlambat</p>
                        <h3 class="counter" data-target={{ $terlambat }}>{{ $terlambat }}</h3>
                    </div>
                </div>

            </div>

            <div class="row g-3 m-0">
                <div class="col-md-7 mb-0 px-2 box-chart">
                    <div class="pd-20 card-kondisi card-box">
                        <h4 class="h4 text-dark d-flex align-items-center gap-2">
                            Distribusi Kondisi Alat

                        </h4>
                        <hr class="my-1">

                        <div id="chart8"></div>

                        <hr class="m-0">

                        <div class="table-responsive">
                            <table class="data-table table hover multiple-select-row py-0 px-2 border-0"
                                style="background: #e9edf9b1 !important; border-radius: 22px;">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Tipe Alat</th>
                                        <th>Kode Alat</th>
                                        <th>Lokasi Rak</th>
                                        <th>Kondisi Alat</th>
                                    </tr>
                                </thead>
                                <tbody id="list-alat">
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">
                                            Klik chart untuk melihat data
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
                <div class="col-md-5 mb-0 px-2 box-permintaan">
                    <div class="pd-20 card-box height-100-p booking-card">

                        <h4 class="h4 text-dark d-flex align-items-center gap-2">
                            Permintaan Peminjaman
                            <span id="tanggalBadge" class="chip chip-date ml-2"></span>
                        </h4>

                        <hr class="my-1">

                        <div class="booking-header p-2 mt-2">
                            <div class="row align-items-end">
                                <div class="col-md-8">
                                    <label class="form-label label">Tanggal</label>
                                    <input type="text" class="form-control" id="bookingDate">
                                </div>

                                <div class="col-md-4">

                                    <button type="button" id="btn-booking-search" class="btn btn-universal w-100 p-1">
                                        <i class="fa fa-search"></i> Search
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- 🔥 ISI DARI AJAX -->
                        <div class="booking-content" id="booking-content">
                            <div class="text-center py-5 empty-state">
                                {{-- <div style="font-size: 50px;">📅</div> --}}
                                {{-- <h5 class="mt-3 text-dark">Pilih tanggal</h5>
                                <p class="text-muted mb-0">
                                    lalu klik tombol search
                                </p> --}}
                            </div>
                        </div>

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

                        <table class="data-table table hover multiple-select-row py-0 px-2 border-0"     style="background: #e9edf9b1 !important; border-radius: 22px;">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama</th>
                                    <th>Kelas</th>
                                    <th>Tanggal Pinjam</th>
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
                    <div class="filter-card">
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
    {{-- <script src="{{ asset('deskap/src/plugins/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('deskap/vendors/scripts/apexcharts-setting.js') }}"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        window.summary = @json($summary);
        window.detail = @json($detail);
    </script>
    <script src="{{ asset('js/dashboard.js') }}"></script>
    <script src="{{ asset('js/dashboardAdmin.js') }}"></script>
    {{-- <script>
        let summary = @json($summary);
        let detail = @json($detail);

        var options = {
            chart: {
                type: 'donut',
                height: 320,
                toolbar: {
                    show: false
                },
                events: {
                    dataPointSelection: function(event, chartContext, config) {

                        let kondisi = config.w.config.labels[config.dataPointIndex]
                            .toLowerCase()
                            .trim();

                        let hasil = $.grep(detail, function(item) {
                            return item.kondisi_alat.toLowerCase().trim() === kondisi;
                        });

                        let html = '';

                        if (hasil.length === 0) {
                            html = `
                        <tr>
                            <td colspan="5" class="text-center text-muted">
                                Tidak ada data
                            </td>
                        </tr>
                    `;
                        } else {

                            $.each(hasil, function(i, item) {

                                let badgeClass = '';

                                if (item.kondisi_alat === 'rusak') {
                                    badgeClass = 'badge-danger';
                                } else if (item.kondisi_alat === 'perlu perbaikan') {
                                    badgeClass = 'badge-warning';
                                } else if (item.kondisi_alat === 'hilang') {
                                    badgeClass = 'badge-dark';
                                } else {
                                    badgeClass = 'badge-success';
                                }

                                html += `
                            <tr>
                                <td>
                                    <div class="no-badge">
                                        ${i + 1}.
                                    </div>
                                </td>

                                <td>
                                    ${item.tipe_alat?.nama_tipe ?? '-'}
                                </td>

                                <td>
                                    <span class="badge badge-primary">
                                        ${item.kode_alat}
                                    </span>
                                </td>

                                <td>
                                    ${item.tipe_alat?.lokasi_rak ?? '-'}
                                </td>

                                <td>
                                    <span class="badge ${badgeClass}">
                                        ${item.kondisi_alat}
                                    </span>
                                </td>
                            </tr>
                        `;
                            });
                        }

                        $('#list-alat').html(html);
                    }
                }
            },

            series: summary.map(item => item.total),

            labels: summary.map(item => item.kondisi_alat),

            colors: ["#2163b5", "#5b97e1", "#b0c4f3", "#164278" ],

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
                                label: 'Total Alat',
                                fontSize: '15px',
                                fontWeight: 600,

                                formatter: function() {

                                    let baik = summary.find(item =>
                                        item.kondisi_alat.toLowerCase().trim() === 'baik'
                                    );

                                    return baik ? baik.total : 0;
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

        let filterState = {
            start: null,
            end: null
        };

        let startPicker;
        let endPicker;

        function cariAlat() {
            let kode = $("#kode-alat").val();

            if (kode.trim() === "") {
                alert("Masukkan kode alat");
                return;
            }

            $.ajax({
                url: "{{ route('tracking.index') }}",
                type: "GET",

                data: {
                    kode_alat: kode,
                    start_date: filterState.start ?
                        flatpickr.formatDate(filterState.start, "Y-m-d") : null,
                    end_date: filterState.end ?
                        flatpickr.formatDate(filterState.end, "Y-m-d") : null
                },


                success: function(res) {

                    // reset semua tampilan dulu
                    $("#track-empty").addClass("d-none");
                    $("#track-summary").addClass("d-none");
                    $("#track-table-wrapper").addClass("d-none");

                    if (!res.status) {
                        $("#track-empty")
                            .removeClass("d-none")
                            .text(res.message);
                        return;
                    }

                    let data = res.data;

                    // ===== SHOW SUMMARY =====
                    $("#track-summary")
                        .removeClass("d-none")
                        .html(`
                    <div class="mini-track-card">
                        <div class="mini-track-left">
                            <i class="fa-solid fa-layer-group"></i>
                        </div>
                        <div class="mini-track-body">
                            <span>Tipe</span>
                            <h5>${data.tipe}</h5>
                        </div>
                    </div>

                    <div class="mini-track-card">
                        <div class="mini-track-left">
                            <i class="fa-solid fa-circle-info"></i>
                        </div>
                        <div class="mini-track-body">
                            <span>Status</span>
                            <h5>${data.status}</h5>
                        </div>
                    </div>

                    <div class="mini-track-card">
                        <div class="mini-track-left">
                            <i class="fa-solid fa-repeat"></i>
                        </div>
                        <div class="mini-track-body">
                            <span>Dipinjam</span>
                            <h5>${data.dipinjam}x</h5>
                        </div>
                    </div>
                `);

                    // ===== TABLE =====
                    let rows = "";

                    if (data.riwayat.length === 0) {
                        rows = `
                    <tr>
                        <td colspan="6" class="text-center text-muted">
                            Tidak ada riwayat
                        </td>
                    </tr>
                `;
                    } else {
                        data.riwayat.forEach((item, i) => {
                            rows += `
                        <tr>
                            <td>
                                <div class="no-badge">${i + 1}.</div></td>
                           <td>${item.nama ? item.nama.toLowerCase().replace(/\b\w/g, c => c.toUpperCase()) : '-'}</td>
                          <td>${item.kelas ? item.kelas.toUpperCase() : '-'}</td>
                            <td>${item.tanggal}</td>
                          
                            <td>
    ${
        item.terlambat === "Terlambat"
        ? `
                                                <span class="badge badge-soft-danger rounded-pill">
                                                   Terlambat
                                                </span>
                                              `
        : `
                                                <span class="badge badge-soft-success rounded-pill">
                                                  Tepat Waktu
                                                </span>
                                              `
    }
</td>
          <td>${item.kondisi ? item.kondisi.toLowerCase().replace(/\b\w/g, c => c.toUpperCase()) : '-'}</td>
                        </tr>
                    `;
                        });
                    }

                    $("#track-table")
                        .html(rows);

                    $("#track-table-wrapper")
                        .removeClass("d-none");
                }
            });
        }

        function resetTracking() {
            $("#track-summary").addClass("d-none").html("");
            $("#track-table-wrapper").addClass("d-none");
            $("#track-table").html("");

            $("#track-empty")
                .removeClass("d-none")
                .text("Masukkan kode alat");
        }

        $('#apply-filter').on('click', function() {

            // update badge filter
            let count = 0;
            if (filterState.start || filterState.end) count++;
            $('#filterBadge').text(count).toggle(count > 0);

            $('#filterModal').modal('hide');
        });

        $('.btn-back').on('click', function() {

            // reset state filter
            filterState.start = null;
            filterState.end = null;

            // reset input UI
            $('#startDate').val('');
            $('#endDate').val('');

            // reset flatpickr
            startPicker.clear();
            endPicker.clear();

            // reset badge
            $('#filterBadge').text('0').hide();

            // tutup modal
            $('#filterModal').modal('hide');
        });

        function permintaanPinjam(tanggal) {

            $.ajax({
                url: "{{ route('permintaanPinjam.index') }}",
                type: "GET",
                data: {
                    tanggal: tanggal
                },

                success: function(res) {

                    let html = "";

                    if (res.data.length === 0) {

                        html = `
                <div class="text-center py-5 empty-state">
                    <div style="font-size: 50px;">🎉</div>
                    <h5 class="mt-3 text-success">Yeay!</h5>
                    <p class="text-muted mb-0">
                        Hari ini tidak ada peminjaman
                    </p>
                </div>`;

                    } else {

                        res.data.forEach(item => {

                            html += `
                    <div class="booking-item mx-3 my-2">

                        <div class="booking-main">
                            <div class="left">
                                <div class="toggle-dot">+</div>
                                <div class="time">${item.jam}</div>
                            </div>

                            <div class="type-badge">
                                ${item.total_tipe} Tipe
                            </div>
                        </div>

                        <div class="booking-detail">`;

                            item.detail.forEach(d => {
                                html += `
                        <div class="detail-row">
                            <span>📦 ${d.nama}</span>
                            <span class="qty">x ${d.qty}</span>
                        </div>`;
                            });

                            html += `</div></div>`;
                        });
                    }

                    $("#booking-content").html(html);
                }
            });
        }

        $(document).on("click", ".booking-main", function() {

            const $item = $(this).closest(".booking-item");

            $item.toggleClass("active");

            const $dot = $item.find(".toggle-dot");
            $dot.text($item.hasClass("active") ? "−" : "+");
        });

        $(document).ready(function() {

            let tanggal = $('#bookingDate').val();
            permintaanPinjam(tanggal);

            $('#btn-booking-search').on('click', function() {

                let tanggal = $('#bookingDate').val();

                if (!tanggal) {
                    alert("Pilih tanggal dulu");
                    return;
                }
                const d = new Date(tanggal);

                $("#tanggalBadge").text(
                    d.toLocaleDateString("id-ID", {
                        weekday: "long",
                        day: "2-digit",
                        month: "long",
                        year: "numeric"
                    })
                );


                // loading
                $("#booking-content").html(`
                    <div class="text-center py-5">
                        <div class="spinner-border text-primary"></div>
                        <p class="mt-2">Loading...</p>
                    </div>
                `);

                permintaanPinjam(tanggal);
            });

            // ===== FLATPICKR =====
            flatpickr("#bookingDate", {
                dateFormat: "Y-m-d",
                altInput: true,
                altFormat: "l, d F Y",
                altInputClass: "form-control bg-white",
                locale: "id",
                defaultDate: $("#bookingDate").val() || "today",
                // minDate: "today", // optional, hapus kalau mau pilih tanggal lama
                disable: [
                    function(date) {
                        return (date.getDay() === 0 || date.getDay() === 6);
                    }
                ],

            });

            // ===== BADGE =====
            const $badge = $("#tanggalBadge");
            const $inputTanggal = $("#bookingDate");

            function formatTanggal(date) {
                const d = new Date(date);

                return d.toLocaleDateString("id-ID", {
                    weekday: "long",
                    day: "2-digit",
                    month: "long",
                    year: "numeric"
                });
            }

            // 🔥 SET SAAT HALAMAN LOAD
            if ($inputTanggal.val()) {
                $badge.text(formatTanggal($inputTanggal.val()));
            }

            // 🔥 UPDATE SAAT USER GANTI
            // $inputTanggal.on("change", function() {
            //     $badge.text(formatTanggal($(this).val()));
            // });

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

            // ===== CHART =====
            // var options8 = {
            //     series: window.chartSeries || [],
            //     chart: {
            //         type: "donut",
            //         height: 370,
            //     },
            //     labels: window.chartLabels || [],
            //     responsive: [{
            //         breakpoint: 480,
            //         options: {
            //             chart: {
            //                 width: 265,
            //             },
            //             legend: {
            //                 position: "bottom",
            //             },
            //         },
            //     }, ],
            //     legend: {
            //         position: "right",
            //     },
            //     dataLabels: {
            //         enabled: true,
            //     },
            // };
            // var chart = new ApexCharts(document.querySelector("#chart8"), options8);
            // chart.render();

            // ===== SELECT2 =====
            // $("#filter").select2({
            //     placeholder: "All Alat",
            //     allowClear: true,
            //     width: "100%"
            // });

            // ===== BOOKING TOGGLE =====
            $(".booking-main").on("click", function() {
                const $item = $(this).closest(".booking-item");

                $item.toggleClass("active");

                const $dot = $item.find(".toggle-dot");
                $dot.text($item.hasClass("active") ? "−" : "+");
            });

            // ===== TYPE BADGE COUNT =====
            $(".booking-item").each(function() {
                const count = $(this).find(".detail-row").length;
                const $badge = $(this).find(".type-badge");

                $badge.text(count > 4 ? "4+ Tipe" : count + " Tipe");
            });


            startPicker = flatpickr("#startDate", {
                altInput: true,
                altFormat: "d M Y",
                dateFormat: "Y-m-d",
                maxDate: "today",
                disable: [date => (date.getDay() === 0 || date.getDay() === 6)],
                onChange: function(selectedDates) {
                    filterState.start = selectedDates[0] || null;

                    if (filterState.start) {
                        endPicker.set('minDate', filterState.start);
                    }
                }
            });

            endPicker = flatpickr("#endDate", {
                altInput: true,
                altFormat: "d M Y",
                dateFormat: "Y-m-d",
                maxDate: "today",
                disable: [date => (date.getDay() === 0 || date.getDay() === 6)],
                onChange: function(selectedDates) {
                    filterState.end = selectedDates[0] || null;
                }
            });



            $("#kode-alat").on("input", function() {
                let val = $(this).val();

                if (val.trim() === "") {
                    resetTracking();
                }
            });
        });
    </script> --}}
@endpush
