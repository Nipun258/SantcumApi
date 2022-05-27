<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;

class ProjectController extends Controller
{   

    //Project Create API
    public function createProject(Request $request){

        //validation
        $request->validate([
           "name" => "required",
           "description" => "required",
           "duration"=>"required|numeric",
       ]);

        //student id + create data
        $student_id = auth()->user()->id;
        $project = new Project();
        $project->student_id = $student_id;
        $project->name = $request->name;
        $project->description = $request->description;
        $project->duration = $request->duration;

        $project->save();
        //send response
        return response()->json([
          "status" => 1,
          "message" => "student project added succesfully"
       ]);

    }

    //Project List API
    public function listProject(){
        
        //list the data
        $student_id = auth()->user()->id;
        $project = Project::where("student_id","=",$student_id)->get();

        //send response
        return response()->json([
          "status" => 1,
          "message" => "student project list succesfully",
          "data" => $project
       ]);


    }
    //Single Project API
    public function singleProject($id){

        $student_id = auth()->user()->id;

        if(Project::where([
             'id' => $id,
             'student_id' => $student_id
        ])->exists()){

            $details = Project::find($id);

        //send response
        return response()->json([
          "status" => 1,
          "message" => "student project detils succesfully",
          "data" => $details
       ]);



        }else{

            return response()->json([
                    "status" => 0,
                    "message" => "project not found"
                  ],404);
        }


    }
    
    //Project delete API
    public function deleteProject($id){
    
      $student_id = auth()->user()->id;

      if(Project::where([
             'id' => $id,
             'student_id' => $student_id
        ])->exists()){
       
       $project =Project::where([
             'id' => $id,
             'student_id' => $student_id
        ])->first();

       $project->delete();

        //send response
        return response()->json([
          "status" => 1,
          "message" => "student project delete succesfully",
       ]);



        }else{

            return response()->json([
                    "status" => 0,
                    "message" => "project not found"
                  ],404);
        }

    }
}
