@extends('layouts.siswa')
@section('link')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/content.css') }}">
    <link rel="stylesheet" href="{{ asset('css/universal.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endsection
@section('content')
    <div class="pd-ltr-20 xs-pd-20-10">
        <div class="min-height-200px">
            <div class="dashboard-grid">
                <div class="stat-card">
                    <div class="stat-icon bg-purple">
                        <i class="fa-solid fa-hand-holding"></i>

                    </div>
                    <div class="stat-info">
                        <p>Alat Siap Diambil</p>
                        <h3 class="counter" data-target={{ $siapDiambil }}>{{ $siapDiambil }}</h3>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon bg-blue">
                        <i class="fa-solid fa-screwdriver-wrench"></i>
                    </div>
                    <div class="stat-info">
                        <p>Alat Dipinjam</p>
                        <h3 class="counter" data-target={{ $alatDipinjam }}>{{ $alatDipinjam }}</h3>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon bg-red">
                        <i class="fa-solid fa-hourglass-half"></i>
                    </div>
                    <div class="stat-info">
                        <p>Proses Pengembalian</p>
                        <h3 class="counter" data-target={{ $prosesPengembalian }}>{{ $prosesPengembalian }}</h3>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon bg-red">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                    </div>
                    <div class="stat-info">
                        <p>Terlambat</p>
                        <h3 class="counter" data-target={{ $terlambat }}>{{ $terlambat }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>
    {{-- <script>
        $(document).ready(function() {
            if ('serviceWorker' in navigator) {

                navigator.serviceWorker.register('/firebase-messaging-sw.js')
                    .then(async (registration) => {

                        const permission = await Notification.requestPermission();

                        if (permission !== "granted") {
                            console.log("Permission ditolak");
                            return;
                        }

                        const token = await messaging.getToken({
                            vapidKey: 'BBmW3STkh775-ucf4qPMjejnfY53u0IT18CEXL0puloM3ACQ0zD4sYpvP_4V_klPPgIOSbwCusefroph47RXx-k',
                            serviceWorkerRegistration: registration
                        });

                        if (!token) {
                            console.log("Token kosong");
                            return;
                        }

                        console.log("FCM TOKEN:", token);

                        await fetch('/save-token', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document
                                    .querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content')
                            },
                            body: JSON.stringify({
                                token
                            })
                        });

                    })
                    .catch(console.error);
            }

            // if ('serviceWorker' in navigator) {
            //     navigator.serviceWorker.register('/firebase-messaging-sw.js')
            //         // navigator.serviceWorker.register('/firebase-messaging-sw.js')
            //         .then(async (registration) => {

            //             const permission = await Notification.requestPermission();
            //             if (permission !== "granted") {
            //                 console.log("Permission ditolak");
            //                 return;
            //             }

            //             const token = await messaging.getToken({
            //                 vapidKey: 'BBmW3STkh775-ucf4qPMjejnfY53u0IT18CEXL0puloM3ACQ0zD4sYpvP_4V_klPPgIOSbwCusefroph47RXx-k',
            //                 serviceWorkerRegistration: registration
            //             });

            //             if (!token) {
            //                 console.log("Token kosong");
            //                 return;
            //             }

            //             console.log("FCM TOKEN:", token);

            //             return fetch('/save-token', {
            //                 method: 'POST',
            //                 headers: {
            //                     'Content-Type': 'application/json',
            //                     'X-CSRF-TOKEN': document
            //                         .querySelector('meta[name="csrf-token"]')
            //                         .getAttribute('content')
            //                 },
            //                 body: JSON.stringify({
            //                     token
            //                 })
            //             });

            //         })
            //         .catch(console.error);
            // }
        });
    </script> --}}
    <script src="{{ asset('js/dashboard.js') }}"></script>
@endpush
