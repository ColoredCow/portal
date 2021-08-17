<?php

namespace Modules\User\Services;

use Illuminate\Http\Response;
use Modules\User\Contracts\ProfileServiceContract;

class ProfileService implements ProfileServiceContract
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $section = request()->input('section', 'basic-details');

        return ['user' => $user, 'section' => $section];
    }
}
