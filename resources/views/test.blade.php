<!DOCTYPE html>
<html>

<head>
    <title>FCM Test</title>
</head>

<body>

    <h2>TEST FCM NOTIF</h2>

    <form method="POST" action="/fcm-test/send">
        @csrf

        <input type="text" name="token" placeholder="Masukkan FCM Token" style="width:400px;" required>

        <br><br>

        <button type="submit" style="padding:10px 20px; background:green; color:white;">
            Kirim Notif
        </button>
    </form>

</body>

</html>
