<?php

namespace App\Http\Services;

use App\Model\PowerMeter;
use DB;

class PowerMeterService
{
    public function showAllPowerMeters()
    {
        $powerMeters = PowerMeter::all();

        return $powerMeters;
    }

    public function createPowerMeter($data, $kvaPrice, $kwhPrice)
    {
        $powerMeter = new PowerMeter([
            'power_meter' => $data->get('power_meter'),
            'kva_price' => $kvaPrice,
            'kwh_price' => $kwhPrice
        ]);
        $powerMeter->save();

        return $powerMeter;
    }

    public function getPowerMeterById($id)
    {
        $powerMeter = PowerMeter::find($id);
        
        return $powerMeter;
    }

    public function updatePowerMeterById($data, $id, $kvaPrice, $kwhPrice)
    {
        $powerMeter = PowerMeter::find($id);
        $powerMeter->power_meter = $data->get('power_meter');
        $powerMeter->kva_price = $kvaPrice;
        $powerMeter->kwh_price = $kwhPrice;
        $powerMeter->save();

        return $powerMeter;
    }

    public function deletePowerMeterById($id)
    {
        try {
            $powerMeter = PowerMeter::find($id);
            $powerMeter->delete();

            return $powerMeter;
        } catch (Exception $e) {
            console.log($e);
            return null;
        }
    }

    public function searchPowerMeter($query)
    {
        return PowerMeter::where('power_meter', 'like', '%'.$query.'%')
            ->orWhere('kva_price', 'like', '%'.$query.'%')
            ->orWhere('kwh_price', 'like', '%'.$query.'%')
            ->get();
    }
}
