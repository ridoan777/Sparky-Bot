<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class ReferencePage extends Model
{
	use Searchable;
	protected $fillable = [
		'img_id',
		'title',
		'details',
		'path',
		'ref_pdf_page',
		'category_id'
	];

	public function refPageRetalationWith_category()
	{
		return $this->belongsTo(ReferenceCategory::class, 'category_id');
	}

	public function toSearchableArray()
	{
		return [
			'id' => (int) $this->id,
			'title' => $this->title,
			'details' => $this->details,
			'ref_pdf_page' => $this->ref_pdf_page,
		];
	}
}
