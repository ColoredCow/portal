<?php

namespace App\Http\Controllers\Settings;

use App\Models\BankDetails;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BankDetailController extends Controller
{
    public function index()
    {
        $bankDetails = BankDetails::all();

        return view('settings.bank-details.index', compact('bankDetails'));
    }

    public function create()
    {
        return view('settings.bank-details.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'key' => 'required',
            'label' => 'required',
            'value' => 'required',
        ]);

        BankDetails::create($validatedData);

        return redirect()->route('settings.bank-details')
            ->with('success', 'Bank details created successfully.');
    }
}
