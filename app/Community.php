<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Community extends Model
{
    //
    //
    protected $table = "communities";

    protected $fillable = ['stamp','is_verified','user_id'];

    public function users(){
        return $this->belongsTo('App\User', 'user_id');
    }
    
    public function reports(){
        return $this->hasMany('App\Report');
    }

  
}
