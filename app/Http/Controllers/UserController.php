<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\User;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::where('level', '!=', 'ADMIN')->get();

        return response()->json([
            'status' => true,
            'message' => 'Success fetch user',
            'results' => $user
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'required|string',
            'username' => 'required|string',
            'level' => 'required|in:ANALYST,MANAGER',
            'active' => 'required|in:Y,N',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => 'Fields Required',
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();

            try {
                $user = new User;
                $user->nama_lengkap = $request->nama_lengkap;
                $user->username = $request->username;
                $user->password = bcrypt($request->username);
                $user->level = $request->level;
                $user->active = $request->active;

                $user->save();
            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Failed add user',
                    'error' => $e->getMessage()
                ], 500);
            }
        
        DB::commit();

        return response()->json([
            'status' => true,
            'message' => 'Success add user',
            'results' => $user,
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'required|string',
            'username' => 'required|string',
            'level' => 'required|in:ANALYST,MANAGER',
            'active' => 'required|in:Y,N',
        ]);
            
        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => 'Fields Required',
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();
        
            try {
                $user->nama_lengkap = $request->nama_lengkap;
                $user->username = $request->username;
                $user->level = $request->level;
                $user->active = $request->active;
                $user->update();
            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Failed update user',
                    'error' => $e->getMessage()
                ], 500);
            }
        
        DB::commit();
        
        return response()->json([
            'status' => true,
            'message' => 'Success update user',
            'results' => $user,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        DB::beginTransaction();
        
            try {
                $user->delete();
            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Failed delete user',
                    'error' => $e->getMessage()
                ], 500);
            }
        
        DB::commit();

        return response()->json([
            'status' => true,
            'message' => 'Success archive user',
            'results' => $user,
        ], 200);
    }
}
