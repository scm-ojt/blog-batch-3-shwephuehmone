<?php

namespace App\Models;

use App\Post;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Image extends Model
{
    protected $table = 'images';
    protected $fillable = [
     'url', 'post_id'
    ];
    public function post()
    {
        return $this->belongsTo('Post', 'post_id');
    }
}