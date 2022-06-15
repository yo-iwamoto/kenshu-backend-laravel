<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostToTag extends Model
{
    const CREATED_AT = null;
    const UPDATED_AT = null;

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'post_id',
        'tag_id',
    ];
}
