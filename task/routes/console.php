<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Schedule::command('time-of-sub-task')->everyMinute();
Schedule::command('notify-admins-of-pass2-days')->daily();
Schedule::command('delete-finished-and2-days-pass-tasks')->daily();

