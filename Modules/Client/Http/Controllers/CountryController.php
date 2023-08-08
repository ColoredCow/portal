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
}
