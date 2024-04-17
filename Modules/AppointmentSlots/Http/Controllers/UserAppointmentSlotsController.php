<?php

namespace Modules\AppointmentSlots\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\AppointmentSlots\Entities\AppointmentSlot;
use Modules\AppointmentSlots\Http\Requests\UserAppointmentSlotRequest;
use Modules\User\Entities\User;

class UserAppointmentSlotsController extends Controller
{
    public function show(User $user)
    {
        if ($user->id != auth()->id()) {
            $this->authorize('view', AppointmentSlot::class);
        }
        $slots = $user->appointmentSlots;
        //needed for full calendar plugin
        foreach ($slots as $slot) {
            $slot->start = $slot->start_time;
            $slot->end = $slot->end_time;
            $slot->color = $slot->status == 'free' ? 'blue' : 'green';
        }
        $users = User::all();

        return view('appointmentslots::user_appointments.show', compact('slots', 'users', 'user'));
    }

    public function store(UserAppointmentSlotRequest $request)
    {
        $validated = $request->validated();
        if ($validated['user_id'] != auth()->id()) {
            $this->authorize('view', AppointmentSlot::class);
        }
        AppointmentSlot::create([
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'recurrence' => $validated['recurrence'],
            'user_id' => $validated['user_id'],
        ]);

        return redirect(route('userappointmentslots.show', $validated['user_id']))
        ->with('status', 'Slot created successfully');
    }

    public function update(UserAppointmentSlotRequest $request, AppointmentSlot $appointmentSlot)
    {
        $this->authorize('update', $appointmentSlot);
        $validated = $request->validated();
        $appointmentSlot->update([
            'start_time' => $validated['edit_start_time'],
            'end_time' => $validated['edit_end_time'],
        ]);

        return redirect(route('userappointmentslots.show', $appointmentSlot->user_id))
        ->with('status', 'Slot updated successfully');
    }

    public function destroy(AppointmentSlot $appointmentSlot)
    {
        $this->authorize('delete', $appointmentSlot);
        $appointmentSlot->delete();

        return redirect(route('userappointmentslots.show', $appointmentSlot->user_id))
        ->with('status', 'Slot deleted successfully');
    }
}