<?php

namespace Modules\operations\Services;

use Modules\operations\Entities\office_location;

class OperationsService
{
    public function store($data)
    {
        $centre = new office_location();

        $centre->centre_name = $data['centre_name'];
        $centre->centre_head_id = $data['centre_head'];
        $centre->capacity = $data['capacity'];
        $centre->current_people_count = $data['current_people_count'];
        $centre->save();
        return $centre;
    }  
}