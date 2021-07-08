<?php

namespace Modules\Client\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Client\Entities\Client;
use Modules\Client\Contracts\ClientServiceContract;
use Modules\Client\Http\Requests\ClientFormsRequest;
use Modules\Client\Http\Requests\ClientRequest;

class ClientController extends ModuleBaseController
{
    protected $service;

    public function __construct(ClientServiceContract $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $this->authorize('viewAny', Client::class);
        return view('client::index', $this->service->index());
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $this->authorize('create', Client::class);
        return view('client::create', $this->service->create());
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(ClientRequest $request)
    {
        $this->authorize('create', Client::class);
        $client = $this->service->store($request->all());
        return redirect(route('client.edit', [$client, 'contact-persons']));
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('client::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit(Client $client, $section = null)
    {
        $this->authorize('update', $client);
        return view('client::edit', $this->service->edit($client, $section));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(ClientFormsRequest $request, Client $client)
    {
        $this->authorize('update', $client);
        $data = $this->service->update($request->all(), $client);
        return redirect($data['route']);
    }
}
