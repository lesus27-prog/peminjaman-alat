$(document).ready(function () {
    let timerTipe;
    let namaTipeValid = false;

    const $btnSubmit = $(".btn-universal[type='submit']");
    $btnSubmit.prop("disabled", true);

    function setError(msg) {
        $("#error-add-tipe").removeClass("d-none").text(msg);
    }

    function clearError() {
        $("#error-add-tipe").addClass("d-none").text("");
    }

    // ===================== VALIDASI UTAMA =====================
    function checkFormTipeValid() {
        let nama = $("#nama-tipe").val().trim();
        let jenis = $("#id-jenis").val();
        let stok = $("#stok").val().trim();
        let lokasi = $("#lokasi-rak").val().trim();

        let stokAngka = parseInt(stok);

        // reset warning stok
        $("#error-stok").addClass("d-none").text("");

        // ❌ stok = 0
        if (stok !== "" && stokAngka === 0) {
            $("#error-stok")
                .removeClass("d-none")
                .text("Stok minimal 1!");

            $btnSubmit.prop("disabled", true);
            return false;
        }

        // ❌ stok kosong
        if (stok === "") {
            $btnSubmit.prop("disabled", true);
            return false;
        }

        // ❌ validasi lain
        let lengkap =
            nama !== "" &&
            jenis !== "" &&
            lokasi !== "" &&
            namaTipeValid;

        $btnSubmit.prop("disabled", !lengkap);
        return lengkap;
    }

    // ===================== INPUT LISTENER =====================
    $("#nama-tipe, #stok, #lokasi-rak").on("input", function () {
        checkFormTipeValid();
    });

    $("#id-jenis").on("change", function () {
        checkFormTipeValid();
    });

    // ===================== LIVE CHECK NAMA =====================
    $("#nama-tipe").on("input", function () {
        clearTimeout(timerTipe);

        let nama = $(this).val().trim();

        namaTipeValid = false;
        clearError();
        $btnSubmit.prop("disabled", true);

        if (nama === "") {
            checkFormTipeValid();
            return;
        }

        timerTipe = setTimeout(function () {
            $.ajax({
                url: "/tipe/check-nama-tipe",
                method: "POST",
                data: {
                    nama_tipe: nama,
                    _token: $('meta[name="csrf-token"]').attr("content"),
                },
                success: function (res) {
                    if ($("#nama-tipe").val().trim() !== nama) return;

                    if (res.exist) {
                        namaTipeValid = false;
                        setError("Nama tipe sudah digunakan!");
                    } else {
                        namaTipeValid = true;
                        clearError();
                    }

                    checkFormTipeValid();
                },
            });
        }, 300);
    });

    // ===================== STOK LISTENER =====================
    $("#stok").on("input", function () {
        checkFormTipeValid();
    });
});