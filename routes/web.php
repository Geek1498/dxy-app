<?php

use Illuminate\Support\Facades\Route;
use App\Models\BondSummary;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/summary', function () {
    $latest = BondSummary::latest('week_end')->first();

    return view('summary', [
        'summary' => $latest?->summary ?? 'No summary available.',
        'yieldData' => $latest?->raw_yield_data ?? [],
        'dates' => $latest ? [
            'start' => $latest->week_start->toFormattedDateString(),
            'end' => $latest->week_end->toFormattedDateString(),
        ] : null,
    ]);
});

Route::get('/admin/bond-summaries', function () {
    $summaries = BondSummary::orderBy('week_end', 'desc')->get();

    return view('admin.bond_summaries', compact('summaries'));
});