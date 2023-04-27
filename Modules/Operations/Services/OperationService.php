<?php

namespace Modules\operations\Services;

use Modules\Operations\Entities\OfficeLocation;

class OperationService
{
    public function store($data)
    {
        $centre = new OfficeLocation();

        $centre->centre_name = $data['centre_name'];
        $centre->centre_head_id = $data['centre_head'];
        $centre->capacity = $data['capacity'];
        $centre->current_people_count = $data['current_people_count'];
        $centre->save();

        return $centre;
    }

    public function update($data, $id)
    {
        $centre = OfficeLocation::findOrFail($id);
        $centre->centre_name = $data['centre_name'];
        $centre->centre_head_id = $data['centre_head'];
        $centre->capacity = $data['capacity'];
        $centre->current_people_count = $data['current_people_count'];
        $centre->save();

        return $centre;
    }
}
