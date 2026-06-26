// function startScanner() {
//     scanner
//         .start(
//             { facingMode: "environment" },
//             {
//                 fps: 15,
//                 qrbox: function (w, h) {
//                     let size = Math.min(w, h) * 0.8;
//                     return { width: size, height: size };
//                 },
//             },
//             onScanSuccess,
//         )
//         .then(function () {
//             scanAktif = true;

//             $(".scanner-wrapper").addClass("scanner-active");

//             $("#btnScan")
//                 .html('<i class="bi bi-camera-video-off-fill"></i> Stop Scan')
//                 .removeClass("btn-success")
//                 .addClass("btn-danger");
//         });
// }

// function toggleScanner() {
//     if (scanAktif) {
//         scanner.stop().then(function () {
//             scanAktif = false;

//             $("#btnScan")
//                 .html('<i class="bi bi-camera-video-fill"></i> Mulai Scan')
//                 .removeClass("btn-danger")
//                 .addClass("btn-success");

//             $("#emptyScanState").show();
//             $("#reader").hide();
//         });
//     } else {
//         $("#emptyScanState").hide();
//         $("#reader").show();

//         startScanner();
//     }
// }

// $(document).ready(function () {
//     updateProgress();

//     scanner = new Html5Qrcode("reader");

//     $("#emptyScanState").show();
//     $("#reader").hide();

//     // startScanner();
// });