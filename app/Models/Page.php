<?php

namespace App\Models;

use App\Filters\Get;
use App\Traits\Pipeable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;
    use Pipeable;
    protected $guarded = [];

    public function pipeable(){
        return [
            Get::class
        ];
    }

    public function comic(){
        return $this->belongsTo(Comic::class);
    }

    public function bookmarked(){
        return $this->belongsToMany(User::class);
    }
}
