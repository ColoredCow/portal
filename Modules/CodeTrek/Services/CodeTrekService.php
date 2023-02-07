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
    public function store($data)
    {

        $applicant = new CodeTrekApplicant();

        $applicant->first_name = $data['first_name'];
        $applicant->last_name = $data['last_name'];
        $applicant->email = $data['email_id'];
        $applicant->phone = $data['phone'];
        $applicant->github_user_name = $data['github_username'];
        $applicant->course = $data['course'];
        $applicant->start_date = $data['start_date'];
        $applicant->graduation_year = $data['graduation_year'];
        $applicant->university = $data['university_name'];
        $applicant->save();

        return $applicant;
    }
}
