<?php

namespace Modules\Revenue\Http\Controllers;

use Modules\Revenue\Entities\Revenue;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class RevenueController extends Controller
{
    public function index()
    {
        $revenueData = Revenue::orderby('name')->get();

        return view('revenue::index')->with('revenues', $revenueData);
    }

    public function store(Request $request)
    {
        $revenue = new Revenue;
        $revenue->name = $request->input('name');
        $revenue->category = $request->input('category');
        $revenue->currency = $request->input('currency');
        $revenue->amount = $request->input('amount');
        $revenue->recieved_at = $request->input('recieved_at');
        $revenue->notes = $request->input('notes');
        $revenue->save();

        return redirect()->route('revenue.index')->with('status', "$revenue->name created successfully!!");
    }

    public function show($id)
    {
        return view('revenue::index');
    }

    public function update(Request $request, $id)
    {
        $revenue = Revenue::find($id);

        $revenue->name = $request->input('name');
        $revenue->category = $request->input('category');
        $revenue->currency = $request->input('currency');
        $revenue->amount = $request->input('amount');
        $revenue->recieved_at = $request->input('recieved_at');
        $revenue->notes = $request->input('notes');
        $revenue->save();

        return redirect()->route('revenue.index')->with('status', "$revenue->name updated successfully!!");
    }

    public function delete($id)
    {
        $revenue = Revenue::find($id);
        $delete = $revenue->delete();

        return redirect()->route('revenue.index')->with('status', "$revenue->name deleted successfully!!");
    }
}
