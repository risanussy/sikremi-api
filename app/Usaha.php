<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Usaha extends Model
{
    protected $table = 'usaha';
    public $timestamps = false;

    protected $fillable = [
        'berusaha_sejak',
        'bidang_usaha',
        'jml_karyawan',
        'alamat',
        'telepon',
        'status_kepemilikan'
    ];

    protected $hidden = [
        'aplikasi_id'
    ];

    public function aplikasi()
    {
        return $this->belongsTo('App\Aplikasi');
    }
}
