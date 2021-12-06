<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Person;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class PersonController extends Controller
{
    //GAMIT AUTH SA TANAN FUNCTION EXCEPT THIS INSIDE THE ARRAY
    public function __construct(){
        $this->middleware('auth:person',['except' =>[
            "personLogin",
            "createPerson",
        ]]);
    }

    //CREATE PERSONS
    public function createPerson(Request $request){
        $id = 2;
        $record = new Person;
        $record->person_name = $request->pname;
        $record->email = $request->pemail;
        $record->password = Hash::make($request->ppw);
        $record->auth_id = $id;
        $record->save();
        return response()->json([
            'status' => 'Success',
            'message' => 'Successfully created...'
        ]);
    }

    //PERSON LOGIN API
    public function personLogin(Request $request){
        $credentials = $request->only('email','password');
        if(!$token = auth('person')->attempt($credentials)){
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
            // 'user' => auth('person')->user()
        ]);
    }

    //LOGOUT AUTH PERSON
    // public function logout(){

    //     auth('person')->logout();
    //     return response()->json(['message' => 'Successfully signed out']);

    // }
}
