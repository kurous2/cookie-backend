<?php

namespace App\Http\Controllers;

use App\Community;
use App\Http\Resources\CommunityResource;
use App\Http\Resources\UserResource;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AuthController extends Controller
{
    //

    // public function login(Request $request)
    // {
    //     $this->validate($request, [
    //         'email' => 'required|string',
    //         'password' => 'required|string',
    //     ]);

    //     $credentials = $request->only(['email', 'password']);

    //     if (!$token = Auth::attempt($credentials)) {
    //         return response()->json([
    //             'code' => 401,
    //             'message' => 'Unauthorized',
    //             'description' => 'User unauthorized.',
    //         ], 401);
    //     }
    //     return $this->respondWithToken($token);
    // }
    
    public function loginCommunity(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only(['email', 'password']);
        
        
            if ($token= Auth::attempt($credentials)) {
                $email = User::where('email',$request->email)->firstOrFail();
        
                $role = $email->role;
                if($role == "community"){
                    return $this->respondWithToken($token);
                } else{
                    return response()->json([
                        'code' => 401,
                        'message' => 'Unauthorized',
                        'description' => 'User unauthorized.',
                    
                    ], 401);
                }
           
            } 
     
        else {
            return response()->json([
                'code' => 401,
                'message' => 'Unauthorized',
                'description' => 'User unauthorized.',
         
            ], 401);
        }
    }

    public function loginUser(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only(['email', 'password']);
        
        
            if ($token= Auth::attempt($credentials)) {
                $email = User::where('email',$request->email)->firstOrFail();
        
                $role = $email->role;
                if($role == "user"){
                    return $this->respondWithToken($token);
                } else{
                    return response()->json([
                        'code' => 401,
                        'message' => 'Unauthorized',
                        'description' => 'User unauthorized.',
                    
                    ], 401);
                }
           
            } 
     
        else {
            return response()->json([
                'code' => 401,
                'message' => 'Unauthorized',
                'description' => 'User unauthorized.',
         
            ], 401);
        }
    }

    // public function me()
    // {
    //     if(Gate::allows('user'))
    //         return new UserResource(Auth::user());
    //     else
    //         return new CommunityResource(Community::firstWhere('user_id',Auth::id()));
    // }

    public function logout()
    {
        Auth::logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh()
    {
        return $this->respondWithToken(Auth::refresh());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60,
            'user_id' => Auth::id(),
        ], 200);
    }
}
