<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReportImage extends Model
{
    //
    protected $table = "report_images";

    protected $fillable = ['report_id','image'];

    public function report(){
        return $this->belongsTo('App\Report');
    }
}
