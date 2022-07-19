<?php

namespace Modules\HR\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\HR\Entities\HrChannel;

class HrChannelController extends Controller
{
    public function index()
    {
        return view('hr.application.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'=>'required'
        ]);

        $name = $request->input('name');
        HrChannel::updateOrCreate(
            [
            'name'=>$name
        ],
            [
            'name'=>$name
        ]
        );

        return redirect()->back()->with('status', 'Saved Successfully!');
    }
}
