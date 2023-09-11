<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('queue:supervisor', function () {

   $res = shell_exec('ps auxef --cols 300 | grep -i "artisan queue:supervisor" | grep -vi "grep"');

//    $res = shell_exec('ps auxef --cols 300');
    $rows = explode(PHP_EOL, $res);

    saveToLog($res);

    if(count($rows) >= 5) {
        saveToLog('EXISTS: ' . count($rows));
    } else {
        saveToLog('RUN QUEUE');
        Artisan::call('queue:work');
        saveToLog('RUNNING: ' . count($rows));
    }
});


function saveToLog($message)
{
//    $content = file_get_contents(base_path('_supervisor.txt'));
//    $content = $content . PHP_EOL . PHP_EOL . $message;
//    file_put_contents(base_path('_supervisor.txt'), $content);
}
