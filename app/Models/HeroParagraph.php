<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeroParagraph extends Model
{
    use HasFactory;

    protected $fillable = ['content', 'sort_order'];

    protected $casts = [
        'sort_order' => 'integer',
    ];
}
