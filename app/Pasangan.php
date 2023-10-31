<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pasangan extends Model
{
    protected $table = 'pasangan';
    public $timestamps = false;

    protected $fillable = [
        'nama_lengkap',
        'tempat_lahir',
        'tgl_lahir',
        'pendidikan_terakhir',
        'no_ktp',
        'pekerjaan',
        'penghasilan'
    ];

    protected $hidden = [
        'aplikasi_id'  
    ];

    public function aplikasi()
    {
        return $this->belongsTo('App\Aplikasi');
    }
}
