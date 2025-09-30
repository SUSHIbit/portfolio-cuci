<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogContentBlock extends Model
{
    use HasFactory;

    protected $fillable = [
        'blog_id',
        'type',
        'content',
        'sort_order',
    ];

    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }
}
