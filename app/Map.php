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
        'nama','level','status','perbaikan','rt','rw','sumber','texts_id','bujur','lintang','types_id','villages_id','subdistricts_id','photos_id',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        // your other new column
    ];
    
    public function getCreatedAtAttribute()
    {
        return \Carbon\Carbon::parse($this->attributes['created_at'])
        ->format('d, M Y');
    }
}
