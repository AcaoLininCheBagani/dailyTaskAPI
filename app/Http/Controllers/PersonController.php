<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Person;
use Illuminate\Support\Facades\Hash;

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
        $record->person_name = $request->name;
        $record->person_age =$request->age;
        $record->email = $request->email;
        $record->password = Hash::make($request->password);
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
}