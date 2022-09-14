<?php

namespace Modules\Revenue\Services;

use Modules\Revenue\Entities\RevenueProceed;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RevenueProceedService
{
    public function index()
    {
        $revenueProceedData = RevenueProceed::orderby('name')->get();

        return $revenueProceedData;
    }

    public function store(Request $request)
    {
        $revenueProceed = new RevenueProceed;
        
        $revenueProceed->name = $request['name'];
        $revenueProceed->category = Str::slug($request['category']);
        $revenueProceed->currency = $request['currency'];
        $revenueProceed->amount = $request['amount'];
        $revenueProceed->recieved_at = $request['recieved_at'];
        $revenueProceed->notes = $request['notes'];
        $revenueProceed->save();
        
        return $revenueProceed;
    }

    public function show($id)
    {
        return view('revenue::index');
    }

    public function update(Request $request, $id)
    {
        $revenueProceed = RevenueProceed::find($id);

        $revenueProceed->name = $request['name'];
        $revenueProceed->category = Str::slug($request['category']);
        $revenueProceed->currency = $request['currency'];
        $revenueProceed->amount = $request['amount'];
        $revenueProceed->recieved_at = $request['recieved_at'];
        $revenueProceed->notes = $request['notes'];
        $revenueProceed->save();
        return $revenueProceed;
    }

    public function delete($id)
    {
        return RevenueProceed::find($id)->delete();
    }
}
