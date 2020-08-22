<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudyRecord extends Model
{
    protected $table = 'studyrecords';
    
    protected $fillable = ['user_id', 'study_hours', 'study_tweet', 'study_date'];
    
    public function user()
    {
//    return $this->hasMany('App\User');
        return $this->belongsTo('App\User');
    }
}
