<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    //
    protected $table = "reports";

    protected $fillable = [
        'title',
        'category',
        'location',
        'target_donation',
        'due_date',
        'status',
        'description',
        'user_id',
        'community_id',
        'pic_name',
        'docs'
    ];

    public function images(){
        return $this->hasMany('App\ReportImage');
    }

    public function donate(){
        return $this->hasMany('App\Donation');
    }
    
    public function user(){
        return $this->belongsTo('App\User');
    }

    public function community(){
        return $this->belongsTo('App\Community');
    }

}
