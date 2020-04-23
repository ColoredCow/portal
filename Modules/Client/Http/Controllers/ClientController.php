<?php

namespace Modules\Client\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Client\Entities\Client;
use Modules\Client\Contracts\ClientServiceContract;

class ClientController extends Controller
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
        $clients = $this->service->index();
        return view('client::index', ['clients' => $clients]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('client::create', [
            'keyAccountManagers' => $this->service->getkeyAccountmanagers(),
            'channelPartners' => $this->service->getChannelPartners(),
            'parentOrganisations' => $this->service->getParentOrganisations(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $client = $this->service->store($request->all());
        return redirect(route('client.edit', [$client, 'client-type']));
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
        return view('client::edit', [
            'keyAccountManagers' => $this->service->getkeyAccountmanagers(),
            'channelPartners' => $this->service->getChannelPartners(),
            'parentOrganisations' => $this->service->getParentOrganisations(),
            'client' => $client,
            'section' => $section ?: config('client.default-client-form-stage')
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, Client $client)
    {
        $this->service->updateClientData($request->all(), $client);
        return redirect(route('client.index'));
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
