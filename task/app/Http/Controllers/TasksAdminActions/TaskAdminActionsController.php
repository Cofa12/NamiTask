<?php

namespace App\Http\Controllers\TasksAdminActions;

use App\Http\Controllers\Controller;
use App\Models\Subtask;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;


class TaskAdminActionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index():JsonResponse
    {
        //
        try{
            $taskData = Task::with('subtasks')->get();

        }catch (\Exception $e){
            return response()->json([
                'Error'=>$e->getMessage(),
            ],422);
        }
        return response()->json([
            'data'=>$taskData
        ],200);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request):JsonResponse
    {
        //
        $validator = validator::make($request->all(),[
            'name'=>"required|string",
            'description'=>"required|string",
            "subtasks"=>"array|required",
            'subtasks.*'=>"required"
        ]);

        if($validator->fails()){
            return response()->json([
                'Error'=>$validator->errors()
            ],422);
        }

        try{
            $taskCreated = Task::create([
                'name'=>$request->input('name'),
                'description'=>$request->input('description')
            ]);
            $subTasks = $request->input('subtasks');
            foreach ($subTasks as $subTask){
                $taskCreated->subtasks()->create([
                    'name'=>$subTask['name'],
                    'due_to'=>now()->addDay(2)
                ]);
            }
        }catch (\Exception $e){
            return response()->json([
                'Error'=>$e->getMessage(),
            ],422);
        }

        return response()->json([
            'Message'=>"Data has been inserted successfully"
        ],201);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id):JsonResponse
    {
        //
        $validator = validator::make($request->all(),[
            'name'=>"required|string",
            'description'=>"required|string",
            "subtasks"=>"array|required",
            'subtasks.*'=>"required"
        ]);

        if($validator->fails()){
            return response()->json([
                'Error'=>$validator->errors()
            ],422);
        }

        try{
            $taskUpdated = Task::where('id',$id)->first();
            if(!$taskUpdated){
                return response()->json([
                    'Error'=>"This task isn't exist",
                ],404);
            }
            $taskUpdated->name=$request->input('name');
            $taskUpdated->description=$request->input('description');

            $subTasks = $request->input('subtasks');
            foreach ($subTasks as $subTask){
                Subtask::where('task_id',$id)->update([
                    "name"=>$subTask['name'],
                    "due_to"=>$subTask['due_to'],
                ]);
            }
        }catch (\Exception $e){
            return response()->json([
                'Error'=>$e->getMessage(),
            ],422);
        }

        return response()->json([
            'Message'=>"Data has been updated successfully"
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id):JsonResponse
    {
        //

        try{
            $taskUpdated = Task::where('id',$id)->first();
            if(!$taskUpdated){
                return response()->json([
                    'Error'=>"This task isn't exist",
                ],404);
            }
            Subtask::where('task_id',$id)->delete();
            $taskUpdated->delete();
        }catch (\Exception $e){
            return response()->json([
                'Error'=>$e->getMessage(),
            ],422);
        }

        return response()->json([
            'Message'=>"Data has been removed successfully"
        ],200);
    }
}
