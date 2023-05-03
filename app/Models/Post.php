<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $guarded = [];//everything here cannot be fill.
    protected $fillable = ['title','excerpt', 'body','slug', 'category_id']; //everything here can be fill.

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
