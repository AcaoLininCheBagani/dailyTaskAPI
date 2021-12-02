<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    //GAMIT AUTH SA TANAN FUNCTION EXCEPT THIS INSIDE THE ARRAY
    public function __construct(){
        $this->middleware('auth:admin',['except' =>[
            "adminLogin",
            "createAdmin",
        ]]);
    }
    //CREATE ADMIN
    public function adminCreate(Request $request){
        $record = new Admin;
        $record->admin_name = $request->name;
        $record->email = $request->email;
        $record->password = Hash::make($request->password);
        $record->id = 1;
        $record->save();
        return response()->json([
            'status' => 'Success',
            'message' => 'Successfully created...'
        ]);
    }
    //ADMIN LOGIN API
    public function adminLogin(Request $request){
        $credentials = $request->only('email','password');
        if(!$token = auth('admin')->attempt($credentials)){
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->createNewToken($token);
    }

    //BUHAT TOKEN KADA LOGIN
    protected function createNewToken($token){
        return response()->json([
            'status' => 'true',
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL()*60,
            // 'user' => auth('admin')->user()
        ]);
    }
}
