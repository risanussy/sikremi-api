<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;


use App\Aplikasi;

class AnalyticController extends Controller
{
    public function performance()
    {
        $year = date('Y');

        $aplikasi = Aplikasi::select(
            DB::raw('COUNT(id) AS totalAplikasiKey'),
            DB::raw('MONTH(tgl_aplikasi) AS monthKey'),
        )
        ->whereYear('tgl_aplikasi', '=', $year)
        ->groupBy('monthKey')
        ->get();

        $month_aplikasi_array = ['Jan', 'Feb', 'Mar','Apr', 'Mei', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $total_aplikasi_array = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

        foreach($aplikasi as $key){
            $index = $key->monthKey - 1;
            $total_aplikasi_array[$index] = $key->totalAplikasiKey;
        }

        $results['year'] = $year;
        $results['aplikasi']['month'] = $month_aplikasi_array;
        $results['aplikasi']['total'] = $total_aplikasi_array;

        return response()->json([
            'status' => true,
            'message' => 'Success fetch performance analytics',
            'results' => $results
        ]);
    }
}
