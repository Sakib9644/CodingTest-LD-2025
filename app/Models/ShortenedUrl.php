<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ShortenedUrl extends Model
{
    use HasFactory;

    protected $table = 'shortened_urls'; // string, not array

    protected $fillable = ['user_id', 'original_url', 'short_code'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
