importScripts("https://www.gstatic.com/firebasejs/8.10.1/firebase-app.js");
importScripts(
    "https://www.gstatic.com/firebasejs/8.10.1/firebase-messaging.js",
);

firebase.initializeApp({
    apiKey: "AIzaSyDrfnmeCrRM4kSfKO6UYgd4rYs_AN3K4WU",
    authDomain: "peminjaman-8a8d0.firebaseapp.com",
    projectId: "peminjaman-8a8d0",
    messagingSenderId: "114150558143",
    appId: "1:114150558143:web:a709540146fe7a0247b90a",
});
const messaging = firebase.messaging();

// messaging.setBackgroundMessageHandler(function (payload) {
messaging.onBackgroundMessage(function (payload) {
    return self.registration.showNotification(payload.data.title, {
        body: payload.data.body,
        icon: payload.data.icon,
        data: {
            link: payload.data.link,
        },
    });
});

self.addEventListener("notificationclick", function (event) {
    event.notification.close();

    const url = event.notification.data.link;

    event.waitUntil(
        clients
            .openWindow(url)
            .then(function (client) {
                console.log("BERHASIL", client);
            })
            .catch(function (err) {
                console.error("GAGAL", err);
            }),
    );
});

// const messaging = firebase.messaging();

// messaging.onBackgroundMessage(function (payload) {
//     const title = payload.notification?.title;

//     const body = payload.notification?.body;

//     self.registration.showNotification(title, {
//         body: body
//     });
// });

// messaging.onBackgroundMessage(function (payload) {
//     console.log("BG MESSAGE", payload);

//     const title = payload.notification?.title || "Notifikasi";
//     const options = {
//         body: payload.notification?.body || "",
//     };

//     self.registration.showNotification(title, options);
// });

// messaging.setBackgroundMessageHandler(function (payload) {
//     const title = payload.notification?.title || "Notifikasi";
//     const options = {
//         body: payload.notification?.body || "",
//     };

//     return self.registration.showNotification(title, options);
// });
