<?php

namespace App\Models;

use App\Models\Post;
use App\Models\Image;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable= [
        'user_id',
        'image',
        'title',
        'body',
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'categories_posts');
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function images()
    {
        return $this->hasMany('Image', 'post_id');
    }
}