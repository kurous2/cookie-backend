<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    //
    protected $table = "reports";

    protected $fillable = ['title','category','location','target_donation','due_date', 'status'];

    public function images(){
        return $this->hasMany('App\ReportImage');
    }

    public function donate(){
        return $this->hasMany('App\Donation');
    }

}
