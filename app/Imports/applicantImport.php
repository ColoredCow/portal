<?php

namespace App\Imports;

use App\Models\Applicant;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ApplicantImport implements ToCollection,WithHeadingRow
{
    public function collection(Collection $rows)
    {

        foreach ($rows as $row) {

            Applicant::create([
                'first_name' => $row['first_name'],
                'last_name' => $row['lastname'],
                'email_id' => $row['email'],
                'github_username' => $row['github_id'],
                'phone' => $row['phone_number'],
                'course' => $row['course'],
                'start_date' => $row['start_date'],
                'graduation_year' => $row['graduation_year'],
                'university_name' => $row['university_name'],
            ]);
        }
    }
}
