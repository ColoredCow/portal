<?php

namespace Modules\User\Services;

abstract class ExtendUserModel
{
    protected $model;

    public function setModelContext($model)
    {
        $this->model = $model;
    }
}
