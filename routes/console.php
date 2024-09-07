<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::command('queue:work --stop-when-empty --tries=5 --timeout=0')->everyMinute()->withoutOverlapping()->after(function () {
    Log::info('queue:work command executed at ' . now());
});

Schedule::command('queue:restart')->everyFiveMinutes()->withoutOverlapping()->after(function () {
    Log::info('queue:restart at ' . now());
});
