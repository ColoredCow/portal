<?php

namespace Modules\Client\Http\Controllers;

use Modules\Client\Entities\Country;
use Modules\Client\Http\Requests\CountryRequest;

class CountryController extends ModuleBaseController
{
    protected $service;
    public function store(CountryRequest $request)
    {
        $validated = $request->validated();
        Country::create($validated);

        return redirect()->back()->with('status', 'Country saved successfully!');
    }
    public function index()
    {
        $countryDetails = Country::all();

        return view('settings.country-details', compact('countryDetails'));
    }
    public function destroy(Country $request, $id)
    {
        $country = Country::findOrFail($id);
        $country->delete();

        return redirect()->back()->with('status', 'Country deleted successfully!');
    }
    public function edit($id)
    {
        $country = Country::find($id);

        $previousValues = [
            'name' => $country->name,
            'initials' => $country->initials,
            'currency' => $country->currency,
            'currency_symbol' => $country->currency_symbol,
        ];

        $requestData = request()->only(['name', 'initials', 'currency', 'currency_symbol']);

        if (empty($requestData['name'])) {
            $country->name = $previousValues['name'];
        } else {
            $country->name = request('name');
        }

        if (empty($requestData['initials'])) {
            $country->initials = $previousValues['initials'];
        } else {
            $country->initials = request('initials');
        }

        if (empty($requestData['currency'])) {
            $country->currency = $previousValues['currency'];
        } else {
            $country->currency = request('currency');
        }

        if (empty($requestData['currency_symbol'])) {
            $country->currency_symbol = $previousValues['currency_symbol'];
        } else {
            $country->currency_symbol = request('currency_symbol');
        }

        $country->update();

        return redirect()->back();
    }
}
