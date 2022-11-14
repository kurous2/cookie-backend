<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    //
    protected $table = "donations";

    protected $fillable = ['user_id','report_id','amount'];

    public function users(){
        return $this->belongsTo('App\User', 'user_id');
    }

    public function reports(){
        return $this->belongsTo('App\Report', 'report_id');
    }
}
