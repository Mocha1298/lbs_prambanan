<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Text extends Model
{
    public function agenda()
    {
        return $this->hasMany('App\Agenda','texts_id');
    }
    protected $fillable = [
        'status','keterangan','rt','rw','bujur','lintang','id_tul','users_id','maps_id','photos_id','villages_id','subdistrict_id',

    ];
}
