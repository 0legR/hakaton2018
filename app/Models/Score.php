<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Validator;

class Score extends Model
{
	const RESPONSE_EMPTY = 'No Content';
    const RESPONSE_SUCCESS = 'Saved succesfull';
    const RESPONSE_DESTROY = 'Destroyed succesfull';
    const RESPONSE_UNDESTROY = 'Does not destroyed';

    private $rules = [
        'id' => 'integer',
        'user_name' => 'max:200', 
        'vacancy_name' => 'max:200',
        'score' => 'max:200',
        'user_email' => 'max:50',
        'vacancy_id' => 'integer',
        'user_id' => 'integer',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'score', 'user_name', 'vacancy_name', 'user_id', 'vacancy_id', 'user_email',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
		'created_at', 'updated_at',
    ];

    public function validate()
    {
        $validator = Validator::make($this->attributes, $this->rules);
        if ($validator->fails())
            $this->errorMessages = $validator->messages();                   
        return $validator->passes();
    }

    public function scopeByVacancy($query, $vacancy_id)
    {
        return $query->where('vacancy_id', $vacancy_id);
    }

    public function scopeByUserAndVacancy($query, $userId, $vacancyId)
    {
    	return $query->where('vacancy_id', $vacancyId)->where('user_id', $userId);
    }
}
