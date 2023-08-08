<?php

namespace Modules\Operations\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Operations\Entities\OfficeLocation;
use Modules\Operations\Services\OperationService;
use Modules\User\Entities\User;

class OperationsController extends Controller
{
    protected $service;

    public function __construct(OperationService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $centres = OfficeLocation::with('centre_head')->get();
        $users = User::orderBy('name', 'asc')->get();

        return view('operations::office-location.index', compact('users', 'centres'));
    }

    public function create()
    {
        // Logic for create method
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $this->service->store($data);

        return redirect()->route('office-location.index');
    }

    public function edit(OfficeLocation $centre)
    {
        $users = User::orderBy('name', 'asc')->get();

        return view('operations::office-location.edit', compact('centre', 'users'));
    }

    public function update(Request $request, OfficeLocation $centre)
    {
        $data = $request->all();
        $this->service->update($data, $centre);

        return redirect()->route('office-location.index');
    }

    public function delete(OfficeLocation $centre)
    {
        if ($centre->exists) {
            $centre->delete();
        }

        return redirect()->route('office-location.index');
    }
}
