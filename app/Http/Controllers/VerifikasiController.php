<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;

use App\Verifikasi;
use App\Aplikasi;

use Help;

class VerifikasiController extends Controller
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
            $verifikasi = new Verifikasi;
            $verifikasi->no_verifikasi = Help::numberCode('VR', 'verifikasi', 'no_verifikasi');
            $verifikasi->aplikasi_id = $request->aplikasi_id;
            $verifikasi->user_id = Auth::user()->id;
            $verifikasi->tgl_verifikasi = date('Y-m-d');
            $verifikasi->save();
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed add verifikasi',
                'error' => $e->getMessage()
            ], 500);
        }

        DB::commit();

        return response()->json([
            'status' => true,
            'message' => 'Success add verifikasi',
            'results' => $verifikasi,
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
        $verifikasi = Verifikasi::with(['aplikasi.pemohon', 'user'])->findOrFail($id);

        return response()->json([
            'status' => true,
            'message' => 'Success fetch specific verifikasi',
            'results' => $verifikasi
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
