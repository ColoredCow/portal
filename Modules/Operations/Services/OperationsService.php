<?php

namespace Modules\operations\Services;
use Modules\Operations\Entities\office_location;



class OperationsService
{
    public function store($data)
    {
        $office_location = new office_location();

        $office_location->centre_name = $data['centre_name'];
        $office_location->centre_head_id = $data['centre_head'];
        $office_location->capacity = $data['capacity'];
        $office_location->current_people_count = $data['current_people_count'];
        $office_location->save();
        return $office_location;
    }  
}
