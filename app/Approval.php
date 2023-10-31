<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Approval extends Model
{
    
    protected $table = 'approval';

    protected $fillable = [
        'no_approval',
        'tgl_approval'
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
