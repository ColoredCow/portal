<?php

namespace Modules\CodeTrek\Services;

use Modules\CodeTrek\Entities\CodeTrekApplicant;



class CodeTrekService 
{
    
    public function getCodeTrekApplicants()
    {
        $applicants = CodeTrekApplicant::all();

        return ['applicants'=> $applicants];
    }

}
