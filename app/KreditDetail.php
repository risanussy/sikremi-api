<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KreditDetail extends Model
{
    protected $table = 'kredit_detail';

    protected $fillable = [
        'limit_kredit'
    ];

    protected $hidden = [
        'kredit_id'  
    ];

    public function kredit()
    {
        return $this->belongsTo('App\Kredit');
    }
}
