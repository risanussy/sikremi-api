<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SurveyDetail extends Model
{
    protected $table = 'survey_detail';
    public $timestamps = false;

    protected $fillable = [
        'check',
        'keterangan'
    ];

    protected $hidden = [
        'survey_id'
    ];

    public function survey()
    {
        return $this->belongsTo('App\Survey');
    }
}
