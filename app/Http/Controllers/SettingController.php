<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

use Hash;
use App\User;
use Auth;

class SettingController extends Controller
{
    public function profile()
    {
        $auth = Auth::user();
        $profile = User::findOrFail($auth->id);

        return response()->json([
            'status' => true,
            'message' => 'Success fetch profile',
            'results' => $profile
        ], 200);
    }

    public function change_password(Request $request)
    {
        $auth = Auth::user();

        $validator = Validator::make($request->all(), [
            'old_password' => 'required|string',
            'new_password' => 'required|string',
            'retype_password' => 'required|string|same:new_password',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => 'Fields Required',
                'errors' => $validator->errors()
            ], 422);
        }

        if(!Hash::check($request->old_password, $auth->password )) 
        {
             return response()->json([
                'status' => false,
                'message' => 'Wrong password'
            ], 422);
        }

        DB::beginTransaction();
            try {
                $auth->password = bcrypt($request->new_password);
                $update = $auth->save();
            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Failed change password',
                    'error' => $e->getMessage()
                ], 500);
            }
        
        DB::commit();

        return response()->json([
            'status' => true,
            'message' => 'Success change password',
        ], 200);
    }
}
