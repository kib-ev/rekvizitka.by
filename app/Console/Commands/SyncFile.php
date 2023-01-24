<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use function PHPUnit\Framework\isFalse;

class SyncFile extends Command
{
    protected $signature = 'sync:file {file_path} {start?}';

    protected $description = 'Sync file';

    public function handle()
    {
        $filePath = $this->argument('file_path');
        $startFrom = $this->argument('start');

        $content = str_replace(['[', ']'], '', file_get_contents(base_path($filePath)));
        $array = explode(',', $content);

        $doSync = !isset($startFrom);
        foreach ($array as $item) {
            $regCode = str_replace(['{"ngrn":', '}'], '', $item);
//            json_decode($item, 1)['ngrn'];

            if (isFalse($doSync) && $regCode == $startFrom) {
                $doSync = true;
            }

            if($doSync) {
//                $this->sync($regCode);
                $this->dispatchSync(regCode: $regCode);
            }
        }

        $this->info('end');
    }

    public function sync(mixed $regCode): void
    {
        $this->info("load $regCode" . " used memory " . memory_get_peak_usage ());

        $content = file_get_contents_ssl("https://egr.gov.by/egrmobile/api/search/checkStatusSubject?pan=$regCode");
        $data = json_decode($content, true);

        unset($content);

        if ($data['content'][0]['pan'] ?? false) {
            syncContractor($data);
        }
    }

    public function dispatchSync($regCode)
    {
        $this->info("dispatch $regCode");
        dispatch(new \App\Jobs\SyncContractor($regCode));
    }
}
