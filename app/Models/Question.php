<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Validator;

class Question extends Model
{
    const STATUS_ACTIVE = true;
    const RESPONSE_EMPTY = 'No Content';
    const RESPONSE_SUCCESS = 'Saved succesfull';
    const RESPONSE_DESTROY = 'Destroyed succesfull';
    const RESPONSE_UNDESTROY = 'Does not destroyed';

    private $rules = [
        'id' => 'integer',
        'vacancy_id' => 'integer',
        'name' => 'max:190', 
        'status' => 'boolean',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'status', 'vacancy_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
		'created_at', 'updated_at',
    ];

    public function scopeByActive($query, $active) {
        return $query->where('status', $active);
    }

    public function scopeByVacancy($query, $vacancy_id) {
        return $query->where('vacancy_id', $vacancy_id);
    }

    public function validate(){
        $validator = Validator::make($this->attributes, $this->rules);
        if ($validator->fails())
            $this->errorMessages = $validator->messages();                   
        return $validator->passes();
    }

    public function answers()
    {
        return $this->hasMany('App\Models\Answer');
    }
}
