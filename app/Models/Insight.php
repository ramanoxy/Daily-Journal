<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Insight extends Model
{
    protected $fillable = [
        'user_id',
        'week_start',
        'week_end',
        'avg_focus',
        'avg_energy',
        'sentiment_score',
        'suggestions',
        'raw_ai_response',
    ];

    protected $casts = [
        'week_start' => 'date',
        'week_end' => 'date',
        'avg_focus' => 'decimal:2',
        'avg_energy' => 'decimal:2',
        'sentiment_score' => 'integer',
        'suggestions' => 'array',
        'raw_ai_response' => 'array',
    ];
}
