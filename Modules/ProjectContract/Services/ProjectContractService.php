<?php

namespace Modules\ProjectContract\Services;

use Modules\Project\Contracts\ProjectServiceContract;

class ProjectContractService implements ProjectServiceContract
{
    public function create()
    {
        return $this->getClients();
    }
}
