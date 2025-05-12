<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BondSummary extends Model
{
    //
    protected $fillable = [
        'week_start',
        'week_end',
        'raw_yield_data',
        'summary',
    ];

    protected $casts = [
        'raw_yield_data' => 'array',
        'week_start' => 'date',
        'week_end' => 'date',
    ];
}
