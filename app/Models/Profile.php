<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'full_name', 'role_title', 'location', 'phone', 'email',
        'objective', 'case_number', 'status', 'github_url', 'linkedin_url',
    ];
}
