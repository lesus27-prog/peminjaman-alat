<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Schedule::command('peminjaman:update-status')
    ->everyFiveMinutes();
// ->between('11:25', '15:00');
Schedule::command('peminjaman:reminder')
    ->everyFiveMinutes();

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
