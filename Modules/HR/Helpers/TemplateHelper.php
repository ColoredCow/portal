<?php

namespace Modules\HR\Helpers;

class TemplateHelper
{
    public static function parse(string $content, array $values)
    {
        $parsedContent = $content;

        $availableVariables = [
            'interview_slot_link',
            'applicant_name',
            'job_title',
            'interview_time',
        ];

        foreach ($availableVariables as $variable) {
            $search = "|*$variable*|";
            $replace = $values[$variable] ?? '';
            $parsedContent = str_replace($search, $replace, $parsedContent);
        }

        return $parsedContent;
    }
}
