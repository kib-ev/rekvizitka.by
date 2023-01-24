<?php

namespace App\Console\Commands;

use App\Models\Contractor;
use Illuminate\Console\Command;

class SyncEGR extends Command
{
    protected $signature = 'sync:egr {from} {to}';

    protected $description = 'Sync egr.gov.by';

    protected int $startFrom;
    protected int $endWhen;

    public function handle()
    {
        $this->startFrom = $this->argument('from');
        $this->endWhen = $this->argument('to');

//        $lastContractor = Contractor::where('reg_code', '>=', $this->startFrom)->where('reg_code', '<=', $this->endWhen)->latest()->first();
//        $regCode = $lastContractor ? $lastContractor->reg_code : $this->startFrom;

        $maxRegCode = Contractor::where('reg_code', '>=', $this->startFrom)->where('reg_code', '<=', $this->endWhen)->max('reg_code');
        $nextRegCode = $maxRegCode ? $maxRegCode + 1 : $this->startFrom;

        $this->loadPage($nextRegCode);
    }

    public function loadPage($regCode)
    {
        $this->info("Load $regCode");
//        $content = file_get_contents_ssl("https://rekvizitka.by/$regCode");

        $contractor = \App\Models\Contractor::where('reg_code', $regCode)->first();

        if (!$contractor) {

            $content = file_get_contents_ssl("https://egr.gov.by/egrmobile/api/search/checkStatusSubject?pan=$regCode");
            $data = json_decode($content, true);

            if ($data['content'][0]['pan'] ?? null) {
                syncContractor($data);
            }

            if(isset($content) && $regCode <= $this->endWhen) {
                $this->loadPage($regCode + 1);
            }
        }


//        sleep(1);
//        dd($regCode, $content);

//        if($content && $regCode <= $this->endWhen) {
//            $this->loadPage($regCode + 1);
//        }
    }

    public function curlLoadPage($regCode)
    {
        $ch = curl_init("https://rekvizitka.by/$regCode");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        $html = curl_exec($ch);
        curl_close($ch);


        dd($html);
    }
}
