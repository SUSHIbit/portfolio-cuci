<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DynamicSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'section_name',
        'is_active',
        'sort_order'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function items()
    {
        return $this->hasMany(DynamicSectionItem::class, 'section_id')
                    ->orderBy('sort_order');
    }
}
