<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function likes()
    {
        return $this->hasMany('App\Like');
    }

    public function Friends()
    {
        return $this->belongsTo('App\Friends');
    }

 public function likes()
 {
     return $this->hasMany('App\Like');
 }
}
