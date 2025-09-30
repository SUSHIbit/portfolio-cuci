<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DynamicSectionItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'section_id',
        'title',
        'year',
        'description',
        'link_url',
        'link_text',
        'sort_order'
    ];

    protected $casts = [
        'section_id' => 'integer',
        'sort_order' => 'integer',
    ];

    public function section()
    {
        return $this->belongsTo(DynamicSection::class, 'section_id');
    }
}
