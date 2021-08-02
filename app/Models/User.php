<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'full_name',
        'purchase_history',
        'read_history'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function hasRead(){
        return $this->belongsToMany(Comic::class, 'read_histories', 'comic_id', 'user_id');
    }

    public function hasPurchased(){
        return $this->belongsToMany(Comic::class, 'purchase_histories', 'comic_id', 'user_id');
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function likes(){
        return $this->belongsToMany(Comic::class, 'likes', 'comic_id', 'user_id');
    }

    public function bookmarked(){
        return $this->belongsToMany(Page::class);
    }

    public function favorites(){
        return $this->belongsToMany(Comic::class);
    }

    public function bookmarkPage($pageId){
        $siblingIds = Page::find($pageId)->comic()->with('pages')->get()->pluck('pages')[0]->pluck('id')->toArray();
        $faved = $this->load('bookmarked')->favorites->pluck('id')->toArray();
        $newBookmarked = array_values(array_diff($faved, $siblingIds));
        return $this->bookmarked()->sync($newBookmarked);
    }

    public function toggleFavoriteComic($comicId){
        $faved = $this->load('favorites')->favorites->pluck('id')->toArray();
        if(in_array($comicId, $faved)){
            unset($faved[array_search($$comicId, $faved)]);
        }else{
            $faved[] = $comicId;
        }
        return $this->favorites()->sync($faved);
    }
}
