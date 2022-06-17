<?php

namespace Modules\Payment\Http\Controllers;

use Illuminate\Routing\Controller;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('payment::index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Show the specified resource.
     * @param int $id
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     */
    public function edit($id)
    {
    }

    public function transactionIndex()
    {
        return view('payment::transactionIndex');
    }

    public function expense()
    {
        return view('payment::expense');
    }

    public function revenue()
    {
        return view('payment::revenue');
    }
}
