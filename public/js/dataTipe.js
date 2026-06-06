let timerEditTipe;
let originalNamaTipe = "";
let filterState = {
    jenis: "",
    id_jenis: "",
};

function countActiveFilters() {
    let count = 0;
    if (filterState.jenis) count++;
    return count;
}

$(document).ready(function () {
    // ===================== FILTER APPLY =====================
    $(".btn-universal").on("click", function () {
        table
            .column(1)
            .search(filterState.jenis ? "JENIS_" + filterState.jenis : "")
            .draw();

        let total = countActiveFilters();

        $("#filterBadge")
            .text(total)
            .toggle(total > 0);

        $("#filterModal").modal("hide");
    });

    // ===================== RESET =====================
    $(".btn-back").on("click", function () {
        filterState = {
            jenis: "",
            id_jenis: "",
        };

        $("select.filter-input").prop("selectedIndex", 0);

        table.search("").columns().search("").draw();

        $("#filterBadge").hide().text("0");
    });

    // ===================== DROPDOWN FILTER =====================
    $("#filterJenis").on("change", function () {
        let selected = $(this).find(":selected");

        filterState.jenis = selected.val();
        filterState.id_jenis = selected.data("id");
    });

    // ===================== EDIT =====================
    $(document).on("click", ".btn-edit", function (e) {
        e.preventDefault();

        let idTipe = $(this).data("id-tipe");
        let idJenis = $(this).data("id-jenis");
        let namaTipe = $(this).data("nama-tipe");
        let gambar = $(this).data("gambar");
        let stok = $(this).data("stok");
        let lokasiRak = $(this).data("lokasi-rak");

        // set input
        $("#id-jenis").val(idJenis);
        $("#nama-tipe").val(namaTipe);
        $("#stok").val(stok);
        $("#lokasi-rak").val(lokasiRak);

        // preview gambar (aman)
        if (gambar) {
            $("#preview-gambar").attr("src", gambar).show();
        } else {
            $("#preview-gambar").attr("src", "").hide();
        }

        // set form action
        $("#edit-tipe-form").attr("action", "/update-tipe/" + idTipe);

        // show modal
        $("#modal-edit-data-tipe").modal("show");

        // ===================== TAMBAHAN (VALIDASI INIT) =====================
        $("#nama-tipe").val(namaTipe);

        originalNamaTipe = namaTipe; // 🔥 FIX UTAMA
        $("#error-edit-tipe").addClass("d-none").text("");
        setEditTipeDisabled(false);
    });

    window.exportPdf = function () {
        let idJenis = filterState.id_jenis;
        let url = "/export-laporan-alat";

        if (idJenis) {
            url += "?idJenis=" + encodeURIComponent(idJenis);
        }

        window.open(url, "_blank");
    };

    // =========================================================
    // ===================== VALIDASI NAMA TIPE EDIT ===========
    // =========================================================

    function setEditTipeDisabled(state) {
        $("#modal-edit-data-tipe button[type='submit']").prop(
            "disabled",
            state,
        );
    }

    $(document).on("input", "#nama-tipe", function () {
        clearTimeout(timerEditTipe);

        let nama = $(this).val().trim();
        let idTipe = $("#id-tipe").val();

        $("#error-edit-tipe").addClass("d-none").text("");

        if (nama === "") {
            setEditTipeDisabled(true);
            return;
        }

        if (
            nama.trim().toLowerCase() === originalNamaTipe.trim().toLowerCase()
        ) {
            $("#error-edit-tipe").addClass("d-none").text("");
            setEditTipeDisabled(false);
            return;
        }

        setEditTipeDisabled(true);

        timerEditTipe = setTimeout(function () {
            $.ajax({
                url: "/tipe/check-nama-tipe",
                method: "POST",
                data: {
                    nama_tipe: nama,
                    id_tipe: idTipe,
                    _token: $('meta[name="csrf-token"]').attr("content"),
                },
                success: function (res) {
                    if ($("#nama-tipe").val().trim() !== nama) return;

                    if (res.exist) {
                        $("#error-edit-tipe")
                            .removeClass("d-none")
                            .text("Nama tipe sudah digunakan");

                        setEditTipeDisabled(true);
                    } else {
                        $("#error-edit-tipe").addClass("d-none").text("");
                        setEditTipeDisabled(false);
                    }
                },
            });
        }, 300);
    });

    // ===================== RESET MODAL EDIT =====================
    $("#modal-edit-data-tipe").on("hidden.bs.modal", function () {
        $("#nama-tipe").val("");
        $("#error-edit-tipe").addClass("d-none").text("");

        originalNamaTipe = ""; // RESET WAJIB
        clearTimeout(timerEditTipe);

        setEditTipeDisabled(true);
    });
});
// let filterState = {
//     jenis: "",
//     id_jenis: "",
// };

// function countActiveFilters() {
//     let count = 0;

//     if (filterState.jenis) count++;
//     return count;
// }
// $(document).ready(function () {
//     // ===================== STATE =====================

//     // ===================== HELPER =====================

//     // ===================== FILTER APPLY =====================
//     $(".btn-universal").on("click", function () {
//         table
//             .column(1)
//             .search(filterState.jenis ? "JENIS_" + filterState.jenis : "")
//             .draw();

//         let total = countActiveFilters();
//         $("#filterBadge")
//             .text(total)
//             .toggle(total > 0);
//         $("#filterModal").modal("hide");
//     });

//     // ===================== RESET =====================
//     $(".btn-back").on("click", function () {
//         filterState = {
//             jenis: "",
//             id_jenis: "",
//         };

//         $("select.filter-input").prop("selectedIndex", 0);
//         table.search("").columns().search("").draw();
//         $("#filterBadge").hide().text("0");
//     });

//     // ===================== DROPDOWN FILTER =====================
//     $("#filterJenis").on("change", function () {
//         let selected = $(this).find(":selected");

//         filterState.jenis = selected.val();
//         filterState.id_jenis = selected.data("id");
//     });

//     // ===================== EDIT =====================
//     $(document).on("click", ".btn-edit", function (e) {
//         e.preventDefault();

//         let idTipe = $(this).data("id-tipe");
//         let idJenis = $(this).data("idJenis");
//         let namaTipe = $(this).data("nama-tipe");
//         let gambar = $(this).data("gambar");
//         let stok = $(this).data("stok");
//         let lokasiRak = $(this).data("lokasi-rak");

//         // set input
//         $("#id-jenis").val(idJenis);
//         $("#nama-tipe").val(namaTipe);
//         $("#preview-gambar").attr("src", gambar);
//         $("#stok").val(stok);
//         $("#lokasi-rak").val(lokasiRak);

//         // set form action
//         $("#edit-tipe-form").attr("action", "/update-tipe/" + idTipe);

//         // show modal
//         $("#modal-edit-data-tipe").modal("show");
//     });

//     // ===================== DELETE =====================

//     // ========================= EXPORT =========================
//     window.exportPdf = function () {
//         let idJenis = filterState.id_jenis;
//         let url = "/export-tipe";

//         if (idJenis && idJenis !== "") {
//             url += "?idJenis=" + encodeURIComponent(idJenis);
//         }

//         window.open(url, "_blank");
//     };
// });
