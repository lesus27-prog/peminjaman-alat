$(document).ready(function () {
    // ========================= FILTER =========================
    let filterState = {
        kelas: "",
    };

    function countActiveFilters() {
        let count = 0;

        if (filterState.kelas) count++;
        return count;
    }

    $(".btn-universal").on("click", function () {
        table
            .column(3)
            .search(
                filterState.kelas ? "^" + filterState.kelas + "$" : "",
                true,
                false,
            )
            .draw();

        let total = countActiveFilters();

        $("#filterBadge")
            .text(total)
            .toggle(total > 0);

        $("#filterModal").modal("hide");
    });

    $(".btn-back").on("click", function () {
        filterState = {
            kelas: "",
        };

        $("select.filter-input").prop("selectedIndex", 0);
        table.search("").columns().search("").draw();

        $("#filterBadge").hide().text("0");
    });

    $("#filterKelas").on("change", function () {
        filterState.kelas = $(this).val();
    });

    // ========================= EXPORT =========================
    window.exportPdf = function () {
        let url = "/export-siswa";

        if (filterState.kelas) {
            url += "?kelas=" + encodeURIComponent(filterState.kelas);
        }

        window.open(url, "_blank");
    };

    window.exportPdf = function () {
        let url = "/export-laporan-siswa";

        if (filterState.kelas) {
            url += "?kelas=" + encodeURIComponent(filterState.kelas);
        }

        window.open(url, "_blank");
    };

    // ========================= EDIT =========================
    let nisAwal = "";
    $(document).on("click", ".btn-edit", function (e) {
        e.preventDefault();

        let idSiswa = $(this).data("id-siswa");
        let namaSiswa = $(this).data("nama-siswa");
        let nis = $(this).data("nis");
        let kelas = $(this).data("kelas");
        let jenis = $(this).data("jenis-kelamin");
        let tahunMasuk = $(this).data("tahun-masuk");
        nisAwal = nis;

        $("#id-siswa").val(idSiswa);
        $("#nama-siswa").val(namaSiswa);
        $("#nis").val(nis);
        $("#kelas").val(kelas);
        $("#jenis-kelamin").val(jenis);
        $("#tahun-masuk").val(tahunMasuk);

        $("#edit-data-siswa").attr("action", "/update-siswa/" + idSiswa);

        $("#modal-edit-data-siswa").modal("show");
    });

    $("#modal-edit-data-siswa").on("hidden.bs.modal", function () {
        $("#error-nis").addClass("d-none").text("");
        $("#btn-edit").prop("disabled", false);
    });

    // ========================= CHECK NIS EDIT =========================
    let timer;

    $("#nis").on("input", function () {
        clearTimeout(timer);

        let nis = $(this).val().trim();
        let id = $("#id-siswa").val();

        $("#error-nis").addClass("d-none").text("");

        $("#btn-edit").prop("disabled", false);

        if (nis === "" || nis === nisAwal) return;

        timer = setTimeout(function () {
            $.ajax({
                url: "/siswa/check-nis",
                method: "POST",
                data: {
                    nis: nis,
                    id_siswa: id,
                    _token: $('meta[name="csrf-token"]').attr("content"),
                },
                success: function (res) {
                    if (res.exist) {
                        $("#error-nis")
                            .removeClass("d-none")
                            .text("NIS sudah digunakan");

                        $("#btn-edit").prop("disabled", true);
                    } else {
                        $("#error-nis").addClass("d-none").text("");
                        $("#btn-edit").prop("disabled", false);
                    }
                },
            });
        }, 300);
    });
});
