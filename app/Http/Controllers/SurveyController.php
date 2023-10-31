<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Survey;

use App\SurveyFoto;
use App\SurveyDetail;

use Help;

class SurveyController extends Controller
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
            $survey = new Survey;

            $survey->aplikasi_id = $request->aplikasi_id;
            $survey->user_id = Auth::user()->id;
            $survey->no_survey = Help::dateCode('SRV', 'survey', 'no_survey');

            $survey->keterangan = $request->keterangan;
            $survey->tgl_survey = date('Y-m-d');

            $survey->save();
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed add survey',
                'error' => $e->getMessage()
            ], 500);
        }

        foreach($request['note'] as $key => $val){
            try {

                $detail = new SurveyDetail;
                $detail->survey_id = $survey->id;
                $detail->deskripsi_survey = $request['deskripsi'][$key];
                $detail->check = isset($request['check'][$key]) ? $request['check'][$key] : 'T';
                $detail->note = $request['note'][$key];

                $detail->save();
            } catch (\Exception $e) {
                DB::rollback();
                return response()->json([
                    'status' => false,
                    'message' => 'Failed add detail',
                    'error' => $e->getMessage()
                ], 500);
            }
        }


        $photo = $request->file('lampiran_file');

        foreach($request['lampiran_file'] as $key => $val){
            try {
                
                $name       = $photo[$key]->getClientOriginalName();
                $filename   = pathinfo($name, PATHINFO_FILENAME);
                $extension  = $photo[$key]->getClientOriginalExtension();
                $store_as   = $filename.'_'.time().'.'.$extension;
                $photo[$key]->storeAs('public/survey/'.$survey->id.'/', $store_as);

                $foto = new SurveyFoto;
            
                $foto->survey_id = $survey->id;
                $foto->keterangan = $request['lampiran_keterangan'][$key];
                $foto->file = $store_as;

                $foto->save();
            } catch (\Exception $e) {
                DB::rollback();
                return response()->json([
                    'status' => false,
                    'message' => 'Failed add lampiran',
                    'error' => $e->getMessage()
                ], 500);
            }
        }

        DB::commit();

        return response()->json([
            'status' => true,
            'message' => 'Success add survey',
            'results' => $survey,
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
        $survey = Survey::with(['aplikasi.pemohon', 'user', 'survey_detail', 'survey_foto'])->findOrFail($id);

        return response()->json([
            'status' => true,
            'message' => 'Success fetch specific survey',
            'results' => $survey
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

    public function picture($id, $filename)
    {
        $path = base_path().'/storage/app/public/survey/'.$id.'/'.$filename;
        return Response::download($path); 
    }
}
