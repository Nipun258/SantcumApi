<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use Hash;

class StudentController extends Controller
{   
    //register API
    public function register(Request $request){
       
       //validation
       $request->validate([
           "name" => "required",
           "email" => "required|email|unique:students",
           "password"=>"required|confirmed",
           //"phone_no"=>"required"
       ]);

       //create data

       $student = new Student();
       $student->name = $request->name;
       $student->email = $request->email;
       $student->password = Hash::make($request->password);
       $student->phone_no = isset($request->phone_no) ? $request->phone_no: "";

       $student->save();

       //send response
       return response()->json([
          "status" => 1,
          "message" => "student registered succesfully"
       ]);


    }
    
    //login API
    public function login(Request $request){

        //validation
       $request->validate([
           "email" => "required|email",
           "password"=>"required",

       ]);

       //check student
       $student = Student::where("email","=",$request->email)->first();

       if (isset($student->id)) {
           
           if (Hash::check($request->password,$student->password)) {
              //create a token
               $token = $student->createToken("auth_token")->plainTextToken;


              //send response
              return response()->json([
                    "status" => 1,
                    "message" => "student login succesfully",
                    "access_token" => $token

                  ]);
           }else{

             return response()->json([
                    "status" => 0,
                    "message" => "password did not match"
                  ],404);
           }


       }else{

        return response()->json([
          "status" => 0,
          "message" => "student not found"
       ],404);

       }


       return response()->json([
          "status" => 1,
          "message" => "student registered succesfully"
       ]);

    }
    
    //profile API
    public function profile(){

      return response()->json([
          "status" => 1,
          "message" => "student Profile information",
          "data" => auth()->user()
       ]);

    }
    
    //logout API
    public function logout(){

       auth()->user()->tokens()->delete();

        return response()->json([
          "status" => 1,
          "message" => "student logout succesfully",
       ]);

    }
}
