<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;

use App\Approval;
use App\Aplikasi;

use Help;

class ApprovalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            'aplikasi_id' => 'required|exists:aplikasi,id',
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
            $aplikasi = Aplikasi::findOrFail($request->aplikasi_id);
            $aplikasi->status = 'Terima';
            $aplikasi->update();
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed update aplikasi',
                'error' => $e->getMessage()
            ], 500);
        }

        try {
            $approval = new Approval;
            $approval->no_approval = Help::numberCode('APP', 'approval', 'no_approval');
            $approval->aplikasi_id = $request->aplikasi_id;
            $approval->user_id = Auth::user()->id;
            $approval->limit_approve = $request->limit_approve;
            $approval->angsuran_approve = $request->angsuran_approve;
            $approval->jangka_waktu_approve = $request->jangka_waktu_approve;
            $approval->tgl_approval = date('Y-m-d');
            $approval->save();
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed add approval',
                'error' => $e->getMessage()
            ], 500);
        }

        DB::commit();

        return response()->json([
            'status' => true,
            'message' => 'Success add approval',
            'results' => $approval,
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
        $approval = Approval::with(['aplikasi.pemohon', 'user'])->findOrFail($id);

        return response()->json([
            'status' => true,
            'message' => 'Success fetch specific approval',
            'results' => $approval
        ], 200);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
