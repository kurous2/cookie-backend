<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    //
    protected $table = "donations";

    protected $fillable = ['user_id','report_id','amount'];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function report(){
        return $this->belongsTo('App\Report');
    }
}
