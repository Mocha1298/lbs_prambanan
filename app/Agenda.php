<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    public function text()
    {
        return $this->hasMany('App\Text','texts_id');
    }
    protected $fillable = [
        'texts_id','survey','photo'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
    public function getCreatedAtAttribute()
    {
        return \Carbon\Carbon::parse($this->attributes['survey'])
        ->format('d, M Y');
    }
}
