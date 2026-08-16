<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $fillable = ['category', 'name', 'sort_order'];

    public const CATEGORIES = [
        'language' => 'Programming Language',
        'core'     => 'Core Area',
        'tool'     => 'Tool / Platform',
        'soft'     => 'Soft Skill',
    ];
}
