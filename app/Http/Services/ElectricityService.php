<?php

namespace App\Http\Services;

use App\Model\Electricity;
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
            'name' => $data->get('name'),
            'power_meter' => $data->get('power_meter'),
            'kva_price' => $data->get('kva_price'),
            'kwh_price' => $data->get('kwh_price')
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
        $electricity->name = $data->get('name');
        $electricity->power_meter = $data->get('power_meter');
        $electricity->kva_price = $data->get('kva_price');
        $electricity->kwh_price = $data->get('kwh_price');
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
        return DB::table('electricities')
            ->where('name', 'like', '%'.$query.'%')
            ->orWhere('type', 'like', '%'.$query.'%')
            ->orWhere('value', 'like', '%'.$query.'%')
            ->whereNull('deleted_at')
            ->get();
    }
}
