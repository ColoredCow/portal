<?php

namespace Modules\CodeTrek\Services;

use Modules\CodeTrek\Entities\CodeTrekApplicant;
use Modules\CodeTrek\Entities\CodeTrekApplicantRoundDetail;

class CodeTrekService
{
    public function getCodeTrekApplicants($data = [])
    {
        $search = $data['name'] ?? null;
        $status = $data['status'] ?? 'active';
        $centre = $data['centre'] ?? null;
        $query = CodeTrekApplicant::where('status', $status)->orderBy('first_name');
        $applicants = null;
        if ($centre) {
            $applicants = $query->where('centre_id', $centre);
        }
        $applicants = $query->when($search, function ($query) use ($search) {
            return $query->whereRaw("CONCAT(first_name, ' ', last_name) LIKE '%$search%'");
        })
        ->paginate(config('constants.pagination_size'))
        ->appends(request()->except('page'));

        $activeCount = CodeTrekApplicant::where('status', 'active')->count();
        $inactiveCount = CodeTrekApplicant::where('status', 'inactive')->count();
        $completedCount = CodeTrekApplicant::where('status', 'completed')->count();

        return [
            'applicants' => $applicants,
            'activeCount' => $activeCount,
            'inactiveCount' => $inactiveCount,
            'completedCount' => $completedCount,
        ];
    }
    public function store($data)
    {
        $applicant = new CodeTrekApplicant();

        $applicant->first_name = $data['first_name'];
        $applicant->last_name = $data['last_name'];
        $applicant->email = $data['email_id'];
        $applicant->phone = $data['phone'] ?? null;
        $applicant->github_user_name = $data['github_username'];
        $applicant->course = $data['course'] ?? null;
        $applicant->start_date = $data['start_date'];
        $applicant->graduation_year = $data['graduation_year'] ?? null;
        $applicant->university = $data['university_name'] ?? null;
        $applicant->centre_id = $data['centre'];
        $applicant->save();

        $this->moveApplicantToRound($applicant, $data);

        return $applicant;
    }
    public function edit($codeTrekApplicant)
    {
        $codeTrekApplicant = CodeTrekApplicant::find($codeTrekApplicant->id);

        return $codeTrekApplicant;
    }
    public function update($data, $codeTrekApplicant)
    {
        $applicant = CodeTrekApplicant::findOrFail($codeTrekApplicant->id);
        $applicant->first_name = $data['first_name'];
        $applicant->last_name = $data['last_name'];
        $applicant->email = $data['email_id'];
        $applicant->phone = $data['phone'] ?? null;
        $applicant->github_user_name = $data['github_username'];
        $applicant->course = $data['course'] ?? null;
        $applicant->start_date = $data['start_date'];
        $applicant->graduation_year = $data['graduation_year'] ?? null;
        $applicant->university = $data['university_name'] ?? null;
        $applicant->save();

        return $applicant;
    }

    public function evaluate(CodeTrekApplicant $codeTrekApplicant)
    {
        $roundDetails = CodeTrekApplicantRoundDetail::where('applicant_id', $codeTrekApplicant->id)->get();

        return $roundDetails;
    }

    public function moveApplicantToRound($applicant, $data)
    {
        $applicationRound = new CodeTrekApplicantRoundDetail();
        $applicationRound->applicant_id = $applicant->id;
        $applicationRound->round_name = 'level-1';
        $applicationRound->feedback = null;
        $applicationRound->start_date = $data['start_date'];
        $applicationRound->save();
    }
}
