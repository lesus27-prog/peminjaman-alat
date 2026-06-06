$(document).ready(function () {
    // ===================== ADD =====================
    $(document).on("click", ".btn-add", function (e) {
        e.preventDefault();
        $("#modal-add-data-jenis").modal("show");
    });

    // reset form saat modal close
    $("#modal-add-data-jenis").on("hidden.bs.modal", function () {
        $(this).find("form")[0].reset();
    });

    // ===================== EDIT =====================
    $(document).on("click", ".btn-edit", function (e) {
        e.preventDefault();

        let idJenis = $(this).data("id-jenis");
        let namaJenis = $(this).data("nama-jenis");

        $("#id-jenis").val(idJenis);
        $("#nama-jenis").val(namaJenis);
        $("#modal-edit-data-jenis").modal("show");

        $("#edit-jenis-form").attr("action", "/update-jenis/" + idJenis);
    });

    // ===================== DELETE =====================
    let timerAdd;
    let timerEdit;

    let namaAddValid = false;
    let originalNamaEdit = "";

    function setAddError(msg) {
        $("#error-jenis").removeClass("d-none").text(msg);
    }

    function clearAddError() {
        $("#error-jenis").addClass("d-none").text("");
    }

    function checkAddForm() {
        let nama = $("#nama").val().trim();
        $("#btn-submit").prop("disabled", !(nama !== "" && namaAddValid));
    }

    // ================= ADD VALIDATION =================
    $(document).on("input", "#nama", function () {
        clearTimeout(timerAdd);

        let nama = $(this).val().trim();
        namaAddValid = false;

        clearAddError();
        checkAddForm();

        if (nama === "") return;

        timerAdd = setTimeout(function () {
            $.ajax({
                url: "/jenis/check-nama-jenis",
                method: "POST",
                data: {
                    nama_jenis: nama,
                    _token: $('meta[name="csrf-token"]').attr("content"),
                },
                success: function (res) {
                    if ($("#nama").val().trim() !== nama) return;

                    if (res.exist) {
                        namaAddValid = false;
                        setAddError("Nama jenis sudah digunakan");
                    } else {
                        namaAddValid = true;
                        clearAddError();
                    }

                    checkAddForm();
                },
            });
        }, 300);
    });

    // ================= EDIT OPEN =================
    $(document).on("click", ".btn-edit", function () {
        let id = $(this).data("id-jenis");
        let nama = $(this).data("nama-jenis");

        $("#id-jenis").val(id);
        $("#nama-jenis").val(nama);

        originalNamaEdit = nama;

        $("#error-edit-jenis").addClass("d-none").text("");
        $("#btn-edit-submit").prop("disabled", false);

        $("#edit-jenis-form").attr("action", "/update-jenis/" + id);
        $("#modal-edit-data-jenis").modal("show");
    });

    // ================= EDIT VALIDATION =================
    $(document).on("input", "#nama-jenis", function () {
        clearTimeout(timerEdit);

        let nama = $(this).val().trim();
        let id = $("#id-jenis").val();

        $("#error-edit-jenis").addClass("d-none").text("");

        // kosong
        if (nama === "") {
            $("#btn-edit-submit").prop("disabled", true);
            return;
        }

        // balik ke original → AMAN
        if (
            nama.trim().toLowerCase() === originalNamaEdit.trim().toLowerCase()
        ) {
            $("#error-edit-jenis").addClass("d-none").text("");
            $("#btn-edit-submit").prop("disabled", false);
            return;
        }

        $("#btn-edit-submit").prop("disabled", true);

        timerEdit = setTimeout(function () {
            $.ajax({
                url: "/jenis/check-nama-jenis",
                method: "POST",
                data: {
                    nama_jenis: nama,
                    id_jenis: id,
                    _token: $('meta[name="csrf-token"]').attr("content"),
                },
                success: function (res) {
                    if ($("#nama-jenis").val().trim() !== nama) return;

                    if (res.exist) {
                        $("#error-edit-jenis")
                            .removeClass("d-none")
                            .text("Nama jenis sudah digunakan");

                        $("#btn-edit-submit").prop("disabled", true);
                    } else {
                        $("#error-edit-jenis").addClass("d-none").text("");
                        $("#btn-edit-submit").prop("disabled", false);
                    }
                },
            });
        }, 300);
    });

    // ================= RESET MODAL EDIT =================
    $("#modal-edit-data-jenis").on("hidden.bs.modal", function () {
        $("#nama-jenis").val("");
        $("#error-edit-jenis").addClass("d-none").text("");

        originalNamaEdit = "";
        clearTimeout(timerEdit);

        $("#btn-edit-submit").prop("disabled", true);
    });

    // ================= RESET ADD MODAL =================
    $("#modal-add-data-jenis").on("hidden.bs.modal", function () {
        $("#nama").val("");
        clearAddError();

        namaAddValid = false;
        clearTimeout(timerAdd);
        $("#btn-submit").prop("disabled", true);
    });

});
