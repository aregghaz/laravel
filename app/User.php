<?php

namespace App;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;


class User extends Model implements Authenticatable
{
    use \Illuminate\Auth\Authenticatable;


    public function Friends()
    {
        return $this->belongsTo('App\Friends');
    }

    public function posts()
    {
        return $this->hasMany('App\Post');

    }

    public function likes()
    {
        return $this->hasMany('App\Like');
    }
}
