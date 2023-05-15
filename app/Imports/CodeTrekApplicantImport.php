<?php

namespace App\Imports;

use Carbon\Carbon;
use Modules\CodeTrek\Entities\CodeTrekApplicant;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CodeTrekApplicantImport  implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $startDate = Carbon::createFromFormat('d/m/Y', $row['start_date'])->format('Y-m-d');
            CodeTrekApplicant::create([
                'first_name' => $row['first_name'],
                'last_name' => $row['last_name'],
                'email' => $row['email'],
                'github_user_name' => $row['github_id'],
                'phone' => $row['phone_number'],
                'course' => $row['course'],
                'start_date' => $startDate,
                'graduation_year' => $row['graduation_year'],
                'university' => $row['university_name'],
            ]);
        }
    }
}
