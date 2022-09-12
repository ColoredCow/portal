<?php

namespace Modules\Revenue\Http\Controllers;

use Modules\Revenue\Entities\Revenue;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Modules\Revenue\Http\Requests\RevenueRequest;
use Illuminate\Routing\Controller;

class RevenueController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $revenueData = Revenue::orderby('name')->get();

        return view('revenue::index')->with('revenues', $revenueData);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $revenue = new Revenue;
        $revenue->name =$request->input('name');
        $revenue->category =$request->input('category');
        $revenue->currency =$request->input('currency');
        $revenue->amount =$request->input('amount');
        $revenue->recieved_at =$request->input('recieved_at');
        $revenue->notes =$request->input('notes');
        $revenue->save();

        return redirect()->route('revenue.index')->with('status', "$revenue->name created successfully!!");
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('revenue::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $revenue = Revenue::find($id);

        $revenue->name =$request->input('name');
        $revenue->category =$request->input('category');
        $revenue->currency =$request->input('currency');
        $revenue->amount =$request->input('amount');
        $revenue->recieved_at =$request->input('recieved_at');
        $revenue->notes =$request->input('notes');
        $revenue->save();

        return redirect()->route('revenue.index')->with('status', "$revenue->name updated successfully!!");
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function delete($id)
    {
        $revenue = Revenue::find($id);
        $delete = $revenue->delete();

        return redirect()->route('revenue.index')->with('status', "$revenue->name deleted successfully!!");
    }
}
