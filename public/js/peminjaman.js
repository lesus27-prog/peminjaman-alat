function initDataTable(tableId, searchWrapperId, showEntriesId) {
    let table = $(tableId).DataTable({
        responsive: false,
        autoWidth: false,
        pageLength: 10,
        lengthChange: true,
        searching: true,
        dom: "lfrtip",
        ordering: false,
        language: {
            search: "",
            searchPlaceholder: "🔍 Search...",
            zeroRecords: "Data tidak ditemukan",
            info: "Showing _START_ to _END_ of _TOTAL_ entries",
            lengthMenu: "_MENU_",
            paginate: {
                next: ">>",
                previous: "<<",
            },
        },
    });

    $(searchWrapperId).html($(tableId + "_filter").detach());
    $(showEntriesId)
        .html($(tableId + "_length").detach())
        .prepend('<span class="mr-1">Show :</span>');

    return table;
}

// ===================== TAB INDICATOR =====================
function moveTab(el) {
    let $el = $(el);
    let $parent = $el.closest(".nav-tabs");

    $parent.css({
        "--x": $el.position().left + "px",
        "--w": $el.outerWidth() + "px",
    });
}

function toggleDetail(id) {
    let el = document.getElementById(id);
    let card = el.closest(".type-card");
    let icon = card.querySelector(".chevron");

    if (el.style.display === "block") {
        el.style.display = "none";
        icon.style.transform = "rotate(0deg)";
    } else {
        el.style.display = "block";
        icon.style.transform = "rotate(180deg)";
    }
}

// ===================== DOCUMENT READY =====================
$(document).ready(function () {
    // ===== INIT TABLE =====
    initDataTable(
        "#table-menunggu",
        "#search-wrapper-menunggu",
        "#show-entries-menunggu",
    );
    initDataTable(
        "#table-siap-diambil",
        "#search-wrapper-siap-diambil",
        "#show-entries-siap-diambil",
    );
    initDataTable(
        "#table-aktif",
        "#search-wrapper-aktif",
        "#show-entries-aktif",
    );
    initDataTable(
        "#table-proses-pengembalian",
        "#search-wrapper-proses-pengembalian",
        "#show-entries-proses-pengembalian",
    );
    initDataTable(
        "#table-batal",
        "#search-wrapper-batal",
        "#show-entries-batal",
    );

    // ===== TAB CLICK =====
    $(".nav-tabs .nav-link").on("click", function () {
        setTimeout(() => moveTab(this), 50);
    });

    // ===== INIT TAB POSITION =====
    moveTab($(".nav-tabs .nav-link.active"));

    // ===== HOVER EFFECT =====
    $(".nav-tabs .nav-link").on("mouseenter", function () {
        moveTab(this);
    });

    $(document).on("click", ".btn-detail", function () {
        let detail = $(this).siblings(".detail-alat");
        let icon = $(this).find("i");
        let isPlus = icon.hasClass("fa-plus");

        detail.stop(true, true).slideToggle(220);

        $(this).toggleClass("active");
        if (isPlus) {
            icon.removeClass("fa-plus").addClass("fa-minus");
        } else {
            icon.removeClass("fa-minus").addClass("fa-plus");
        }
    });

    $("#modal-validasi").on("shown.bs.modal", function (event) {
        let button = $(event.relatedTarget);
        let alatList = button.data("alat");

        let idPinjam = button.data("id-pinjam");

        let kode = "PJM-0" + idPinjam;
        let nama = button.data("nama-siswa");
        let kelas = button.data("kelas");
        let tglMulai = button.data("tanggal-mulai");
        let batas = button.data("batas-kembali");
        let terlambat = button.data("terlambat");

        /* ========= SET DATA HEADER ========= */
        $("#v-id-pinjam").text(kode);
        $("#v-nama-siswa").text(nama);
        $("#v-kelas").text(kelas);
        $("#v-tanggal-mulai").text(tglMulai);
        $("#v-batas-kembali").text(batas);

        $("#form-validasi").attr("action", "/validasi/" + idPinjam);

        /* ========= HITUNG KELENGKAPAN ========= */
        let total = alatList.length;
        let kembali = 0;

        alatList.forEach(function (alat) {
            if (alat.pivot.is_scan_kembali == 1) {
                kembali++;
            }
        });

        /* ========= BADGE TERLAMBAT ========= */
        let badgeTerlambat = "";

        if (terlambat) {
            badgeTerlambat = `
                    <span class="badge rounded-pill px-2 py-2 mr-1"
                        style="font-size:11px;width:auto;color:#ef4444;background-color:rgba(239, 68, 68, 0.12);">
                        Terlambat
                    </span>
                `;
        } else {
            badgeTerlambat = `
                    <span class="badge rounded-pill px-2 py-2 mr-1"
                        style="font-size:11px;width:auto;color:#16a34a;background-color:rgba(34, 197, 94, 0.12);">
                        Tepat Waktu
                    </span>
                `;
        }

        /* ========= BADGE KELENGKAPAN ========= */
        let badgeKelengkapan = "";

        if (kembali == total) {
            badgeKelengkapan = `
            <span class="badge badge-soft-success rounded-pill px-2 py-2"
                style="font-size:11px;width:auto;color:#16a34a;background-color:rgba(34, 197, 94, 0.12);">
                ${kembali}/${total} Lengkap
            </span>
        `;
        } else {
            badgeKelengkapan = `
            <span class="badge badge-soft-danger rounded-pill px-2 py-2"
                style="font-size:11px;width:auto;color:#ef4444;background-color:rgba(239, 68, 68, 0.12);">
                ${kembali}/${total} Tidak Lengkap
            </span>
        `;
        }

        /* ========= TAMPILKAN BADGE ========= */
        $("#v-terlambat").html(`
        <div class="d-flex align-items-center  mt-1">
            ${badgeTerlambat}
            ${badgeKelengkapan}
        </div>
    `);

        /* =====================================
               GROUP TIPE ALAT
            ===================================== */
        let container = $("#v-alat");
        container.html("");

        let grouped = [];

        alatList.forEach((alat) => {
            let tipeId = alat.tipe_alat.id_tipe;

            let index = grouped.findIndex((item) => item.id_tipe === tipeId);

            if (index === -1) {
                grouped.push({
                    id_tipe: tipeId,
                    nama_tipe: alat.tipe_alat.nama_tipe,
                    items: [alat],
                });
            } else {
                grouped[index].items.push(alat);
            }
        });

        /* =====================================
               RENDER ALAT
            ===================================== */
        grouped.forEach((tipe) => {
            let id = "tipe_" + tipe.id_tipe;

            let html = `
        <div class="type-card">

            <div class="type-header"
                 onclick="toggleDetail('${id}')">

                <div class="type-title">
                    <h6>
                    ${tipe.nama_tipe.replace(/\b\w/g, (huruf) =>
                        huruf.toUpperCase(),
                    )}
                    </h6>
                </div>

                <div class="type-action">
                    <span class="qty-pill">
                        ${tipe.items.length}
                    </span>
                </div>

            </div>

            <div class="type-body collapse-detail"
                 id="${id}">

                <div class="alat-table">

                    <div class="alat-row head">
                        <span>Kode</span>
                        <span>Status</span>
                        <span>Catatan</span>
                    </div>
        `;

            tipe.items.forEach((alat) => {
                let badgeClass =
                    alat.pivot.is_scan_kembali == 0
                        ? "kode-badge-tidak-lengkap"
                        : "kode-badge-lengkap";

                html += `
    <div class="alat-row">

        <span class="${badgeClass}">
            ${alat.kode_alat}
        </span>

                <select
                  name="kondisi_kembali[${alat.id_detail_alat}]">

                    <option value="baik" selected>
                        Baik
                    </option>

                    <option value="rusak">
                        Rusak
                    </option>

                    <option value="perlu perbaikan">
                        Perlu Perbaikan
                    </option>

                    <option value="hilang">
                        Hilang
                    </option>

                </select>

                <input type="text"
                    name="catatan[${alat.id_detail_alat}]"
                    placeholder="Catatan...">

            </div>
            `;
            });

            html += `
                </div>
            </div>
        </div>
        `;

            container.append(html);
        });
    });

    $(function () {
        $("[title]").tooltip({
            placement: "top",
            offset: "0,3",
        });
    });

    $('a[data-toggle="tab"]').on("shown.bs.tab", function (e) {
        const tab = $(e.target).attr("href").replace("#", "");

        // ubah URL tanpa reload
        const url = new URL(window.location);
        url.searchParams.set("tab", tab);
        window.history.pushState({}, "", url);
    });
});
