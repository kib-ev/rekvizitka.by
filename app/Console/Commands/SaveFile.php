<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SaveFile extends Command
{
    protected $signature = 'egr:save';

    protected $description = 'Save files from egr.gov.by';

    public function handle()
    {
        for ($status = 0; $status <= 5; $status++) {
            $content = file_get_contents_ssl('https://egr.gov.by/api/v2/egr/getRegNumByState/' . $status);
            file_put_contents(base_path('tmp/state_' . $status . '.txt'), $content);
        }

        $this->info('done');
    }
}
