<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    public function map()
    {
        return $this->hasMany('App\Map','types_id');
    }
    protected $fillable = [
        'jenis','kategori','marker',
    ];
}
