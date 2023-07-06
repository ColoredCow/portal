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

        $applicantsData = CodeTrekApplicant::whereIn('status', ['active', 'inactive', 'completed'])
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
        // Mail::queue(new CodetrekMailApplicant($data)); This line will be uncommented in the future when the use of the codeTrek module starts in the proper way.
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
        $applicant->centre_id = $data['centre'] ?? null;
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
        $applicationRound->latest_round_name = 'level-1';
        $applicationRound->feedback = null;
        $applicationRound->start_date = $data['start_date'];
        $applicationRound->save();
    }

    public function getData($type, $filters, $request)
    {
        if ($type == 'codetrek-application') {
            $application_start_date = $request->application_start_date ?? today()->subYears(4);
            $application_end_date = $request->application_end_date ?? today();
            $applicantChartData = CodeTrekApplicant::select(\DB::Raw('DATE(created_at) as date, COUNT(*) as count'))
                ->whereDate('start_date', '>=', $application_start_date)
                ->whereDate('start_date', '<=', $application_end_date)
                ->groupBy('date')
                ->get();

            $dates = $applicantChartData->pluck('date')->toArray();
            $counts = $applicantChartData->pluck('count')->toArray();
            $chartData = [
                'dates' => $dates,
                'counts' => $counts,
            ];
            $reportApplicantData = json_encode($chartData);

            return $reportApplicantData;
        }
    }
}
