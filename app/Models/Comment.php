<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $table = 'comments';
    protected $primaryKey = "id";

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id', "id");
    }

    public function post()
    {
        return $this->belongsTo(Post::class, "post_id", "id");
    }

    public function subComment()
    {
        return $this->hasMany(SubComment::class);
    }
}
