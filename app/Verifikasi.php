<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Verifikasi extends Model
{
    
    protected $table = 'verifikasi';

    protected $fillable = [
        'no_verifikasi',
        'tgl_verifikasi'
    ];

    protected $hidden = [
        'aplikasi_id', 'user_id' 
    ];

    public function aplikasi()
    {
        return $this->belongsTo('App\Aplikasi');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
