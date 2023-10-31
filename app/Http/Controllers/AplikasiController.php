<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Aplikasi;

use App\Pemohon;
use App\Kerabat;
use App\Pasangan;
use App\Usaha;
use App\Keuangan;
use App\Lampiran;

use Help;

class AplikasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $no_aplikasi = $request->no_aplikasi;
        $email = $request->email;

        $bulan = $request->bulan;
        $tahun = $request->tahun;

        if($no_aplikasi || $email){
            $aplikasi = Aplikasi::where(function($query) use($no_aplikasi, $email){
                $query->where('no_aplikasi', '=', $no_aplikasi)
                      ->where('email', '=', $email);
            })->with(['pemohon', 'kerabat', 'pasangan', 'usaha', 'keuangan', 'lampiran', 'verifikasi.user', 'survey.user', 'approval.user'])->first();
        } else if($bulan && $tahun) {
            $aplikasi = Aplikasi::where(function($query) use($bulan, $tahun){
                $query->whereMonth('aplikasi.tgl_aplikasi', '=', $bulan)
                      ->whereYear('aplikasi.tgl_aplikasi', '=', $tahun);
            })->with(['pemohon', 'kerabat', 'pasangan', 'usaha', 'keuangan', 'lampiran', 'verifikasi.user', 'survey.user', 'approval.user'])->get();
        } else {
            $aplikasi = Aplikasi::with(['pemohon', 'kerabat', 'pasangan', 'usaha', 'keuangan', 'lampiran', 'verifikasi.user', 'survey.user', 'approval.user'])->get();
        }
        
        return response()->json([
            'status' => true,
            'message' => 'Success fetch aplikasi',
            'results' => $aplikasi
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
            'angunan' => 'required|string',
            'email' => 'required|string',
            'limit_kredit' => 'required|string',
            'jangka_waktu' => 'required|string',
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
            $aplikasi = new Aplikasi;

            $aplikasi->no_aplikasi = Help::dateCode('KRJ', 'aplikasi', 'no_aplikasi');;
            $aplikasi->email = $request->email;
            $aplikasi->angunan = $request->angunan;
            $aplikasi->angsuran = $request->angsuran;
            $aplikasi->limit_kredit = $request->limit_kredit;
            $aplikasi->jangka_waktu = $request->jangka_waktu;
            $aplikasi->tgl_aplikasi = date('Y-m-d');
            $aplikasi->status = 'Proses';

            $aplikasi->save();
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed add aplikasi',
                'error' => $e->getMessage()
            ], 500);
        }

        try {
            $pemohon = new Pemohon;

            $pemohon->aplikasi_id = $aplikasi->id;

            $pemohon->nama_lengkap = $request->pemohon_nama_lengkap;
            $pemohon->tempat_lahir = $request->pemohon_tempat_lahir;
            $pemohon->tgl_lahir = $request->pemohon_tgl_lahir;
            $pemohon->pendidikan_terakhir = $request->pemohon_pendidikan_terakhir;
            $pemohon->telepon = $request->pemohon_telepon;
            $pemohon->alamat = $request->pemohon_alamat;
            $pemohon->kecamatan = $request->pemohon_kecamatan;
            $pemohon->kota = $request->pemohon_kota;
            $pemohon->provinsi = $request->pemohon_provinsi;
            $pemohon->kode_pos = $request->pemohon_kode_pos;
            $pemohon->no_ktp = $request->pemohon_no_ktp;
            $pemohon->no_npwp = $request->pemohon_no_npwp;
            $pemohon->status_tempat_tinggal = $request->pemohon_status_tempat_tinggal;
            $pemohon->lama_tinggal = $request->pemohon_lama_tinggal;
            $pemohon->status = $request->pemohon_status;
            $pemohon->jml_tanggungan = $request->pemohon_jml_tanggungan;
            $pemohon->no_kk = $request->pemohon_no_kk;

            $pemohon->save();
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed add pemohon',
                'error' => $e->getMessage()
            ], 500);
        }

        try {
            $pasangan = new Pasangan;

            $pasangan->aplikasi_id = $aplikasi->id;

            $pasangan->nama_lengkap = $request->pasangan_nama_lengkap;
            $pasangan->tempat_lahir = $request->pasangan_tempat_lahir;
            $pasangan->tgl_lahir = $request->pasangan_tgl_lahir;
            $pasangan->pendidikan_terakhir = isset($request->pasangan_pendidikan_terakhir) ? $request->pasangan_pendidikan_terakhir : '';
            $pasangan->no_ktp = $request->pasangan_no_ktp;
            $pasangan->pekerjaan = $request->pasangan_pekerjaan;
            $pasangan->penghasilan = $request->pasangan_penghasilan;

            $pasangan->save();
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed add pasangan',
                'error' => $e->getMessage()
            ], 500);
        }

        try {
            $kerabat = new Kerabat;

            $kerabat->aplikasi_id = $aplikasi->id;

            $kerabat->nama_lengkap = $request->kerabat_nama_lengkap;
            $kerabat->hubungan = $request->kerabat_hubungan;
            $kerabat->alamat = $request->kerabat_alamat;
            $kerabat->kota = $request->kerabat_kota;
            $kerabat->jenis_kelamin = $request->kerabat_jenis_kelamin;
            $kerabat->telepon = $request->kerabat_telepon;

            $kerabat->save();
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed add kerabat',
                'error' => $e->getMessage()
            ], 500);
        }

        try {
            $usaha = new Usaha;

            $usaha->aplikasi_id = $aplikasi->id;

            $usaha->berusaha_sejak = $request->usaha_berusaha_sejak;
            $usaha->bidang_usaha = $request->usaha_bidang_usaha;
            $usaha->jml_karyawan = $request->usaha_jml_karyawan;
            $usaha->alamat = $request->usaha_alamat;
            $usaha->telepon = $request->usaha_telepon;
            $usaha->status_kepemilikan = $request->usaha_status_kepemilikan;

            $usaha->save();
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed add usaha',
                'error' => $e->getMessage()
            ], 500);
        }

        try {
            $keuangan = new Keuangan;

            $keuangan->aplikasi_id = $aplikasi->id;

            $keuangan->penghasilan_perbulan = $request->keuangan_penghasilan_perbulan;
            $keuangan->biaya = $request->keuangan_biaya;
            $keuangan->keuntungan = $request->keuangan_keuntungan;
            $keuangan->penghasilan_lainnya = $request->keuangan_penghasilan_lainnya;
            $keuangan->total_pinjaman_lain = $request->keuangan_total_pinjaman_lain;
            $keuangan->angsuran_pinjaman_lain = $request->keuangan_angsuran_pinjaman_lain;
            $keuangan->sisa_waktu_angsuran = $request->keuangan_sisa_waktu_angsuran;

            $keuangan->save();
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed add keuangan',
                'error' => $e->getMessage()
            ], 500);
        }

        $photo = $request->file('lampiran_file');

        foreach($request['lampiran_file'] as $key => $val){
            try {
                
                $name       = $photo[$key]->getClientOriginalName();
                $filename   = pathinfo($name, PATHINFO_FILENAME);
                $extension  = $photo[$key]->getClientOriginalExtension();
                $store_as   = $filename.'_'.time().'.'.$extension;
                $photo[$key]->storeAs('public/lampiran/'.$aplikasi->id.'/', $store_as);

                $lampiran = new Lampiran;
            
                $lampiran->aplikasi_id = $aplikasi->id;
                $lampiran->keterangan = $request['lampiran_keterangan'][$key];
                $lampiran->file = $store_as;

                $lampiran->save();
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
            'message' => 'Success add aplikasi',
            'results' => $aplikasi,
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
        $aplikasi = Aplikasi::with(['pemohon', 'kerabat', 'pasangan', 'usaha', 'keuangan', 'lampiran', 'verifikasi.user', 'survey.user', 'approval.user'])->findOrFail($id);

        return response()->json([
            'status' => true,
            'message' => 'Success fetch specific aplikasi',
            'results' => $aplikasi
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
        $aplikasi = Aplikasi::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'keterangan' => 'required|string',
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
                $aplikasi->keterangan = $request->keterangan;
                $aplikasi->status = 'Tolak';
                $aplikasi->update();
            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Failed update aplikasi',
                    'error' => $e->getMessage()
                ], 500);
            }
        
        DB::commit();
        
        return response()->json([
            'status' => true,
            'message' => 'Success update aplikasi',
            'results' => $aplikasi,
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
        //
    }

    public function picture($id, $filename)
    {
        $path = base_path().'/storage/app/public/lampiran/'.$id.'/'.$filename;
        return Response::download($path); 
    }
}
