<?php

namespace App\Jobs;

use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SyncContractor implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected int $regCode;

    public function __construct($regCode)
    {
        $this->regCode = $regCode;
    }

    public function handle(): int
    {
        $content = file_get_contents_ssl("https://egr.gov.by/egrmobile/api/search/checkStatusSubject?pan=$this->regCode");
        $data = json_decode($content, true);

        if ($data['content'][0]['pan'] ?? false) {
            if(syncContractor($data)) {
                return 0;
            };
        }

        throw new Exception('Job failed');
    }
}
