<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Village extends Model
{

    protected $fillable = ['nama','rw','subdistricts_id','bujur','lintang'];
    public function user()
    {
        return $this->hasMany('App\User','villages_id');
    }

    public function text()
    {
        return $this->hasMany('App\Text','villages_id');
    }
}
