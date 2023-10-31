<?php

namespace App\Http\Controllers;

use App\User;
use App\Log;
use App\Engineer;
use App\Partner;
use App\Administrator;
use Illuminate\Http\Request;

use Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => 'Fields Required',
                'errors' => $validator->errors()
            ], 400);
        }

        $user = User::where('username', '=', $request->username)->where('deleted_at', '=', NULL)->firstOrFail();

        if(!$user){

            return response()->json([
                'status' => false,
                'message' => 'Username not found'
            ], 400);

        } else {

            if(!Hash::check($request->password, $user->password)){

                return response()->json([
                    'status' => false,
                    'message' => 'Wrong Password'
                ], 400);

            } else {
                
                if($user->active === 'N') {
                    return response()->json([
                        'status' => false,
                        'message' => 'User is not active'
                    ], 400);

                } else {

                    // $user->generateToken();

                    $credentials = request(['username','password']);

                    if(!$token = auth()->attempt($credentials) )
                    {
                        return response()->json([
                            'status' => false,
                            'message' => 'Unauthorized'
                        ], 400);

                    } else {

                        return response()->json([
                            'status' => true,
                            'message' => 'Success Login',
                            'data' => $user,
                            'token' => $token
                        ], 200);

                    }
               }
            }
        }
        
    }

    public function logout(Request $request)
    {
        $user = Auth::user();

        if ($user) {
            auth()->logout();
        }

        try {
            $log = new Log;
            $log->user_id = $user->id;
            $log->description = 'Logout System';
            $log->reference_id = $user->id;
            $log->url = '#/setting';
            $log->save();
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed add log',
                'error' => $e->getMessage()
            ], 500);
        }

        return response()->json([
            'status' => true,
            'message' => 'Success Logout'
        ], 200); 
    }
}
