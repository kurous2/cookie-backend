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
        return $this->hasMany('App\ReportImage', 'report_id');
    }

    public function donates(){
        return $this->hasMany('App\Donation', 'report_id');
    }
    
    public function users(){
        return $this->belongsTo('App\User', 'user_id');
    }

    public function communities(){
        return $this->belongsTo('App\Community', 'community_id');
    }

}
