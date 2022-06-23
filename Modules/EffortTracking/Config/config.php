<?php

return [
    'name' => 'EffortTracking',
    'minimum_expected_hours' => 8,
    'update_date_count_after_time' => '20:00:00',
    'columns_name' => [
        'team_member_name' => 'team member name',
        'start_date' => 'start date',
        'end_date' => 'end date',
        'actual_effort' => 'actual effort',
        'billable_effort' => 'billable effort',
    ],
    'default_last_column_in_effort_sheet' => 'G',
    'default_start_column_in_effort_sheet' => 'C',
];
