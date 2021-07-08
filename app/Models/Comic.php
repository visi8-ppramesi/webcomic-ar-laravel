<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comic extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function authors(){
        return $this->belongsToMany(Author::class);
    }

    public function Pages(){
        return $this->hasMany(Page::class);
    }

    public function purchasedBy(){
        return $this->belongsToMany(User::class, 'purchase_histories', 'user_id', 'comic_id');
    }

    public function readBy(){
        return $this->belongsToMany(User::class, 'read_histories', 'user_id', 'comic_id');
    }

    public function ratings(){
        return $this->belongsToMany(User::class, 'ratings', 'user_id', 'comic_id')->withPivot(['rating']);
    }

    public function likes(){
        return $this->belongsToMany(User::class, 'likes', 'user_id', 'comic_id');
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }
}
