<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use OpenAI\Laravel\Facades\OpenAI;
use App\Models\BondSummary;

class FetchBondYields extends Command
{
    protected $signature = 'fetch:bond-yields';
    protected $description = 'Fetch US bond yields and generate a weekly summary';

    public function handle()
    {
        $this->info('Fetching bond yield data...');

        // Mocked or external API fetching logic
        $yieldData = [
            '2Y' => [
                'start' => 4.45,
                'end' => 4.60,
                'start_date' => now()->subWeek()->startOfWeek()->toDateString(),
                'end_date' => now()->subWeek()->endOfWeek()->toDateString(),
            ],
            '10Y' => [
                'start' => 4.15,
                'end' => 4.30,
                'start_date' => now()->subWeek()->startOfWeek()->toDateString(),
                'end_date' => now()->subWeek()->endOfWeek()->toDateString(),
            ],
        ];

        $formattedInput = "US Bond Yield Weekly Data:\n";
        foreach ($yieldData as $term => $data) {
            $formattedInput .= "{$term} yield: from {$data['start']}% to {$data['end']}% "
                             . "({$data['start_date']} to {$data['end_date']})\n";
        }

        $this->info('Generating AI summary...');

        $summaryResponse = OpenAI::chat()->create([
            'model' => 'gpt-4',
            'messages' => [
                ['role' => 'system', 'content' => 'You are a financial analyst providing concise weekly summaries of US bond yield movements.'],
                ['role' => 'user', 'content' => $formattedInput],
            ],
        ]);

        $summary = trim($summaryResponse->choices[0]->message->content);

        // Save to DB
        BondSummary::create([
            'week_start' => now()->subWeek()->startOfWeek(),
            'week_end' => now()->subWeek()->endOfWeek(),
            'raw_yield_data' => $yieldData,
            'summary' => $summary,
        ]);

        $this->info('✅ Weekly bond summary saved successfully.');
    }
}
