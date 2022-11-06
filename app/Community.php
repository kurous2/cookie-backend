<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Community extends Model
{
    //
    protected $table = "communities";

    protected $fillable = ['name','email','password','stamp','is_verified'];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function report(){
        return $this->hasMany('App\Report');
    }
}
