<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Validator;

class Order extends Model
{
    const STATUS_ACTIVE = true;
    const RESPONSE_EMPTY = 'No Content';
    const RESPONSE_SUCCESS = 'Saved succesfull';
    const RESPONSE_DESTROY = 'Destroyed succesfull';
    const RESPONSE_UNDESTROY = 'Does not destroyed';

    private $rules = [
        'id' => 'integer',
        'test_time' => 'integer',
        'company_name' => 'max:180',
        'city' => 'max:180',
        'vacancy' => 'max:180',
        'vacancy_level' => 'max:180',
        'technoligy' => 'max:180',
        'questions_amount' => 'integer',
        'complexity_level' => 'max:180',
        'user_id' => 'integer',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'test_time', 'company_name', 'city', 'vacancy', 'vacancy_level', 'technoligy', 'questions_amount', 'complexity_level', 'user_id',
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

    public function scopeByUserId($query, $user_id) {
        return $query->where('user_id', $user_id);
    }
}
