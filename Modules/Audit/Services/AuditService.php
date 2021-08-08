<?php

namespace Modules\Audit\Services;

class AuditService
{
    public static function index(array $filters)
    {
        $query->get();

        return $query->latest()->paginate(config('user.paginate'));
    }
}
