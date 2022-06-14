<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'post_image_id',
        'title',
        'content',
    ];

    /**
     * 投稿者の User を取得
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function images()
    {
        return $this->hasMany(PostImage::class);
    }

    public function thumbnail_post_image()
    {
        return $this->belongsTo(PostImage::class, 'post_image_id');
    }
}
