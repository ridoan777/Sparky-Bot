<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HelpAbout extends Model
{
    protected $fillable = [
        'type',
        'about_us',
        'help',
        'terms',
        'privacy',
    ];
}
