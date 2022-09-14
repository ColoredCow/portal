<?php

namespace Modules\Revenue\Services;

use Modules\Revenue\Entities\RevenueProceed;
use Illuminate\Http\Request;

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
        $revenueProceed->name = $request->input('name');
        $revenueProceed->category = $request->input('category');
        $revenueProceed->currency = $request->input('currency');
        $revenueProceed->amount = $request->input('amount');
        $revenueProceed->recieved_at = $request->input('recieved_at');
        $revenueProceed->notes = $request->input('notes');
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

        $revenueProceed->name = $request->input('name');
        $revenueProceed->category = $request->input('category');
        $revenueProceed->currency = $request->input('currency');
        $revenueProceed->amount = $request->input('amount');
        $revenueProceed->recieved_at = $request->input('recieved_at');
        $revenueProceed->notes = $request->input('notes');
        $revenueProceed->save();

        return $revenueProceed;
    }

    public function delete($id)
    {
        return RevenueProceed::find($id)->delete();
    }
}
