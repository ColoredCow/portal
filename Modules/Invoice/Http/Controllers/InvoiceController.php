<?php

namespace Modules\Invoice\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Invoice\Contracts\InvoiceServiceContract;

class InvoiceController extends Controller
{
    protected $service;

    public function __construct(InvoiceServiceContract $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        $filters = $request->all();

        if (! $filters) {
            return redirect(route('invoice.index', $this->service->defaultFilters()));
        }

        return view('invoice::index', $this->service->index($filters));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('invoice::create', $this->service->create());
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $invoice = $this->service->store($request->all());

        return redirect(route('invoice.index'));
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('invoice::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('invoice::edit', $this->service->edit($id));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $this->service->update($request->all(), $id);

        return redirect(route('invoice.index'));
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        return $this->service->delete($id);
    }

    public function getInvoiceFile(Request $request, $invoiceID)
    {
        return $this->service->getInvoiceFile($invoiceID);
    }

    public function dashboard()
    {
        return $this->service->dashboard();
    }

    public function taxReport(Request $request)
    {
        $filters = $request->all();

        if (! $filters) {
            return redirect(route('invoice.tax-report', $this->service->defaultTaxReportFilters()));
        }

        return view('invoice::tax-report', $this->service->taxReport($filters));
    }

    public function taxReportExport(Request $request)
    {
        $filters = $request->all();

        return $this->service->taxReportExport($filters);
    }
}
