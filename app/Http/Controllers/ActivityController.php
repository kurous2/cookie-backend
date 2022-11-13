<?php

namespace App\Http\Controllers;

use App\Community;
use App\Http\Resources\ReportResource;
use App\Report;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ActivityController extends Controller
{
    public $order_table = 'reports';
    //
    public function index()
    {

        try {
            $reports = Report::query();
            if (Gate::allows('user')) {
                $user = User::firstWhere('id', $this->user->id);
                if ($user == null)
                    throw new ModelNotFoundException('Report with User ID ' . $this->user->id . ' Not Found', 0);

                $reports = Report::where('user_id', $user->id);
            } else if (Gate::allows('verified')) {
                $ngo = Community::firstWhere('user_id', $this->user->id);
                if ($ngo == null)
                    throw new ModelNotFoundException('Report with Community User Id ' . $this->user->id . ' Not Found', 0);

                $reports = Report::where('community_id', $ngo->id);
            } else{
                return response()->json([
                    'code' => 403,
                    'message' => 'Forbidden'
                ],403);
            }
            $reports = $reports->when(request()->has('status'),function($q){
                $q->where('status', request('status'));
            })->when([$this->order_table, $this->orderBy], \Closure::fromCallable([$this, 'queryOrderBy']))
                ->when($this->limit, \Closure::fromCallable([$this, 'queryLimit']));
         
            return ReportResource::collection($reports);
            
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'code' => 404,
                'message' => 'Not Found',
                'description' => $e->getMessage(),
            ]);
        }
        // $reports = Report::when([$this->order_table, $this->orderBy], \Closure::fromCallable([$this, 'queryOrderBy']))
        // ->when($this->limit, \Closure::fromCallable([$this, 'queryLimit']));
        
        // dd($reports);
        // return ReportResource::collection($reports);
    }

}
