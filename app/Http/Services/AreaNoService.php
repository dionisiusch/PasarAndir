<?php

namespace App\Http\Services;

use App\Model\AreaNo;

class AreaNoService
{
    public function showAllAreaNos()
    {
        $areaNos = AreaNo::all();

        return $areaNos;
    }

    public function createAreaNo($data)
    {
        $areaNo = new AreaNo([
            'area_id' => $data->get('area_id'),
            'no_id' => $data->get('no_id')
        ]);
        $areaNo->save();

        return $areaNo;
    }

    public function getAreaNoById($id)
    {
        $areaNo = AreaNo::find($id);
        return $areaNo;
    }

    public function updateAreaNoById($data, $id)
    {
        $areaNo = AreaNo::find($id);
        $areaNo->area_id = $data->get('area_id');
        $areaNo->no_id = $data->get('no_id');
        $areaNo->save();

        return $areaNo;
    }

    public function deleteAreaNoById($id)
    {
        $areaNo = AreaNo::find($id);
        $areaNo->delete();

        return $areaNo;
    }
}
