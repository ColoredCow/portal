<?php

namespace App\Http\Controllers\Finance;

use App\Models\Client;
use App\Models\Finance\AMC;
use Illuminate\Http\Request;
use App\Models\Finance\Invoice;
use App\Http\Controllers\Controller;
use App\Services\Finance\AMCService;
use Illuminate\Support\Facades\Storage;

class AMCController extends Controller
{
    protected $service;
    
    public function __construct(AMCService $aMCService)
    {
       // $this->authorizeResource(Invoice::class);
        $this->service = $aMCService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('finance.amc.index')->with('amcs', AMC::all());
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
    public function store(Request $request)
    {
        $data = $request->all();
        $amc = $this->service->create($data);
        return redirect()->route('amc.edit', $amc)->with('status', 'AMC created successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Finance\Payment  $payment
     * @return \Illuminate\View\View
     */
    public function edit(Request $request, AMC $amc)
    {
        return view('finance.amc.edit')->with('clients', Client::getInvoicableClients())
            ->with('amc', $amc);
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
