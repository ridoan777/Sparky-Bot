<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class ReferenceCategory extends Model
{
    use Searchable;
    protected $fillable = [
        'name',
        'description',
        'order',
    ];

    public function refCategoryRelationWith_pages()
    {
        return $this->hasMany(ReferencePage::class, 'category_id');
    }

    public function toSearchableArray()
    {
        return [
            'id' => (int) $this->id,
            'name' => $this->name,
            'description' => $this->description,
        ];
    }
}
