<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    const STATUS_ACTIVE = true;
    const RESPONSE_EMPTY = 'No Content';
    const RESPONSE_SUCCESS = 'Saved succesfull';
    const RESPONSE_DESTROY = 'Destroyed succesfull';
    const RESPONSE_UNDESTROY = 'Does not destroyed';

    private $rules = [
        'id' => 'integer',
        'name' => 'max:70',
        'phone' => 'required|regex:/^[0-9\-\(\)\/\+\s]*$/',
        'address' => 'max:190',
        'email' => 'required|max:50',
        'web_link' => 'max:70',
		'image' => 'max:99|nullable',
        'created_by' => 'integer|required',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'name', 'phone', 'address', 'email', 'web_link', 'image', 'created_by',
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
}
