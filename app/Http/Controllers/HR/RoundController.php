<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Http\Requests\HR\RoundRequest;
use App\Models\HR\Round;

class RoundController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\HR\RoundRequest  $request
     * @return void
     */
    public function store(RoundRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\HR\Round  $round
     * @return void
     */
    public function show(Round $round)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HR\Round  $round
     * @return void
     */
    public function edit(Round $round)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\HR\RoundRequest  $request
     * @param  \App\Models\HR\Round  $round
     * @return \Illuminate\Http\Response
     */
    public function update(RoundRequest $request, Round $round)
    {
        $validated = $request->validated();
        $guidelines = preg_replace('/\r\n/', '', $validated['guidelines']);
        $round->update([
            'guidelines' => $guidelines,
        ]);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HR\Round  $round
     * @return void
     */
    public function destroy(Round $round)
    {
        //
    }
}
