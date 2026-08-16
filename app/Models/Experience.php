<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    protected $fillable = ['title', 'organization', 'date_range', 'bullets', 'sort_order'];

    protected $casts = [
        'bullets' => 'array',
    ];
}
