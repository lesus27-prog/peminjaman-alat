function ucwords(str) {
    return str.toLowerCase().replace(/\b\w/g, (char) => char.toUpperCase());
}

$(document).ready(function () {
    let summary = window.summary;
    let detail = window.detail;

    var options = {
        chart: {
            type: "donut",
            height: 320,
            toolbar: {
                show: false,
            },
            events: {
                dataPointSelection: function (event, chartContext, config) {
                    let kondisi = config.w.config.labels[config.dataPointIndex]
                        .toLowerCase()
                        .trim();

                    let hasil = $.grep(detail, function (item) {
                        return (
                            item.kondisi_alat.toLowerCase().trim() === kondisi
                        );
                    });

                    let html = "";

                    if (hasil.length === 0) {
                        html = `
                        <tr>
                            <td colspan="5" class="text-center text-muted">
                                Tidak ada data
                            </td>
                        </tr>
                    `;
                    } else {
                        $.each(hasil, function (i, item) {
                            let badgeClass = "";

                            if (item.kondisi_alat === "rusak") {
                                badgeClass = "badge-soft-danger";
                            } else if (
                                item.kondisi_alat === "perlu perbaikan"
                            ) {
                                badgeClass = "badge-soft-warning";
                            } else if (item.kondisi_alat === "hilang") {
                                badgeClass = "badge-soft-dark";
                            } else {
                                badgeClass = "badge-soft-success";
                            }

                            html += `
                            <tr>
                                <td>
                                    <div class="no-badge">
                                        ${i + 1}.
                                    </div>
                                </td>

                                <td>
                                    ${ucwords(item.tipe_alat?.nama_tipe ?? "-")}
                                </td>

                                <td>
                                    <span class="badge badge-soft-primary">
                                        ${ucwords(item.kode_alat)}
                                    </span>
                                </td>

                                <td>
                                    ${ucwords(item.tipe_alat?.lokasi_rak ?? "-")}
                                </td>

                                <td>
                                    <span class="badge ${badgeClass}">
                                        ${ucwords(item.kondisi_alat)}
                                    </span>
                                </td>
                            </tr>
                        `;
                        });
                    }

                    $("#list-alat").html(html);
                },
            },
        },

        series: summary.map((item) => item.total),

        labels: summary.map((item) => item.kondisi_alat),

        colors: ["#2163b5", "#5b97e1", "#b0c4f3", "#164278"],

        stroke: {
            width: 5,
            colors: ["#fff"],
        },

        plotOptions: {
            pie: {
                expandOnClick: true,

                donut: {
                    size: "55%",

                    labels: {
                        show: true,

                        name: {
                            show: true,
                            fontSize: "16px",
                            fontWeight: 600,
                        },

                        value: {
                            show: true,
                            fontSize: "22px",
                            fontWeight: 700,
                        },

                        total: {
                            show: true,
                            label: "Layak Pakai",
                            fontSize: "15px",
                            fontWeight: 600,

                            formatter: function () {
                                let baik = summary.find(
                                    (item) =>
                                        item.kondisi_alat
                                            .toLowerCase()
                                            .trim() === "baik",
                                );

                                return baik ? baik.total : 0;
                            },
                        },
                    },
                },
            },
        },

        dataLabels: {
            enabled: true,
            style: {
                fontSize: "13px",
                fontWeight: "bold",
            },
        },

        legend: {
            position: "bottom",
            fontSize: "14px",
        },

        states: {
            hover: {
                filter: {
                    type: "lighten",
                    value: 0.08,
                },
            },
        },
    };

    var chart = new ApexCharts(document.querySelector("#chart8"), options);

    chart.render();

    flatpickr("#bookingDate", {
        dateFormat: "Y-m-d",
        altInput: true,
        altFormat: "l, d F Y",
        altInputClass: "form-control bg-white",
        locale: "id",
        defaultDate: $("#bookingDate").val() || "today",
        // minDate: "today", // optional, hapus kalau mau pilih tanggal lama
        disable: [
            function (date) {
                return date.getDay() === 0 || date.getDay() === 6;
            },
        ],
    });

    const $badge = $("#tanggalBadge");
    const $inputTanggal = $("#bookingDate");

    function formatTanggal(date) {
        const d = new Date(date);

        return d.toLocaleDateString("id-ID", {
            weekday: "long",
            day: "2-digit",
            month: "long",
            year: "numeric",
        });
    }

    // 🔥 SET SAAT HALAMAN LOAD
    if ($inputTanggal.val()) {
        $badge.text(formatTanggal($inputTanggal.val()));
    }

    function permintaanPinjam(tanggal) {
        $.ajax({
            url: "/permintaan-peminjaman",
            type: "GET",
            data: {
                tanggal: tanggal,
            },

            success: function (res) {
                let html = "";

                if (res.data.length === 0) {
                    html = `
                <div class="text-center py-5 empty-state">
                    <div style="font-size: 50px;">🎉</div>
                    <h5 class="mt-3 text-success">Yeay!</h5>
                    <p class=" mb-0 text-muted" style="font-size: 13px; font-weight: 500; color: #555;">
                        Hari ini tidak ada permintaan peminjaman
                    </p>
                </div>`;
                } else {
                    res.data.forEach((item) => {
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

                        item.detail.forEach((d) => {
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
            },
        });
    }

    $(document).on("click", ".booking-main", function () {
        const $item = $(this).closest(".booking-item");
        $item.toggleClass("active");
        const $dot = $item.find(".toggle-dot");
        $dot.text($item.hasClass("active") ? "−" : "+");
    });

    let tanggal = $("#bookingDate").val();
    permintaanPinjam(tanggal);

    $("#btn-booking-search").on("click", function () {
        let tanggal = $("#bookingDate").val();

        if (!tanggal) {
             toastr.warning("Pilih tanggal terlebih dahulu");
            return;
        }
        const d = new Date(tanggal);

        $("#tanggalBadge").text(
            d.toLocaleDateString("id-ID", {
                weekday: "long",
                day: "2-digit",
                month: "long",
                year: "numeric",
            }),
        );

        $("#booking-content").html(`
            <div class="text-center py-5">
                <div class="spinner-border text-primary"></div>
                 <p class="mt-2" style="font-size: 13px;">Mencari data...</p>
            </div>
        `);

        permintaanPinjam(tanggal);
    });

    // ===== TYPE BADGE COUNT =====
    $(".booking-item").each(function () {
        const count = $(this).find(".detail-row").length;
        const $badge = $(this).find(".type-badge");

        $badge.text(count > 4 ? "4+ Tipe" : count + " Tipe");
    });

    let filterState = {
        start: null,
        end: null,
    };

    $("#apply-filter").on("click", function () {
        // update badge filter
        let count = 0;
        if (filterState.start || filterState.end) count++;
        $("#filterBadge")
            .text(count)
            .toggle(count > 0);

        $("#filterModal").modal("hide");
    });

    $(".btn-back").on("click", function () {
        // reset state filter
        filterState.start = null;
        filterState.end = null;

        // reset input UI
        $("#startDate").val("");
        $("#endDate").val("");

        // reset flatpickr
        startPicker.clear();
        endPicker.clear();

        // reset badge
        $("#filterBadge").text("0").hide();

        // tutup modal
        $("#filterModal").modal("hide");
    });

    let startPicker;
    let endPicker;

    startPicker = flatpickr("#startDate", {
        altInput: true,
        altFormat: "d M Y",
        dateFormat: "Y-m-d",
        maxDate: "today",
        disable: [(date) => date.getDay() === 0 || date.getDay() === 6],
        onChange: function (selectedDates) {
            filterState.start = selectedDates[0] || null;

            if (filterState.start) {
                endPicker.set("minDate", filterState.start);
            }
        },
    });

    endPicker = flatpickr("#endDate", {
        altInput: true,
        altFormat: "d M Y",
        dateFormat: "Y-m-d",
        maxDate: "today",
        disable: [(date) => date.getDay() === 0 || date.getDay() === 6],
        onChange: function (selectedDates) {
            filterState.end = selectedDates[0] || null;
        },
    });

    function cariAlat() {
        let kode = $("#kode-alat").val();

        if (kode.trim() === "") {
            toastr.warning("Masukkan kode alat!");
            return;
        }

        // show loading
        $("#track-loading").removeClass("d-none");
        $("#track-empty, #track-summary, #track-table-wrapper").addClass(
            "d-none",
        );
        $.ajax({
            url: "/tracking-alat",
            type: "GET",

            data: {
                kode_alat: kode,
                start_date: filterState.start
                    ? flatpickr.formatDate(filterState.start, "Y-m-d")
                    : null,
                end_date: filterState.end
                    ? flatpickr.formatDate(filterState.end, "Y-m-d")
                    : null,
            },

            success: function (res) {
                // reset semua tampilan dulu
                $("#track-loading").addClass("d-none");
                $("#track-empty").addClass("d-none");
                $("#track-summary").addClass("d-none");
                $("#track-table-wrapper").addClass("d-none");

                if (!res.status) {
                    $("#track-loading").addClass("d-none");
                    $("#track-summary").addClass("d-none");
                    $("#track-table-wrapper").addClass("d-none");

                    $("#track-empty").removeClass("d-none").html(`
            <div style="font-size: 55px;">⚠️</div>
            <h5 class="mt-3" style="color:#D21F3C">Alat Tidak Ditemukan</h5>
            <p class="text-muted" style="font-size: 13px; font-weight: 500;">
                ${res.message}
            </p>
        `);

                    return;
                }

                let data = res.data;

                // ===== SHOW SUMMARY =====
                $("#track-summary").removeClass("d-none").html(`
                    <div class="mini-track-card">
                        <div class="mini-track-left">
                            <i class="fa-solid fa-layer-group"></i>
                        </div>
                        <div class="mini-track-body">
                            <span>Tipe</span>
                            <h5>${data.tipe.replace(/\b\w/g, (c) => c.toUpperCase())}</h5>
                        </div>
                    </div>

                    <div class="mini-track-card">
                        <div class="mini-track-left">
                            <i class="fa-solid fa-layer-group"></i>
                        </div>
                        <div class="mini-track-body">
                            <span>Kondisi Alat</span>
                            <h5>${data.kondisi.replace(/\b\w/g, (c) => c.toUpperCase())}</h5>
                        </div>
                    </div>

                    <div class="mini-track-card">
                        <div class="mini-track-left">
                            <i class="fa-solid fa-circle-info"></i>
                        </div>
                        <div class="mini-track-body">
                            <span>Status</span>
                            <h5>${data.status.replace(/\b\w/g, (c) => c.toUpperCase())}</h5>
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
                        <td colspan="7" class="text-center text-muted">
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
                           <td>${item.nama ? item.nama.toLowerCase().replace(/\b\w/g, (c) => c.toUpperCase()) : "-"}</td>
                          <td>${item.kelas ? item.kelas.toUpperCase() : "-"}</td>
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
       <td>
    ${
        item.kondisi === "rusak"
            ? `<span class="badge badge-soft-danger rounded-pill">Rusak</span>`
            : item.kondisi === "perlu perbaikan"
              ? `<span class="badge badge-soft-warning rounded-pill">Perlu Perbaikan</span>`
              : item.kondisi === "hilang"
                ? `<span class="badge badge-soft-dark rounded-pill">Hilang</span>`
                : item.kondisi === "baik"
                  ? `<span class="badge badge-soft-success rounded-pill">Baik</span>`
                  : "-"
    }
</td>
<td>${item.catatan ? item.catatan : "-"}</td>
                        </tr>
                    `;
                    });
                }

                $("#track-table").html(rows);

                $("#track-table-wrapper").removeClass("d-none");
            },
            error: function () {
                $("#track-loading").addClass("d-none");
                $("#track-empty")
                    .removeClass("d-none")
                    .html("Terjadi kesalahan");
            },
        });
    }

    function resetTracking() {
        $("#track-summary").addClass("d-none").html("");
        $("#track-table-wrapper").addClass("d-none");
        $("#track-table").html("");

        $("#track-empty").removeClass("d-none").html(`
            <div style="font-size: 55px;">🔎</div>
            <h5 class="mt-3">Lacak Alatmu</h5>
            <p class="text-muted" style="font-size: 13px; font-weight: 500;">
                Masukkan kode alat untuk mulai pencarian
            </p>
        `);
    }

    $("#btn-tracking-search").on("click", function () {
        cariAlat();
    });

    $("#kode-alat").on("keypress", function (e) {
        if (e.key === "Enter") {
            e.preventDefault();
            cariAlat();
        }
    });

    $("#kode-alat").on("input", function () {
        let val = $(this).val();
        if (val.trim() === "") {
            resetTracking();
        }
    });
});
