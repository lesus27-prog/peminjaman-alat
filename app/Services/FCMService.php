<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Factory;

class FCMService
{
    public static function send($token, $title, $body, $link, $ttl)
    {
        try {
            // $factory = (new Factory)
            //     ->withServiceAccount(storage_path('app/firebase/firebase.json'));
            $factory = (new Factory)
                ->withServiceAccount(
                    json_decode(env('FIREBASE_CREDENTIALS_JSON'), true)
                );

            $messaging = $factory->createMessaging();

            // $message = [
            //     'token' => $token,
            //     'data' => [
            //         'title' => $title,
            //         'body' => $body,
            //         'ttl' => (string) $ttl,
            //         'link' => 'http://127.0.0.1:8000' . $link,
            //         'icon' => 'https://peminjaman-alat-tkj-smk7sby.up.railway.app/logo-smkn7-resmi.jpg',
            //     ],
            // ];

            $message = [
                'token' => $token,
                'data' => [
                    'title' => $title,
                    'body' => $body,
                    'ttl' => (string) $ttl,
                    'link' => 'https://sipinjam-alat-tkj.up.railway.app' . $link,
                    'icon' => 'https://sipinjam-alat-tkj.up.railway.app/logo-smkn7-resmi.jpg',
                ],
            ];

            Log::info('FCM PAYLOAD', $message);
            $result = $messaging->send($message);
            Log::info('FCM SUCCESS', ['result' => $result]);

            return true;
        } catch (\Throwable $e) {
            Log::error('FCM ERROR', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return false;
        }
    }
}
