<?php

namespace Modules\Operations\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Modules\HR\Entities\Employee;
use Modules\Operations\Entities\OfficeLocation;

class OfficeLocationController extends Controller
{
    public function index()
    {
        $officelocation = OfficeLocation::all();
        $centerHead = Employee::all();

        return view('operations::officelocation.index')->with([
                'officelocations' => $officelocation,
                'centerHeads' => $centerHead,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'center_head' => 'required',
            'location' => 'required',
            'capacity' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()->all()]);
        } else {
            OfficeLocation::create([
                'center_head' => $request->center_head,
                'location' => $request->location,
                'capacity' => $request->capacity,
            ]);
        }

        return response()->json(['success'=>'Added new records.']);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'center_head' => 'required',
            'location' => 'required',
            'capacity' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()->all()]);
        } else {
            $officelocation = OfficeLocation::find($id);
            $officelocation->center_head = $request->input('center_head');
            $officelocation->location = $request->input('location');
            $officelocation->capacity = $request->input('capacity');

            $officelocation->save();
        }

        return response()->json(['success'=>'Added new records.']);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     */
    public function destroy($id)
    {
        $officelocation = OfficeLocation::find($id);

        $officelocation->delete();

        return back();
    }
}
