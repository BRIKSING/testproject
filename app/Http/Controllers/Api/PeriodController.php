<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Period;

class PeriodController extends Controller
{
    public function getPeriodList(Request $request)
    {
        $periods = Period::get();
        $newPeriods = [];

        foreach ($periods as $period) {
            $newPeriods[] = [$period->id => $period->name];
        }

        return ['periods' => $newPeriods];
    }

    public function getPeriodNameById(Request $request)
    {
        $period = Period::where('id', $request->id)->first();
        if($period)
          return $period->name;
        else
          return [
            'error' => 'Period is not found!'
          ];


    }
}
