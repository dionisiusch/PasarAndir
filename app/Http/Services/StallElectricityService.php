<?php

namespace App\Http\Services;

use App\Model\StallElectricity;

class StallElectricityService
{
    public function showAllStallElectricities()
    {
        $stallElectricities = StallElectricity::all();

        return $stallElectricities;
    }

    public function createStallElectricity($data)
    {
        $stallElectricity = new StallElectricity([
            'stall_id' => $data->get('stall_id'),
            'electricity_id' => $data->get('electricity_id'),
            'meter_before' => $data->get('meter_before'),
            'meter_after' => $data->get('meter_after'),
            'price' => $data->get('price') //HARUSNYA GA GINI, NANTI DIBENERIN KALO UDAH MAU JADI
        ]);
        $stallElectricity->save();

        return $stallElectricity;
    }

    public function getStallElectricityById($id)
    {
        $stallElectricity = StallElectricity::find($id);
        
        return $stallElectricity;
    }

    public function updateStallElectricityById($data, $id)
    {
        $stallElectricity = StallElectricity::find($id);
        $stallElectricity->stall_id = $data->get('stall_id');
        $stallElectricity->electricity_id = $data->get('electricity_id');
        $stallElectricity->meter_before = $data->get('meter_before');
        $stallElectricity->meter_after = $data->get('meter_after');
        $stallElectricity->save();

        return $stallElectricity;
    }

    public function deleteStallElectricityById($id)
    {
        $stallElectricity = StallElectricity::find($id);
        $stallElectricity->delete();

        return $stallElectricity;
    }
}
