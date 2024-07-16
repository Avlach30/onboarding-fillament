<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\Status;

class Post extends Model
{
    use HasFactory;

    protected $casts = [
        'tags' => 'array',
    ];

    protected $fillable = [
        'title',
        'content',
        'status',
        'tags',
    ];

    protected $attributes = [
        'status' => Status::ACTIVE->value,
    ];
}
