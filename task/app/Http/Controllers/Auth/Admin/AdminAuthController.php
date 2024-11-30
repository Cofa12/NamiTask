<?php

namespace App\Http\Controllers\Auth\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;


// Notes I didn't use token to return like [JWT or Sanctum].
class AdminAuthController extends Controller
{
    //
    public function adminLogin(Request $request):JsonResponse
    {

        $adminLoginedstatus = Auth()->guard('admin')->attempt($request->only(['email','password']));
        if(!$adminLoginedstatus) {
            return response()->json([
                'Error' => "Email or password isn't correct"
            ], 422);
        }

        try{
            $adminData = Admin::where('email',$request->email)->first();
        }catch (\Exception $e){
            return response()->json([
                'Error'=>$e->getMessage(),
            ],422);
        }
        return response()->json([
            'data'=>$adminData
        ],200);
    }
}
