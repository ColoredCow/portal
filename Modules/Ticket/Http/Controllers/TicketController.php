<?php

namespace Modules\Ticket\Http\Controllers;

use Illuminate\Routing\Controller;

class TicketController extends Controller
{
    public function index()
    {
        return view('ticket::index');
    }
}
