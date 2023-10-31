<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Keuangan extends Model
{
    protected $table = 'keuangan';
    public $timestamps = false;

    protected $fillable = [
        'penghasilan_perbulan',
        'biaya',
        'keuntungan',
        'penghasilan_lainnya',
        'total_pinjaman_lain',
        'sisa_waktu_angsuran'
    ];

    protected $hidden = [
        'aplikasi_id'  
    ];

    public function aplikasi()
    {
        return $this->belongsTo('App\Aplikasi');
    }
}
