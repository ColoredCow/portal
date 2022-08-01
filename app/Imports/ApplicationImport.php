<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Modules\HR\Contracts\ApplicationServiceContract;

class ApplicationImport implements ToCollection, WithHeadingRow
{
    protected $job;
    protected $service;

    public function __construct($job)
    {
        $this->job = $job;
        $this->service = resolve(ApplicationServiceContract::class);
    }

    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        $rows = $collection->reject(function ($row) {
            return $row->filter()->isNotEmpty() == false;
        });

        foreach ($rows as $row) {
            $data = [];
            $data['hr_job_id'] = $this->job->id;
            $data['job_title'] = $this->job->title;
            $data['first_name'] = $row['first_name'];
            $data['last_name'] = $row['last_name'];
            $data['email'] = $row['email'];
            $data['phone'] = $row['phone'];
            $data['college'] = $row['college'];
            $data['graduation_year'] = $row['graduation_year'];
            $data['course'] = $row['course'];
            $data['linkedin'] = $row['linkedin'];
            $data['resume'] = $row['resume_url'] ?? 'abc';
            $data['form_data'] = [
                'Why Should We Pick You?' => $row['reason_for_eligibility']
            ];
            $data['hr_channel_id'] = $row['hr_channel_id'];

            $this->service->saveApplication($data);
        }
    }
}
