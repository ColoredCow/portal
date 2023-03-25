<?php

namespace Modules\Ticket\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class TicketController extends Controller
{
    public function index()
    {
        return view('ticket::index');
    }
}
