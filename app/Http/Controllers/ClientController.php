<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientRequest;
use App\Models\Client;

class ClientController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Client::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $this->authorize('list', Client::class);

        return view('client.index')->with([
            'clients' => Client::select('id', 'name', 'is_active')->with('projects')->orderBy('id', 'desc')->paginate(config('constants.pagination_size')),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('client.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ClientRequest  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ClientRequest $request)
    {
        $validated = $request->validated();
        $client = Client::create([
            'name' => $validated['name'],
            'is_active' => isset($validated['is_active']) ? true : false,
            'gst_num' => array_key_exists('gst_num', $validated) ? $validated['gst_num'] : null,
        ]);

        return redirect("/clients/{$client->id}/edit")->with('status', 'Client created succesfully!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Client  $client
     *
     * @return \Illuminate\View\View
     */
    public function edit(Client $client)
    {
        return view('client.edit')->with([
            'client' => $client,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ClientRequest  $request
     * @param  Client  $client
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ClientRequest $request, Client $client)
    {
        $validated = $request->validated();
        $client->update([
            'name' => $validated['name'],
            'is_active' => isset($validated['is_active']) ? true : false,
            'gst_num' => array_key_exists('gst_num', $validated) ? $validated['gst_num'] : null,
        ]);

        return redirect("/clients/{$client->id}/edit")->with('status', 'Client updated successfully!');
    }

    /**
     * Get all the projects for a client.
     *
     * @param  Client $client
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getProjects(Client $client)
    {
        return $client->projects;
    }
}
