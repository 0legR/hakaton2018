<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Validator;

class Answer extends Model
{
     private $rules = [
        'id' => 'integer',
        'question_id' => 'integer',
        'name' => 'max:190', 
        'status' => 'boolean',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'status', 'question_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
		'created_at', 'updated_at',
    ];

    public function scopeByTruth($query, $active) {
        return $query->where('status', $active);
    }

    public function scopeByVacancy($query, $vacancy_id) {
        return $query->where('question_id', $vacancy_id);
    }

    public function validate(){
        $validator = Validator::make($this->attributes, $this->rules);
        if ($validator->fails())
            $this->errorMessages = $validator->messages();                   
        return $validator->passes();
    }

    public function question(){
        return $this->belongsTo('App\Models\Question'); 
    }
}
