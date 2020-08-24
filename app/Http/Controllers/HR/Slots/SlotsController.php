<?php

namespace App\Http\Controllers\HR\Slots;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HR\Slots;
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
        $slots=[];
        foreach (Slots::where('user_id', '=', auth()->user()->id)->get() as $model) {
            $start_time = $model->getOriginal('starts_at');
            if (!$start_time) {
                continue;
            }
            if ($model->is_booked) {
                $color='green';
            } else {
                $color='blue';
            }
            $slots[] = [
                    'start' => $start_time,
                    'end'   => $model->ends_at,
                    'url'   => route('hr.slots.edit', $model->id),
                    'color' =>$color
                ];
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
        Slots::create([
            'starts_at'=>request('start_time'),
            'ends_at'=>request('end_time'),
            'recurrence'=>request('recurrence'),
            'user_id'=>auth()->user()->id,
        ]);

        return redirect(route('hr.slots'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Slots $slot)
    {
        return view('hr.slots.edit', compact('slot'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SlotsRequest $request, Slots $slot)
    {
        $slot->update([
            'starts_at'=>request('start_time'),
            'ends_at'=>request('end_time'),
        ]);

        return redirect(route('hr.slots'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Slots $slot)
    {
        $slot->delete();
        return redirect(route('hr.slots'));
    }
}
