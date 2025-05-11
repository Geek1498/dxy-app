<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\OpenAIService;
use Illuminate\Support\Facades\Storage;
use App\Services\BondYieldService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class FetchBondYields extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-bond-yields';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $yieldData = app(\App\Services\BondYieldService::class)->getWeeklyYields();
        $summary = app(\App\Services\OpenAIService::class)->summarizeYields($yieldData);
    
        Storage::put('public/summary.txt', $summary);
        $this->info('Summary generated and saved!');
    }
}
