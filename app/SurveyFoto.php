<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SurveyFoto extends Model
{
    protected $table = 'survey_foto';
    public $timestamps = false;

    protected $fillable = [
        'keterangan',
        'file'
    ];

    protected $hidden = [
        'survey_id'
    ];

    public function survey()
    {
        return $this->belongsTo('App\Survey');
    }
}
