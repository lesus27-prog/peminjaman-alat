<?php

namespace App\Services;

use Kreait\Firebase\Factory;

class FCMService
{
    public static function send($token, $title, $body)
    {
        // $factory = (new Factory)
        //     ->withServiceAccount(
        //         json_decode(env('FIREBASE_CREDENTIALS_JSON'), true)
        //     );
        $factory = (new Factory)
            ->withServiceAccount(storage_path('app/firebase/firebase.json'));

        $messaging = $factory->createMessaging();

        $message = [
            'token' => $token,
            'notification' => [
                'title' => $title,
                'body' => $body,
            ],
        ];

        return $messaging->send($message);
    }
}
