<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// // Penyiraman jam 06:07
// Schedule::command('app:auto-siram')
//     ->dailyAt('06:07');

// // Penyiraman jam 13:07
// Schedule::command('app:auto-siram')
//     ->dailyAt('13:07');

Schedule::command('app:capture-camera-image')
    ->everyOddHour()
    ->withoutOverlapping();
