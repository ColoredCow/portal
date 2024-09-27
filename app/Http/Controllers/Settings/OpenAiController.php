<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class OpenAiController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        return view('settings.openai-instruction.index');
    }
}
