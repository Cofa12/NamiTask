<?php

namespace App\Http\Controllers\Auth\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;



// Notes I didn't use token to return like [JWT or Sanctum].
class UserAuthController extends Controller
{
    //
    public function userLogin(Request $request):JsonResponse
    {

        $userLoginedstatus = Auth()->attempt($request->only(['email','password']));
        if(!$userLoginedstatus) {
            return response()->json([
                'Error' => "Email or password isn't correct"
            ], 422);
        }

        try{
            $userData = User::where('email',$request->email)->first();
        }catch (\Exception $e){
            return response()->json([
                'Error'=>$e->getMessage(),
            ],422);
        }
        return response()->json([
            'data'=>$userData
        ],200);
    }
}
