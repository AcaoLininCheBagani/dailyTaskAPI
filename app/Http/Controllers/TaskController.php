<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    public function __construct(){
        $this->middleware('auth:person',['except' =>[]]);
    }

     //CREATE TASK
     public function createTask(Request $request){

        $id = Auth::id();
        $record = new Task;
        $record->person_id = $id;
        $record->task_name = $request->taskname;
        $record->task_description = $request->description;
        $record->isdone = 0;
        $record->save();

        return response()->json([
            'status' => 'Success',
            'message' => 'Successfully created task...'
        ]);
    }

    //READ/VIEW TASK
    public function viewTask(){

        $id = Auth::id();

        $tasks = DB::table('tasks')
        ->join('persons','persons.person_id','=','tasks.person_id')
        ->select(
            'persons.person_name as name',
            'task_name as task',
            'task_description as description',
            DB::raw('DATE_FORMAT(created_at, "%a %d %M %Y %r" ) as date')
        )
        ->where('tasks.person_id','=',$id)
        ->get();

        return $tasks;

    }

    //UPDATE TASK
    public function updateTask(Request $request, $task_id){
        try {

            $record = Task::findOrFail($task_id);
            $record->task_name = $request->task;
            $record->task_description = $request->description;
            $record->save();

            return response()->json(['status'=>200, 'message' => 'successfully edited task...']);

        } catch (\Exception $e) {

            return response()->json(['status' => false,'cant find post...']);
        }
    }

    //DELETE TASK
    public function deleteTask($id){
        try {

            $record = Task::findOrFail($id);
            $record->delete();

            return response()->json(['status'=>200,'message'=>'successfully deleted task...']);

        } catch (\Exception $e) {
            return response()->json(['status' =>false,'cant find task...']);
        }
    }

    //CHECK AUTH USR
    public function check(){
        $user = Auth::check();

        return $user;
    }
}
