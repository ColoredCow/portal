<?php

namespace Modules\Invoice\Services;

use Illuminate\Support\Arr;
use Modules\Invoice\Entities\Invoice;
use Illuminate\Support\Facades\Storage;
use Modules\Client\Contracts\ClientServiceContract;
use Modules\Invoice\Contracts\InvoiceServiceContract;
use Modules\Invoice\Contracts\CurrencyServiceContract;

class InvoiceService implements InvoiceServiceContract
{
    public function index($filters = [])
    {
        $query = Invoice::query();

        if ($year = Arr::get($filters, 'year', '')) {
            $query->year($year);
        }

        if ($month = Arr::get($filters, 'month', '')) {
            $query->month($month);
        }

        if ($status = Arr::get($filters, 'status', '')) {
            $query->status($status);
        }

        $invoices = $query->get();

        return [
            'invoices' => $invoices,
            'clients' => $this->getClientsForInvoice(),
            'currencyService' => $this->currencyService(),
            'totalReceivableAmount' => $this->getTotalReceivableAmountInINR($invoices)
        ];
    }

    public function getTotalReceivableAmountInINR($invoices)
    {
        $totalAmount = 0;
        $currentRates = $this->currencyService()->getCurrentRatesInINR();

        foreach ($invoices as $invoice) {
            if ($invoice->isAmountInINR()) {
                $totalAmount += $invoice->amount;
                continue;
            }

            $invoiceAmount = $currentRates * $invoice->amount;
            $totalAmount += $invoiceAmount;
        }

        return round($totalAmount, 2);
    }

    public function defaultFilters()
    {
        return [
            'year' => now()->format('Y'),
            'month' => now()->format('m'),
            'status' => 'sent'
        ];
    }

    public function create()
    {
        return ['clients' => $this->getClientsForInvoice()];
    }

    public function store($data)
    {
        $data['receivable_date'] = $data['due_on'];
        $invoice = Invoice::create($data);
        $this->saveInvoiceFile($invoice, $data['invoice_file']);
        return $invoice;
    }

    public function update($data, $id)
    {
        $invoice = Invoice::find($id);
        $invoice->update($data);
        if (isset($data['invoice_file']) and $data['invoice_file']) {
            $this->saveInvoiceFile($invoice, $data['invoice_file']);
        }

        return $invoice;
    }

    public function edit($id)
    {
        return [
            'invoice' => Invoice::find($id),
            'clients' => $this->getClientsForInvoice()
        ];
    }

    public function delete($invoiceID)
    {
        return Invoice::find($invoiceID)->delete();
    }

    public function saveInvoiceFile($invoice, $file)
    {
        $folder = '/invoice/' . date('Y') . '/' . date('m');
        $fileName = $file->getClientOriginalName();
        $file = Storage::putFileAs($folder, $file, $fileName, ['visibility' => 'public']);
        $invoice->update(['file_path' => $file]);
    }

    public function getInvoiceFile($invoiceID)
    {
        $invoice = Invoice::find($invoiceID);
        return Storage::download($invoice->file_path, basename($invoice->file_path), [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline;'
        ]);
    }

    public function getClientsForInvoice()
    {
        return app(ClientServiceContract::class)->getAll();
    }

    public function currencyService()
    {
        return app(CurrencyServiceContract::class);
    }

    public function dashboard()
    {
        return Invoice::status('sent')->get();
    }
}
