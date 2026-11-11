<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CableSize extends Model
{
	protected $fillable = [
		// ---- for D.F. in table-24
		'support_condition',
		'spacing',
		'cable_supports',
		'total_cables',
	];
}
