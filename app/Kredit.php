<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kredit extends Model
{
    use SoftDeletes;

    protected $table = 'kredit';

    protected $fillable = [
        'limit_kredit'
    ];

    public static function boot() {
        parent::boot();

        static::deleting(function($table) {
            $table->kredit_detail()->delete();
        });
    }

    public function kredit_detail()
    {
        return $this->hasMany('App\KreditDetail');
    }
}
