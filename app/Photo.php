<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    public function map()
    {
        return $this->hasMany('App\Map','photos_id');
    }

    public function text()
    {
        return $this->hasMany('App\Text','photos_id');
    }
    protected $fillable = [
        'foto1','foto2','foto3'
    ];
}
