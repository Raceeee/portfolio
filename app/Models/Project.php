<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = ['tag', 'title', 'subtitle', 'description', 'sort_order'];
}
