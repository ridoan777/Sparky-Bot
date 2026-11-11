<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VoltDrop extends Model
{
    protected $fillable = [
        'email',
        'phase',
        'volt_drop',
        'drop_percent',
        'cable_size',
        'cable_length',
        'current',
        'voltage',
        'react_Xc',
        'resis_Rc',
        'imp_Zc',
        'coeff',
    ];

    protected $casts = [
        'cable_size' => 'float',
        'cable_length' => 'float',
        'current' => 'float',
        'voltage' => 'float',
        'react_Xc' => 'float',
        'resis_Rc' => 'float',
        'imp_Zc' => 'float',
    ];
}
