<?php

namespace App\Http\Controllers;

use App\Community;
use App\Http\Resources\CommunityResource;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class CommunityController extends Controller
{
    public $order_table = 'communities';
    //
    // public function __construct()
    // {
    //     $this->middleware('auth:api', ['except' => [
    //         'login'
    //     ]]);
    // }
    
    public function register(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
        ]);

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'role' => 'community',
            ]);
            
            return response()->json([$user], 201);
        } catch (\Exception $e) {
            return response()->json([
                'code' => 409,
                'message' => 'Conflict',
                'description' => 'User Registration Failed!',
                'exception' => $e
            ], 409);
        }
    }

    public function me()
    {
        if(Gate::allows('community'))
            return new CommunityResource(Community::firstWhere('user_id',Auth::id()));
    }

}
