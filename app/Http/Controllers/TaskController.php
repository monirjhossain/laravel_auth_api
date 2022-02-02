<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function index()
    {
        //Check login User
        $user = Auth::user();

        if(!is_null($user)){
            $tasks = Task::where('user_id', $user->id)->get();

            if(count($tasks) > 0){
                return response()->json(['status'=>'success', 'count'=>count($tasks), 'data'=>$tasks, 200]);
            }else{
                return response()->json(['status'=>'failed', 'message'=>'Task Not Found', 200]);
            }
        }
    }

    function store(Request $request){

        $authUser = Auth::user();

            if(!is_null($authUser)){
                $validator = Validator::make($request->all(),[
                'title'=>'required',
                'description'=>'required'
            ]);

            if($validator->fails()){
                return response()->json(['status' => 'failed', 'validation_errors' => $validator->errors()]);
            }

            $inputs = $request->all();
            $inputs['user_id'] = $authUser->id;
            $tasks = Task::create($inputs)->get();

            if(!is_null($tasks)){
                return response()->json(['status'=>'success', 'message'=>'Task successfully Created!', 'data'=>$tasks],201);
            }else{
                return response()->json(['status'=>'failed', 'message'=>'Woops! Task Created Failed!', 'data'=>$tasks],201);
            }

        }
    }
     
    public function show($id){
        $authUser = Auth::user();

        if(!is_null($authUser)){
            $tasks = Task::find($id);

            if(!is_null($tasks)){
               return response()->json(['status'=>'success', 'message'=>'Task successfully Found!', 'data'=>$tasks],200); 
            }else{
                return response()->json(['status'=>'failed', 'message'=>'Woops! Task Not Found!', 'data'=>$tasks],200);
            }
        }else{
           return response()->json(['status'=>'failed', 'message'=>'Un-Authorised User'],403); 
        }
    }

    public function update(Request $request, Task $task){
        $authUser = Auth::user();
        if(!is_null($authUser)){
            //validation
            $validator = Validator::make($request->all(),[
                'title'=>'required',
                'description'=>'required'
            ]);

            if($validator->fails()){
                return response()->json(['status' => 'failed', 'validation_errors' => $validator->errors()]);
            }

            $update = $task->update($request->all());
            return response()->json(['status'=>'success', 'message'=>'Task Updated successfully!', 'data'=>$update],201);

        }else{
           return response()->json(['status'=>'failed', 'message'=>'Un-Authorised User'],403); 
        }
    }

    public function destroy($id){
        $authUser = Auth::user();

        if(!is_null($authUser)){
            $task = Task::where('id',$id)->where('user_id',$authUser->id)->delete();
            if($task){
                return response()->json(['status'=>'success', 'message'=>'Task has been deleted Successfull!'],200);
            }
            return response()->json(['status'=>'failed', 'message'=>'Task delete fail!'],200);
        }else{
           return response()->json(['status'=>'failed', 'message'=>'Un-Authorised User'],403); 
        }
    }

}
