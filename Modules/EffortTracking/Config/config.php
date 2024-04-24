<?php

return [
    'name' => 'EffortTracking',
    'minimum_expected_hours' => 8,
    'update_date_count_after_time' => '22:00:00',
    'columns_name' => [
        'team_member_name' => 'team member name',
        'working_days' => 'working days',
        'start_date' => 'start date',
        'end_date' => 'end date',
        'actual_effort' => 'actual effort',
        'billable_effort' => 'billable effort',
    ],
    'default_last_column_in_effort_sheet' => 'H',
    'default_start_column_in_effort_sheet' => 'C',
    'default_monthly_approved_pipeline_column_in_effort_sheet' => 'B6',
];
