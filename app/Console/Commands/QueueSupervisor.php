<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class QueueSupervisor extends Command
{
    protected $signature = 'queue:supervisor {processes_count} {--log}'; // php artisan queue:supervisor 5 --log
    protected $description = 'Queue Supervisor';

    public function handle()
    {
        $res = shell_exec('ps auxef --cols 300 | grep -i "artisan queue:supervisor" | grep -vi "grep"');

        // $res = shell_exec('ps auxef --cols 300');
        $rows = explode(PHP_EOL, $res);

        $this->saveToLog($res);

        if(count($rows) >= $this->argument('processes_count')) {
            $this->saveToLog('EXISTS: ' . count($rows));
        } else {
            $this->saveToLog('RUN QUEUE');
            Artisan::call('queue:work');
            $this->saveToLog('RUNNING: ' . count($rows));
        }
    }

    function saveToLog($message)
    {
        if($this->option('log')) {
            $logFilePath = storage_path('logs/queue_supervisor.log');

            if (file_exists($logFilePath)) {
                $content = file_get_contents($logFilePath);
            }
            $content = ($content ?? '') . PHP_EOL . PHP_EOL . $message;
            file_put_contents($logFilePath, $content);
        }
    }
}
