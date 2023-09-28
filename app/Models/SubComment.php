<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubComment extends Model
{
    use HasFactory;
    protected $table = 'sub_comments';
    protected $primaryKey = "id";
    
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id', "id");
    }
}
