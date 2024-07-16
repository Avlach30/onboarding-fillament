<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Enums\Status;

class Post extends Model
{
    use HasFactory;

    // Mapping columns to their respective data types
    protected $casts = [
        'id' => 'string', // This will cast the id to a string when retrieved
        'tags' => 'array', // This will cast the tags to an array when retrieved
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

    public static function boot ()
    {
        parent::boot();

        static::creating(function ($post) {
            // Generate a UUID for the post ID
            $post->id = STR::uuid();
        });
    }
}
