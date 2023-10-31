<?php
namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class KodeHelper {

    public static function dateCode($initial, $table, $primary){
        $date = date('y-m');
        $q = DB::table($table)->select(DB::raw('MAX(RIGHT('.$primary.', 5)) as kd_max'))->where($primary, 'like', '%'.$date.'%');

        if($q->count() > 0)
        {
            foreach($q->get() as $k)
            {
                $tmp = (int) substr($k->kd_max, -3, 3);
                $no = $tmp + 1;
                $kd = $initial.'-'.$date.'-'.sprintf("%03s", $no);
            }
        }
        else
        {
            $kd = $initial.'-'.$date.'-'."001";
        }

        return $kd;
    }

    public static function numberCode($initial, $table, $primary){
        $date = date('y-m');
        $q = DB::table($table)->select(DB::raw('MAX(RIGHT('.$primary.', 5)) as kd_max'));

        if($q->count()>0)
        {
            foreach($q->get() as $k)
            {
                $tmp = ((int)$k->kd_max)+1;
                $kd = $initial.'-'.sprintf("%05s", $tmp);
            }
        }
        else
        {
            $kd = $initial.'-'."00001";
        }

        return $kd;
    }



}