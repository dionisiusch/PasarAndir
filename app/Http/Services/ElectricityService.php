<?php

namespace App\Http\Services;

use App\Model\Electricity;
use App\Model\PowerMeter;
use DB;

class ElectricityService
{
    public function showAllElectricities()
    {
        $electricities = Electricity::all();

        return $electricities;
    }

    public function createElectricity($data)
    {
        $electricity = new Electricity([
            'power_meter_id' => $data->get('power_meter_id'),
            'name' => $data->get('name')
        ]);
        $electricity->save();

        return $electricity;
    }

    public function getElectricityById($id)
    {
        $electricity = Electricity::find($id);
        
        return $electricity;
    }

    public function updateElectricityById($data, $id)
    {
        $electricity = Electricity::find($id);
        $electricity->power_meter_id = $data->get('power_meter_id');
        $electricity->name = $data->get('name');
        $electricity->save();

        return $electricity;
    }

    public function deleteElectricityById($id)
    {
        try {
            $electricity = Electricity::find($id);
            $electricity->delete();

            return $electricity;
        } catch (Exception $e) {
            console.log($e);
            return null;
        }
    }

    public function searchElectricity($query)
    {
        $powerMeterId = PowerMeter::where('power_meter', 'like', '%'.$query.'%')
            ->orWhere('kva_price', 'like', '%'.$query.'%')
            ->orWhere('kwh_price', 'like', '%'.$query.'%')
            ->pluck('id');

        return Electricity::where('name', 'like', '%'.$query.'%')
            ->orWhereIn('power_meter_id', $powerMeterId)
            ->get();
    }
}
