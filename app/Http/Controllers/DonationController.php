<?php

namespace App\Http\Controllers;

use App\Donation;
use App\Http\Resources\DonationResource;
use App\Http\Resources\ReportResource;
use App\Report;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class DonationController extends Controller
{
    //
    public function donate(Request $request, $id){
        try {
            if(Gate::denies('user')){
                return response()->json([
                    'code' => 403,
                    'message' => 'Forbidden'
                ],403);
            }
            
            $report = Report::findOrFail($id);
            if($report == null)
                throw new ModelNotFoundException('Report with ID ' . $id . ' Not Found', 0);

            $request->validate([
                'amount' => 'required|string',
            ]);
        

            $donation = Donation::create([
                'user_id' => Auth::id(),
                'report_id' => $report->id,
                'amount' => $request->amount,
            ]);

            $total = Donation::where('report_id','=',$report->id)->get()->sum('amount');
            if($report->target_donation <= $total){
                $report->status = 'onprogress';
                $report->save();
            }

            return response()->json([
                'code' => 200,
                'data' => new DonationResource($donation)
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'code' => 404,
                'message' => 'Not Found',
                'description' => 'Report ' . $id . ' not found.'
            ], 404);
        }
    }

    public function withdraw($id){
        try {
           

            if(Gate::denies('verified')){
                return response()->json([
                    'code' => 403,
                    'message' => 'Forbidden'
                ],403);
            }

            $report = Report::findOrFail($id);
            
            if($report->community_id !== Auth::id())
            {
                return response()->json([
                    'code' => 403,
                    'message' => 'Forbidden'
                ],403);
            }
            // if($report == null) 
            //     throw new ModelNotFoundException('Report with ID ' . $id . ' Not Found', 0);
    
            if($report->status != "onprogress"){
                return response()->json([
                    'code' => 201,
                    'message' => 'Cannot Withdraw donation from report still on Donation'
                ],201);
            }

            $donation = Donation::where('report_id',$report->id)->get();
            Donation::where('id',$donation->pluck('id'))->delete();
            $report->status = "completed";
            $report->save();
            // dd($donation);
            // $donation->delete();
            
            return response()->json([
                'code' => 201,
                'message' => 'Successfully Withdraw Donation'
            ],201);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'code' => 404,
                'message' => 'Not Found',
                'description' => 'Report ' . $id . ' not found.'
            ], 404);
        }
    }
}
