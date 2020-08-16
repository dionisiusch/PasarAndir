<?php

namespace App\Http\Services;

use App\Model\Electricity;

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
        $electricity = Electricity::find($id);
        $electricity->delete();

        return $electricity;
    }
}
