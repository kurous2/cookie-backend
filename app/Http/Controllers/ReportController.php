<?php

namespace App\Http\Controllers;

use App\Community;
use App\Donation;
use App\Http\Resources\ReportResource;
use App\Report;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ReportController extends Controller
{
    //
    public $order_table = 'reports';
    
    // public function __construct(Request $request)
    // {
    //     $this->middleware('auth:api,community-api', ['except' => [
    //         'login'
    //     ]]);
        
    //     $PAGINATION = 50;
    //     $this->limit = $request->get('limit') ? $request->get('limit') : $PAGINATION;
    //     $this->orderBy = $request->get('order_by');
    //     $this->search = $request->get('search');
    // }

    public function index()
    {

        $reports = Report::query();
        // if ($search !== null) {
        //     $reports->Where(function($query) use($search) {
        //         $query->where('status', 'LIKE', "%{$search}%" )
        //             ->orWhere ( 'title', 'LIKE', "%{$search}%" )
        //             ->orWhere ( 'category', 'LIKE', "%{$search}%" );
        //     });
        // }
        $reports = $reports->when(request()->has('status'),function($q){
            $q->where('status', request('status'));
        })
        ->when(request()->has('title'),function($q){
            $q->where('title', 'LIKE','%'.request('title').'%');
        })
        ->when(request()->has('category'),function($q){
            $q->where('category', 'LIKE', '%'.request('category').'%');
        })->when([$this->order_table, $this->orderBy], \Closure::fromCallable([$this, 'queryOrderBy']))
        ->when($this->limit, \Closure::fromCallable([$this, 'queryLimit']));
        
        
        $collection = ReportResource::collection($reports);


        return $collection;
    }

    public function store(Request $request)
    {
        if(Gate::denies('user')){
            return response()->json([
                'code' => 403,
                'message' => 'Forbidden'
            ],403);
        }
        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'category' => 'required|string',
            'location' => 'required|string',
            'due_date' => 'nullable|string',
            'docs' => 'nullable|string',
            'init_donation' => 'nullable|string',
            
        ]);

        $report = Report::create([
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category,
            'location' => $request->location,
            'status' => 'initial',
            'due_date' => $request->due_date,
            'user_id' => Auth::id(),
            'docs' => $request->docs
        ]);

        if($report !== null && $request->init_donation !== null ){
                Donation::create([
                    'amount' => $request->init_donation,
                    'report_id' => $report->id,
                    'user_id' => $report->user_id
                ]);
        }
 

        return response()->json([
            'code' => 200,
            'data' => new ReportResource($report)
        ]);
    }

    public function takeReport(Request $request, $id)
    {
        //
        try {
        if(Gate::denies('verified')){
            return response()->json([
                'code' => 403,
                'message' => 'Forbidden'
            ],403);
        }
        $report = Report::findOrFail($id);
        if($report == null)
            throw new ModelNotFoundException('Report with ID ' . $id . ' Not Found', 0);

        $community = Community::firstWhere('user_id',Auth::id());
        $request->validate([
            'pic_name' => 'nullable|string',
            'target_donation' => 'nullable|string',
        ]);
        // dd($request->target_donation);
    
            $total = Donation::where('report_id','=',$report->id)->get()->sum('amount');
            $report->community_id = $community->id;
            $report->pic_name = $request->pic_name;
            if($request->target_donation === null || $request->target_donation <= $total)
                $report->status = "onprogress";
            else
                $report->status = "ondonation";
            $report->target_donation = $request->target_donation;
            $report->save();
            // dd($report);
            return new ReportResource($report);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'code' => 404,
                'message' => 'Not Found',
                'description' => 'Report ' . $id . ' not found.'
            ], 404);
        }

    }

    public function finishReport($id)
    {
        //
        try {
        if(Gate::denies('verified')){
            return response()->json([
                'code' => 403,
                'message' => 'Forbidden'
            ],403);
        }
        $report = Report::findOrFail($id);
        if($report == null)
            throw new ModelNotFoundException('Report with ID ' . $id . ' Not Found', 0);
 
        // dd($request->target_donation);
            $report = Report::findOrFail($id);
            $report->status = "completed";
            $report->save();
            // dd($report);
            return response()->json([
                'code' => 201,
                'message' => 'Successfully Finish Report',
                'data' => new ReportResource($report)
            ],201);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'code' => 404,
                'message' => 'Not Found',
                'description' => 'Report ' . $id . ' not found.'
            ], 404);
        }

    }

    public function destroy($id){
        try {
            $report = Report::findOrFail($id);
           
            if(Gate::allows('user'))
                if($report->user_id !== Auth::id())
                {
                    return response()->json([
                        'code' => 403,
                        'message' => 'Forbidden'
                    ],403);
                }
            if(Gate::allows('verified'))
                if($report->community_id !== Auth::id())
                {
                    return response()->json([
                        'code' => 403,
                        'message' => 'Forbidden'
                    ],403);
                }
            if(Gate::allows('community')){
                return response()->json([
                    'code' => 403,
                    'message' => 'Forbidden'
                ],403);
            }
            // dd($report->user_id !== Auth::id());
            Report::findOrFail($id)->delete();
            return response()->json([
                'code' => 201,
                'message' => 'Successfully Withdraw Donation'
            ],201);
            return response()->json([
                'code' => 204,
                'message' => 'Successfully Delete Report'
            ], 204);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'code' => 404,
                'message' => 'Not Found',
                'description' => 'Report ' . $id . ' not found.'
            ], 404);
        }
    }
}
