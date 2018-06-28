<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Validator;

class Result extends Model
{
    const RESPONSE_EMPTY = 'No Content';
    const RESPONSE_SUCCESS = 'Saved succesfull';
    const RESPONSE_DESTROY = 'Destroyed succesfull';
    const RESPONSE_UNDESTROY = 'Does not destroyed';

    private $rules = [
        'id' => 'integer',
        'question_id' => 'integer', 
        'user_id' => 'integer', 
        'answer_id' => 'integer',
        'vacancy_id' => 'integer',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'question_id', 'user_id', 'answer_id', 'vacancy_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
		'created_at', 'updated_at',
    ];

    public function validate(){
        $validator = Validator::make($this->attributes, $this->rules);
        if ($validator->fails())
            $this->errorMessages = $validator->messages();                   
        return $validator->passes();
    }

    public function scopeByUserId($query, $id) {
        return $query->where('user_id', $id);
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function vacancy()
    {
        return $this->belongsTo('App\Models\Vacancy');
    }

    public function answer()
    {
        return $this->belongsTo('App\Models\Answer');
    }
}
