<?php

namespace App\Http\Controllers\HR\Slots;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HR\Slot;
use App\Http\Requests\HR\SlotsRequest;

class SlotsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $slots=Slot::where('user_id', '=', auth()->id())->whereNotNull('starts_at')->get();
        foreach ($slots as $slot) {
            $slot->url=route('hr.slots.edit', $slot->id);
            $slot->color=$slot->is_booked?'green':'blue';
            $slot->start=$slot->starts_at;
            $slot->end=$slot->ends_at;
        }
        return view('hr.slots.index', compact('slots'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('hr.slots.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SlotsRequest $request)
    {
        $validated=$request->validated();
        Slot::create([
            'starts_at'=>$validated['starts_at'],
            'ends_at'=>$validated['ends_at'],
            'recurrence'=>$validated['recurrence'],
            'user_id'=>auth()->id(),
        ]);

        return redirect(route('hr.slots'))->with('status', 'Slot created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Slot  $slot
     * @return \Illuminate\Http\Response
     */
    public function edit(Slot $slot)
    {
        return view('hr.slots.edit', compact('slot'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Slot  $slot
     * @return \Illuminate\Http\Response
     */
    public function update(SlotsRequest $request, Slot $slot)
    {
        $validated=$request->validated();
        $slot->update([
            'starts_at'=>$validated['starts_at'],
            'ends_at'=>$validated['ends_at'],
        ]);
        
        return redirect(route('hr.slots'))->with('status', 'Slot updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Slot $slot)
    {
        $slot->delete();
        return redirect(route('hr.slots'))->with('status', 'Slot deleted successfully');
    }
}
