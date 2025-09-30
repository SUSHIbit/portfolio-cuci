<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExperienceSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'field',
        'year',
        'role',
        'description',
        'sort_order'
    ];

    protected $casts = [
        'sort_order' => 'integer',
    ];
}
