<?php

namespace Modules\CodeTrek\Services;

use Modules\CodeTrek\Entities\CodeTrekApplicant;
use Modules\CodeTrek\Entities\CodeTrekApplicantRoundDetail;
use Illuminate\Support\Facades\Mail;
use  Modules\CodeTrek\Emails\CodetrekMailApplicant;

class CodeTrekService
{
    public function getCodeTrekApplicants($data = [])
    {
        $search = $data['name'] ?? null;
        $status = $data['status'] ?? 'active';
        $centre = $data['centre'] ?? null;
        $sort = $data['order'] ?? null;
        $query = CodeTrekApplicant::where('status', $status);
        $applicants = null;

        if ($centre) {
            $applicants = $query->where('centre_id', $centre);
        }
        if ($sort == 'date') {
            $applicants = $query->orderBy('start_date', 'desc');
        } else {
            $applicants = $query->orderBy('first_name');
        }
        $applicants = $query->when($search, function ($query) use ($search) {
            return $query->whereRaw("CONCAT(first_name, ' ', last_name) LIKE '%$search%'");
        })
        ->paginate(config('constants.pagination_size'))
        ->appends(request()->except('page'));

        $applicantsData = CodeTrekApplicant::whereIn('status', ['active', 'inactive', 'completed'])->with('mentor')
        ->when($search, function ($query) use ($search) {
            return $query->whereRaw("CONCAT(first_name, ' ', last_name) LIKE '%$search%'");
        })
        ->groupBy('status')
        ->selectRaw('count(status) as total, status')
        ->get();

        $statusCounts = [
            'active' => 0,
            'inactive' => 0,
            'completed' => 0
        ];
        foreach ($applicantsData as $data) {
            $statusCounts[$data->status] = $data->total;
        }

        return [
            'applicants' => $applicants,
            'applicantsData' => $applicantsData,
            'statusCounts' => $statusCounts
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
        $applicant->mentor_id = $data['mentorId'];
        $applicant->domain_name = $data['domain'];
        $applicant->latest_round_name = "level-1";
        // Mail::queue(new CodetrekMailApplicant($data)); This line will be uncommented in the future when the use of the codeTrek module starts in the proper way.
        $applicant->save();

        $this->moveApplicantToRoundOne($applicant, $data);

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
        $applicant->centre_id = $data['centre'] ?? null;
        $applicant->mentor_id = $data['mentorId'] ?? null;
        $applicant->domain_name = $data['domian_name'];
        $applicant->save();

        return $applicant;
    }

    public function evaluate(CodeTrekApplicant $codeTrekApplicant)
    {
        $roundDetails = CodeTrekApplicantRoundDetail::where('applicant_id', $codeTrekApplicant->id)->get();

        return $roundDetails;
    }

    public function moveApplicantToRoundOne($applicant, $data)
    {
        $applicationRound = new CodeTrekApplicantRoundDetail();
        $applicationRound->applicant_id = $applicant->id;
        $applicationRound->latest_round_name = 'level-1';
        $applicationRound->feedback = null;
        $applicationRound->start_date = $data['start_date'];
        $applicationRound->save();
    }
}
