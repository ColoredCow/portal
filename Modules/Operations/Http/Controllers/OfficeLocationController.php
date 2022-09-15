<?php

namespace Modules\Operations\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Operations\Entities\OfficeLocation;

class OfficeLocationController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $officelocation = OfficeLocation::all();

        return view('operations::officelocation.index')->with('officelocations', $officelocation);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('operations::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        OfficeLocation::create([
            'center_head' => $request->center_head,
            'location' => $request->location,
            'capacity' => $request->capacity
        ]);

        return 'success';
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('operations::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        // return view('operations::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $officelocation =  Officelocation::find($id);
        $officelocation->center_head=$request->input('center_head');
        $officelocation->location=$request->input('location');
        $officelocation->capacity=$request->input('capacity');

        $officelocation->save();
        
        return $officelocation;

        // return redirect()->route('operation::officelocation.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {

        $officelocation =  Officelocation::find($id);

        $officelocation->delete();

        return $officelocation;
    }
}
