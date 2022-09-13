<?php

namespace Modules\Revenue\Services;
use Modules\Revenue\Entities\RevenueProceed;
use Illuminate\Http\Request;

class RevenueProceedService
{
    public function index()
    {
        $revenueData = RevenueProceed::orderby('name')->get();

        return ($revenueData);
    }

    public function store(Request $request)
    {
        $revenue = new RevenueProceed;
        $revenue->name = $request->input('name');
        $revenue->category = $request->input('category');
        $revenue->currency = $request->input('currency');
        $revenue->amount = $request->input('amount');
        $revenue->recieved_at = $request->input('recieved_at');
        $revenue->notes = $request->input('notes');
        $revenue->save();

        return $revenue;
    }

    public function show($id)
    {
        return view('revenue::index');
    }

    public function update(Request $request, $id)
    {
        $revenue = RevenueProceed::find($id);

        $revenue->name = $request->input('name');
        $revenue->category = $request->input('category');
        $revenue->currency = $request->input('currency');
        $revenue->amount = $request->input('amount');
        $revenue->recieved_at = $request->input('recieved_at');
        $revenue->notes = $request->input('notes');
        $revenue->save();

        return $revenue;
    }

    public function delete($id)
    {
        return RevenueProceed::find($id)->delete();
    }
}
