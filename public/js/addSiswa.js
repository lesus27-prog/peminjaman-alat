$(document).ready(function () {
    let timer;
    let nisValid = false;

    $("#btn-submit").prop("disabled", true);

    function checkFormValid() {
        let nama = $("#nama-siswa").val().trim();
        let nis = $("#nis").val().trim();
        let kelas = $("#kelas").val() || "";
        let jk = $("#jenis-kelamin").val() || "";
        let tahunMasuk = $("#tahun-masuk").val() || "";

        let lengkap =
            nama !== "" &&
            nis !== "" &&
            kelas !== "" &&
            jk !== "" &&
            tahunMasuk !== "" &&
            nisValid;

        $("#btn-submit").prop("disabled", !lengkap);
    }

    // function setInvalid(msg) {
    //     $("#error-nis")
    //         .removeClass("d-none")
    //         .text(msg);
    //     // $("#btn-submit").prop("disabled", true);
    // }

    // function setValid() {
    //     $("#error-nis")
    //         .addClass("d-none")
    //         .text("");
    //     checkFormValid();
    // }

    $("#nama-siswa").on("input", function () {
        checkFormValid();
    });

    $("#kelas, #jenis-kelamin, #tahun-masuk").on("change", function () {
        checkFormValid();
    });

    $("#nis").on("input", function () {
        clearTimeout(timer);

        let nis = $(this).val().trim();

        nisValid = false;

        checkFormValid();

        $("#error-nis").addClass("d-none").text("");

        if (nis === "") return;

        timer = setTimeout(function () {
            $.ajax({
                url: "/siswa/check-nis",
                method: "POST",
                data: {
                    nis: nis,
                    _token: $('meta[name="csrf-token"]').attr("content"),
                },

                success: function (res) {
                    if ($("#nis").val().trim() !== nis) return;

                    if (res.exist) {
                        nisValid = false;
                        $("#error-nis")
                            .removeClass("d-none")
                            .text("NIS sudah digunakan");
                    } else {
                        nisValid = true;

                        $("#error-nis").addClass("d-none").text("");
                        checkFormValid();
                    }
                },
                error: function () {
                    nisValid = false;

                    setInvalid("Gagal mengecek NIS");
                },
            });
        }, 300);
    });
});
