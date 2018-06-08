<?php

namespace App\Http\Controllers\KnowledgeCafe;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class KnowledgeCafeController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
       return view('knowledgecafe.index');
    }

}
