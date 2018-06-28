<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Validator;

class Vacancy extends Model
{
    const STATUS_ACTIVE = true;
    const RESPONSE_EMPTY = 'No Content';
    const RESPONSE_SUCCESS = 'Saved succesfull';
    const RESPONSE_DESTROY = 'Destroyed succesfull';
    const RESPONSE_UNDESTROY = 'Does not destroyed';

    private $rules = [
        'id' => 'integer',
        'name' => 'max:70', 
        'status' => 'boolean',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'status',
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

    public function validate(){
        $validator = Validator::make($this->attributes, $this->rules);
        if ($validator->fails())
            $this->errorMessages = $validator->messages();                   
        return $validator->passes();
    }

    public function vacancies()
    {
        return $this->hasMany('App\Models\Vacancy');
    }

    public function results()
    {
        return $this->hasMany('App\Models\Result');
    }
}
