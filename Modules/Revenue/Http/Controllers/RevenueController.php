<?php

namespace Modules\Revenue\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Modules\Revenue\Entities\Revenue;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Modules\Revenue\Http\Requests\RevenueRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controller;

class RevenueController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $revenueData = DB::table('revenue')->get()->toArray();

        return view('revenue::index')->with('revenues', $revenueData);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('revenue::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $revenue = new Revenue();$revenue->name = $request['name'];
        $revenue->category = $request['category'];
        $revenue->currency = $request['currency'];
        $revenue->amount = $request['amount'];
        $revenue->recieved_at = $request['recieved_at'];
        $revenue->notes = $request['notes'];
        $revenue->save();

        return redirect()->route('revenue.index');
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
        $revenue = Revenue::find($id);
        $data = compact('revenue');

        return view('revenue::edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update($id, Request $request)
    {
       $revenue = Revenue::find($id);
       $revenue->name = $request['name'];
       $revenue->category = $request['category'];
       $revenue->currency = $request['currency'];
       $revenue->amount = $request['amount'];
       $revenue->recieved_at = $request['recieved_at'];
       $revenue->notes = $request['notes'];
       $revenue->save();

       return redirect()->route('revenue.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function delete($id)
    {
        
        $revenue = Revenue::find($id);
        // dd($revenue);
        $daysCount = carbon::today()->subdays(+10);
        $revenueCreated = Revenue::where('id',$revenue)->pluck('created_at');
        dd($revenueCreated);
        if($daysCount > $revenueCreated) {
            $delete = $revenue->delete();
        }

        return redirect()->route('revenue.index');
    }
}
