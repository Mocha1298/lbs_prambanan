<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Map extends Model
{
    public function text()
    {
        return $this->hasMany('App\Text','maps_id');
    }
    protected $fillable = [
        'nama','level','status','perbaikan','rt','rw','bujur','lintang','types_id','villages_id','subdistricts_id','photos_id',
    ];
}
