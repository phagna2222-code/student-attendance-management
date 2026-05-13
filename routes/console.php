<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('analytics:rebuild --period=daily')
    ->dailyAt('00:30')
    ->withoutOverlapping();

Schedule::command('analytics:rebuild --period=monthly')
    ->monthlyOn(1, '01:00')
    ->withoutOverlapping();

Schedule::command('backup:run --type=database')
    ->dailyAt('03:00')
    ->withoutOverlapping();
