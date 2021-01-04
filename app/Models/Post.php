<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Livewire\WithFileUploads;


class Post extends Model
{
    use HasFactory;

    public function user() {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function likes() {
        return $this->hasMany('App\Models\Like');
    }

    public function comments() {
        return $this->hasMany('App\Models\Comment');
    }
}
