let scanner;
let scanAktif = false;
let scanLock = false;

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

function onScanSuccess(decodedText) {
    if (scanLock) return;

    scanLock = true;

    let kodeAlat = decodedText.split("/").pop();

    successSound.currentTime = 0;

    successSound.play().catch(() => {});

    addAlat(kodeAlat);

    setTimeout(function () {
        scanLock = false;
    }, 1500);
}

function startScanner() {
    scanner
        .start(
            { facingMode: "environment" },
            {
                fps: 15,
                qrbox: function (w, h) {
                    let size = Math.min(w, h) * 0.9;
                    return { width: size, height: size };
                },
            },
            onScanSuccess,
        )
        .then(function () {
            scanAktif = true;

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

$(document).ready(function () {
    updateProgress();

    scanner = new Html5Qrcode("reader");

    $("#emptyScanState").show();
    $("#reader").hide();
});

function renderKode(tipe, kodeAlat) {
    let container = $('.alat-checkpoint[data-tipe="' + tipe + '"]')
        .closest(".inventory-item")
        .find(".codes");

    container.append(`
        <span class="code">
            ${kodeAlat}
            <i class="bi bi-trash-fill code-trash"></i>
        </span>
    `);
}

let dataScan = {};
let batasTipe = {};

daftarPeminjaman.forEach(function (item) {
    let tipe = item.nama_tipe.toLowerCase().trim();

    batasTipe[tipe] = item.pivot.quantity;
});

function addAlat(kodeAlat) {
    let dataAlat = alatData[kodeAlat];

    if (!dataAlat) {
        Swal.fire({
            icon: "warning",
            title: "Peringatan",
            text: "Alat tidak ditemukan! Masukkan kode alat dengan benar",
        });

        return;
    }

    let tipeAlatScan = dataAlat.tipe_alat.nama_tipe.toLowerCase().trim();

    let tipeSesuai = false;

    daftarPeminjaman.forEach(function (item) {
        let tipePeminjaman = item.nama_tipe.toLowerCase().trim();

        if (tipePeminjaman === tipeAlatScan) {
            tipeSesuai = true;
        }
    });

    if (!tipeSesuai) {
        Swal.fire({
            icon: "warning",
            title: "Peringatan",
            text: "Tidak sesuai tipe yang dipinjam",
        });

        return;
    }

    if (dataAlat.kondisi_alat !== "baik") {
        Swal.fire({
            icon: "warning",
            title: "Peringatan",
            text: "Alat rusak / tidak dalam kondisi baik",
        });

        return;
    }

    if (dataAlat.status_alat === "tidak tersedia") {
        Swal.fire({
            icon: "warning",
            title: "Peringatan",
            text: "Alat sedang tidak tersedia",
        });

        return;
    }

    let jumlah = dataScan[tipeAlatScan] ? dataScan[tipeAlatScan].length : 0;

    let max = batasTipe[tipeAlatScan] || 0;

    if (jumlah >= max) {
        Swal.fire({
            icon: "warning",
            title: "Peringatan",
            text: "Jumlah alat untuk tipe ini sudah penuh",
        });

        return;
    }

    if (!dataScan[tipeAlatScan]) {
        dataScan[tipeAlatScan] = [];
    }

    if (dataScan[tipeAlatScan].includes(kodeAlat)) return;

    dataScan[tipeAlatScan].push(kodeAlat);

    renderKode(tipeAlatScan, kodeAlat);

    renderChecklist(tipeAlatScan);

    updateProgress();
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

$(document).on("click", ".code-trash", function () {
    let codeElement = $(this).closest(".code");

    let kodeAlat = codeElement.clone().children().remove().end().text().trim();

    let tipe = codeElement
        .closest(".inventory-item")
        .find(".alat-checkpoint")
        .data("tipe")
        .toLowerCase()
        .trim();

    codeElement.remove();

    if (dataScan[tipe]) {
        dataScan[tipe] = dataScan[tipe].filter(function (k) {
            return k !== kodeAlat;
        });
    }

    renderChecklist(tipe);

    updateProgress();
});

function renderChecklist(tipe) {
    let container = $('.alat-checkpoint[data-tipe="' + tipe + '"]');

    let dots = container.find(".scan-check");

    let count = (dataScan[tipe] || []).length;

    dots.removeClass("text-success").addClass("text-secondary");

    dots.each(function (index) {
        if (index < count) {
            $(this).removeClass("text-secondary").addClass("text-success");
        }
    });
}

function updateProgress() {
    let total = 0;

    let sudah = 0;

    daftarPeminjaman.forEach(function (item) {
        total += item.pivot.quantity;

        let tipe = item.nama_tipe.toLowerCase().trim();

        if (dataScan[tipe]) {
            sudah += dataScan[tipe].length;
        }
    });

    let el = $("#progressScan");

    el.css("fontWeight", "bold");

    if (sudah >= total) {
        el.text(sudah + " / " + total + " [Lengkap]")
            .removeClass("text-danger")
            .addClass("text-success");
    } else {
        el.text(sudah + " / " + total + " [Tidak lengkap]")
            .removeClass("text-success")
            .addClass("text-danger");
    }
}

function submitPinjam() {
    let semuaAlat = [];

    for (let tipe in dataScan) {
        semuaAlat = semuaAlat.concat(dataScan[tipe]);
    }

    semuaAlat = [...new Set(semuaAlat)];

    let totalPinjam = 0;

    daftarPeminjaman.forEach(function (item) {
        totalPinjam += item.pivot.quantity;
    });

    if (semuaAlat.length < totalPinjam) {
        Swal.fire({
            icon: "warning",
            title: "Belum lengkap",
            text: "Scan semua alat terlebih dahulu",
        });

        return;
    }

    $("#alat").val(semuaAlat.join(","));

    $("#form-pinjam").submit();
}

$("#btn-konfirmasi").on("click", function () {
    submitPinjam();
});
