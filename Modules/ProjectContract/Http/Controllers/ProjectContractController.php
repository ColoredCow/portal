<?php

namespace Modules\ProjectContract\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Client\Entities\Client;
use Modules\ProjectContract\Rules\ProjectNameExist;
use Modules\ProjectContract\Http\Requests\ProjectContractRequest;
use Modules\Project\Services\ProjectService;
use Modules\Project\Contracts\ProjectServiceContract;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Modules\ProjectContract\Entities\ProjectContractMeta;

class ProjectContractController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $clients = Client::all();

        return view('projectcontract::index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $service = app(ProjectService::class);
        $clients = $service->getClients();

        return view('projectcontract::create')->with('clients', $clients);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request3
     * @return Renderable
     */
    public function store(ProjectContractRequest $request)
    {
        $validated = $request->validated();
        ProjectContractmeta::create($validated);

        $clients = Client::all();

        return view('projectcontract::index', compact('clients'))->with('success', 'Project Contract created successfully');
    }
}
