<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pemohon extends Model
{
    protected $table = 'pemohon';
    public $timestamps = false;

    protected $fillable = [
        'nama_lengkap',
        'tempat_lahir',
        'tgl_lahir',
        'pendidikan_terakhir',
        'telepon',
        'alamat',
        'kecamatan',
        'kota',
        'provinsi',
        'kode_pos',
        'no_ktp',
        'no_npwp',
        'status_tempat_tinggal',
        'lama_tinggal',
        'status',
        'jml_tanggungan',
        'no_kk'
    ];

    protected $hidden = [
        'aplikasi_id'
    ];

    public function aplikasi()
    {
        return $this->belongsTo('App\Aplikasi');
    }
}
