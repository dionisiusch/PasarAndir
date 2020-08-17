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
            'type' => $data->get('type'),
            'value' => $data->get('value'),
            'price' => $data->get('price')
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
        $electricity->type = $data->get('type');
        $electricity->value = $data->get('value');
        $electricity->price = $data->get('price');
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
            ->get();
    }
}
