<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subdistrict extends Model
{
    public function village()
    {
        return $this->hasMany('App\Village','subdistricts_id');
    }
    public function maps()
    {
        return $this->hasMany('App\Map','subdistricts_id');
    }
    public function text()
    {
        return $this->hasMany('App\Text','subdistricts_id');
    }
    protected $fillable = [
        'nama','desa','nama_cmt','bujur','lintang'
    ];
}
