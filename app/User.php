<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Validator;


class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    const TYPE_HR = 2;
    const TYPE_USER = 1;
    const RESPONSE_SUCCESS = 'Saved succesfull';
    const RESPONSE_UNREGISTERED = 'Unregistered user';
    const RESPONSE_EMPTY = 'No Content';

    private $rules = [
        'id' => 'integer',
        'name' => 'max:25', 
        'phone' => 'required|regex:/^[0-9\-\(\)\/\+\s]*$/',
        'email' => 'required|max:50',
        'password' => 'required|min:6',
        'is_cheater' => 'boolean',
        'user_ip' => 'nullable|ip',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'phone', 'role', 'is_cheater', 'user_ip',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'created_at', 'updated_at',
    ];

    public function isHR()
    {
        return $this->role === self::TYPE_HR;
    }

    public function isUser()
    {
        return $this->role === self::TYPE_USER;
    }

    public function validate(){
        $validator = Validator::make($this->attributes, $this->rules);
        if ($validator->fails())
            $this->errorMessages = $validator->messages();                   
        return $validator->passes();
    }

    public function scopeByEmail($query, $email) {
        return $query->where('email', $email);
    }

}
