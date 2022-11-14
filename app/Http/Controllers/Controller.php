<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Schema;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    public function __construct(Request $request)
    {
        $this->middleware('auth:api', ['except' => [
            'loginUser', 'loginCommunity', 'logout','register',
        ]]);
        
        $PAGINATION = 5;
        $this->user = $request->user();
        $this->limit = $request->get('limit') ? $request->get('limit') : $PAGINATION;
        $this->orderBy = $request->get('order_by');
        $this->search = $request->get('search');
    }

    public function queryLimit($query, $limit)
    {
        
        return $query->Paginate($limit)
            ->appends(request()->query());
    }

    public function queryOrderBy($query, $orderBy)
    {
       
        $order_table = $orderBy[0];
        $orders = explode(',', $orderBy[1]);
        // dd($orders);
        $ordering = "";
        if(count($orders)>1)
            $ordering = substr($orders[1],0);
        // dd($ordering);
        foreach ($orders as $order) {
            $order_field = substr($order, 0);
        
            if (Schema::hasColumn($order_table, $order_field)) {
                // dd($order);
                $order_mode = (($ordering === "")) ? 'asc' : $ordering;
                // dd();
                $query->orderBy($order_field, $order_mode);   
            }
        }
        // dd($query);

        return $query;
    }

}
