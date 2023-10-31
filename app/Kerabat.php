<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kerabat extends Model
{
    protected $table = 'kerabat';
    
    public $timestamps = false;

    protected $fillable = [
        'nama_lengkap',
        'hubungan',
        'alamat',
        'kota',
        'jenis_kelamin',
        'telepon'
    ];

    protected $hidden = [
        'aplikasi_id'  
    ];

    public function aplikasi()
    {
        return $this->belongsTo('App\Aplikasi');
    }
}
