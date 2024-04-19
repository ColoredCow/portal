<?php

namespace Modules\Client\Http\Controllers;

use Modules\Client\Entities\Country;
use Modules\Client\Http\Requests\CountryRequest;

class CountryController extends ModuleBaseController
{
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

        $country->name = request('name');
        $country->initials = request('initials');
        $country->currency = request('currency');
        $country->currency_symbol = request('currency_symbol');

        $country->update();

        return redirect()->back();
    }
}
