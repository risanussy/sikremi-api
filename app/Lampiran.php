<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lampiran extends Model
{
    protected $table = 'lampiran';
    public $timestamps = false;

    protected $fillable = [
        'keterangan',
        'file'
    ];

    protected $hidden = [
        'aplikasi_id'  
    ];

    public function aplikasi()
    {
        return $this->belongsTo('App\Aplikasi');
    }
}
