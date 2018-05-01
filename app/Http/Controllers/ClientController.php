<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientRequest;
use App\Models\Client;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('client.index')->with([
            'clients' => Client::select('id', 'name', 'email', 'phone', 'is_active')->orderBy('id', 'desc')->paginate(config('constants.pagination_size')),
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
     * @param  \App\Http\Requests\ClientRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ClientRequest $request)
    {
        $validated = $request->validated();
        $client = Client::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'country' => $validated['country'],
            'is_active' => $validated['is_active'],
            'address' => $validated['address'],
            'gst_num' => array_key_exists('gst_num', $validated) ? $validated['gst_num'] : null
        ]);

        return redirect("/clients/$client->id/edit")->with('status', 'Client created succesfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return void
     */
    public function show(Client $client)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Client  $client
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
     * @param  \App\Http\Requests\ClientRequest  $request
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ClientRequest $request, Client $client)
    {
        $validated = $request->validated();
        $updated = $client->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'country' => $validated['country'],
            'is_active' => $validated['is_active'],
            'address' => $validated['address'],
            'gst_num' => array_key_exists('gst_num', $validated) ? $validated['gst_num'] : null
        ]);
        return redirect("/clients/$client->id/edit")->with('status', 'Client updated succesfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Client  $client
     * @return void
     */
    public function destroy(Client $client)
    {
        //
    }

    /**
     * Get all the projects for a client
     *
     * @param  \App\Models\Client $client
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getProjects(Client $client)
    {
        return $client->projects;
    }
}
