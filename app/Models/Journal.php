<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    protected $fillable = [
        'user_id',
        'content',
        'focus_level',
        'energy_level',
        'tags',
        'entry_date',
    ];

    protected $casts = [
        'tags' => 'array', // Otomatis ubah JSON di DB jadi Array di PHP
        'entry_date' => 'date',
        'focus_level' => 'integer',
        'energy_level' => 'integer',
    ];
}
