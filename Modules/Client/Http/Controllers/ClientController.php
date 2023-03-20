<?php

namespace Modules\Client\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Modules\Client\Contracts\ClientServiceContract;
use Modules\Client\Entities\Client;
use Modules\Client\Http\Requests\ClientFormsRequest;
use Modules\Client\Http\Requests\ClientRequest;
use Modules\Client\Rules\ClientNameExist;

class ClientController extends ModuleBaseController
{
    protected $service;

    public function __construct(ClientServiceContract $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Client::class);

        $column_sort = $request['column_sort'];
        $order = $request['order'];
        if (($column_sort == null) && ($order == null)) {
            return view('client::index', $this->service->index(request()->all()));
        }

        return view('client::index', $this->service->index(request()->all(), $column_sort, $order));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Client::class);

        return view('client::create', $this->service->create());
    }

    /**
     * Store a newly created resource in storage.
     * @param ClientRequest $request
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
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client, $section = null)
    {
        $this->authorize('update', $client);

        return view('client::edit', $this->service->edit($client, $section));
    }

    /**
     * Update the specified resource in storage.
     * @param ClientFormsRequest $request
     */
    public function update(ClientFormsRequest $request, Client $client)
    {
        $request->merge([
            'name' => trim(preg_replace('/\s\s+/', ' ', str_replace("\n", ' ', $request->name))),
        ]);
        if ($request->name != $client->name) {
            $request->validate(['name' => new ClientNameExist()]);
        }
        $this->authorize('update', $client);
        $data = $this->service->update($request->all(), $client);

        return redirect($data['route'])->with('success', 'Client has been created/updated successfully!');
    }
}
