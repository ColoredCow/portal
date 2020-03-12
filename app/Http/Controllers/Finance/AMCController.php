<?php

namespace App\Http\Controllers\Finance;

use App\Models\Client;
use App\Helpers\DateHelper;
use App\Helpers\FileHelper;
use App\Models\Finance\Invoice;
use Illuminate\Http\UploadedFile;
use App\Models\ProjectStageBilling;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Http\Requests\Finance\InvoiceRequest;

class AMCController extends Controller
{


    public function __construct()
    {
        $this->authorizeResource(Invoice::class);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
       return view('finance.amc.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('finance.amc.create')->with('clients', Client::getInvoicableClients());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param App\Http\Requests\Finance\PaymentRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store()
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Finance\Payment  $payment
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        return view('finance.amc.edit');
    }

     /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Finance\PaymentRequest  $request
     * @param  \App\Models\Finance\Payment  $payment
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update()
    {
           
    }
}
