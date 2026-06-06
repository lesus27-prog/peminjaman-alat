let scanner;
let scanAktif = false;
let scanLock = false;
let dataScan = {};
let successSound = new Audio(successSoundPath);
successSound.load();

let kodeAlat = new URLSearchParams(window.location.search).get("kode");
if (kodeAlat) {
    setTimeout(() => {
        successSound.currentTime = 0;
        successSound.play().catch(() => {});

        setTimeout(() => {
            addAlat(kodeAlat);
        }, 10);
    }, 500);
}

$(document).ready(function () {
    updateProgress();

    scanner = new Html5Qrcode("reader");

    $("#emptyScanState").show();
    $("#reader").hide();
});

function onScanSuccess(decodedText) {
    if (scanLock) return;
    scanLock = true;

    let kodeAlat = decodedText.split("/").pop();

    successSound.currentTime = 0;
    successSound.play().catch(() => {});

    if (!daftarKodePeminjaman.includes(kodeAlat)) {
        Swal.fire({
            icon: "error",
            title: "Kode Tidak Valid",
            text: "Kode alat ini tidak ada di peminjaman",
        });

        setTimeout(function () {
            scanLock = false;
        }, 1200);

        return;
    }

    highlightKode(kodeAlat);

    let idTipe = null;

    $(".code").each(function () {
        if ($(this).text().trim() === kodeAlat) {
            idTipe = $(this).closest(".inventory-item").data("id-tipe");
        }
    });

    if (idTipe) {
        if (!dataScan[idTipe]) {
            dataScan[idTipe] = [];
        }

        if (!dataScan[idTipe].includes(kodeAlat)) {
            dataScan[idTipe].push(kodeAlat);
        }

        // renderChecklist(idTipe);
        updateProgress();
    }

    setTimeout(function () {
        scanLock = false;
    }, 1500);
}

function highlightKode(kode) {
    $(".code").each(function () {
        if ($(this).text().trim() === kode) {
            $(this).css({
                background: "#d1fae5",
                border: "1px solid #10b981",
                transition: "0.3s ease",
            });
        }
    });
}

function startScanner() {
    scanner
        .start(
            {
                facingMode: "environment",
            },
            {
                fps: 15,
                qrbox: function (w, h) {
                    let size = Math.min(w, h) * 0.9;
                    return {
                        width: size,
                        height: size,
                    };
                },
            },
            onScanSuccess,
        )
        .then(function () {
            scanAktif = true;

            $(".scanner-wrapper").addClass("scanner-active");

            $("#btnScan")
                .html('<i class="bi bi-camera-video-off-fill"></i> Stop Scan')
                .removeClass("btn-success")
                .addClass("btn-danger");
        });
}

function toggleScanner() {
    if (scanAktif) {
        scanner.stop().then(function () {
            scanAktif = false;

            $("#btnScan")
                .html('<i class="bi bi-camera-video-fill"></i> Mulai Scan')
                .removeClass("btn-danger")
                .addClass("btn-success");

            $("#emptyScanState").show();
            $("#reader").hide();
        });
    } else {
        $("#emptyScanState").hide();
        $("#reader").show();

        startScanner();
    }
}

function updateProgress() {
    let totalAlatDipinjam = 0;
    let totalAlatDiscan = 0;

    daftarPeminjaman.forEach(function (item) {
        totalAlatDipinjam += item.pivot.quantity;

        let idTipe = item.id_tipe;

        if (dataScan[idTipe]) {
            totalAlatDiscan += dataScan[idTipe].length;
        }
    });

    let progressBadge = $("#progressScan");

    progressBadge.css("fontWeight", "bold");

    if (totalAlatDiscan >= totalAlatDipinjam) {
        progressBadge
            .text(totalAlatDiscan + " / " + totalAlatDipinjam + " [Lengkap]")
            .removeClass("text-danger")
            .addClass("text-success");
    } else {
        progressBadge
            .text(
                totalAlatDiscan +
                    " / " +
                    totalAlatDipinjam +
                    " [Tidak Lengkap]",
            )
            .removeClass("text-success")
            .addClass("text-danger");
    }
}

function addAlat(kodeAlat) {
    if (!daftarKodePeminjaman.includes(kodeAlat)) {
        Swal.fire({
            icon: "error",
            title: "Kode Tidak Valid",
            text: "Kode alat ini tidak ada di peminjaman",
        });

        return;
    }

    highlightKode(kodeAlat);

    let idTipe = null;

    $(".code").each(function () {
        if ($(this).text().trim() === kodeAlat) {
            idTipe = $(this).closest(".inventory-item").data("id-tipe");

            return false;
        }
    });

    if (idTipe) {
        if (!dataScan[idTipe]) {
            dataScan[idTipe] = [];
        }

        if (!dataScan[idTipe].includes(kodeAlat)) {
            dataScan[idTipe].push(kodeAlat);
        }

        updateProgress();
    }
}

$("#add-manual").on("click", function () {
    let kodeAlat = $("#input-manual").val().trim();

    if (kodeAlat === "") {
        toastr.warning("Masukkan kode alat");
        return;
    }

    addAlat(kodeAlat);

    $("#input-manual").val("");
});

$("#input-manual").on("keypress", function (e) {
    if (e.key === "Enter") {
        e.preventDefault();

        $("#add-manual").click();
    }
});

function submitPinjam() {
    let total = 0;
    let sudah = 0;

    daftarPeminjaman.forEach((item) => {
        total += item.pivot.quantity;

        let idTipe = item.id_tipe;

        if (dataScan[idTipe]) {
            sudah += dataScan[idTipe].length;
        }
    });

    if (sudah < total) {
        Swal.fire({
            icon: "warning",
            title: "Belum Lengkap",
            html: `Kurang <b>${total - sudah}</b> alat belum discan.<br><br>
                   Apakah tetap ingin melanjutkan?`,
            showCancelButton: true,
            confirmButtonText: "Tetap Kirim",
            cancelButtonText: "Batal",
        }).then((result) => {
            if (result.isConfirmed) {
                kirimData();
            }
        });

        return;
    }

    // kalau sudah lengkap langsung submit
    kirimData();
}

function kirimData() {
    document.getElementById("alat").value = JSON.stringify(dataScan);
    document.getElementById("form-pinjam").submit();
}
