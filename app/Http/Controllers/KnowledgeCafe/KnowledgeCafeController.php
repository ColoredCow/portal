<?php

namespace App\Http\Controllers\KnowledgeCafe;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class KnowledgeCafeController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return view('knowledgecafe.index');
    }

}
