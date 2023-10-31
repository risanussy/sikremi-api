<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Survey extends Model
{
    
    protected $table = 'survey';

    protected $fillable = [
        'deskripsi_survey',
        'tgl_survey',
        'note'
    ];

    protected $hidden = [
        'aplikasi_id', 'user_id' 
    ];

    public static function boot() {
        parent::boot();

        static::deleting(function($table) {
            $table->survey_foto()->delete();
        });
    }

    public function aplikasi()
    {
        return $this->belongsTo('App\Aplikasi');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function survey_detail()
    {
        return $this->hasMany('App\SurveyDetail');
    }

    public function survey_foto()
    {
        return $this->hasMany('App\SurveyFoto');
    }
}
