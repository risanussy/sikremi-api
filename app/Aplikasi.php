<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Aplikasi extends Model
{
    use SoftDeletes;

    protected $table = 'aplikasi';

    protected $fillable = [
        'no_aplikasi',
        'email',
        'angunan',
        'limit_kredit',
        'jangka_waktu',
        'tgl_aplikasi',
        'status',
        'keterangan'
    ];

    public static function boot() {
        parent::boot();

        static::deleting(function($table) {
            $table->pemohon()->delete();
            $table->pasangan()->delete();
            $table->usaha()->delete();
            $table->kerabat()->delete();
            $table->keuangan()->delete();
            $table->lampiran()->delete();
        });
    }

    public function pemohon()
    {
        return $this->hasOne('App\Pemohon');
    }

    public function pasangan()
    {
        return $this->hasOne('App\Pasangan');
    }

    public function usaha()
    {
        return $this->hasOne('App\Usaha');
    }

    public function kerabat()
    {
        return $this->hasOne('App\Kerabat');
    }

    public function keuangan()
    {
        return $this->hasOne('App\Keuangan');
    }

    public function lampiran()
    {
        return $this->hasMany('App\Lampiran');
    }

    public function verifikasi()
    {
        return $this->hasOne('App\Verifikasi');
    }

    public function survey()
    {
        return $this->hasOne('App\Survey');
    }

    public function approval()
    {
        return $this->hasOne('App\Approval');
    }

    
}
