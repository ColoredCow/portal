<?php

namespace App\Http\Controllers;

use Modules\User\Entities\User;
use Illuminate\Support\Facades\Auth;

class UserProjectController extends Controller
{
    public function index()
    {
        $userId = request('user_id', null);
        $user = $userId ? User::find($userId) : Auth::user()->projects;

        return $user;
    }
}
