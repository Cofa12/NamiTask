<?php

namespace App\Http\Controllers\TaskUserActions;

use App\Http\Controllers\Controller;
use App\Models\Subtask;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;


class TaskUserActionsController extends Controller
{
    //
    public function update(Request $request, string $task_id, string $subtask_id):JsonResponse
    {
        $validator = validator::make($request->all(),[
            'status'=>"required|string",
        ]);

        if($validator->fails()){
            return response()->json([
                'Error'=>$validator->errors()
            ],422);
        }
        try{
            $subtaskExist = Subtask::where('id',$subtask_id)->where('task_id',$task_id)->update([
                'status'=>$request->status
            ]);
            if(!$subtaskExist){
                return response()->json([
                    'Error'=>"This subtask isn't exist"
                ],404);
            }
        }catch (\Exception $e){
            return response()->json([
                'Error'=>$e->getMessage(),
            ],422);
        }

        return response()->json([
            'Message'=>"Subtask has been updated successfully"
        ],200);

    }
}
