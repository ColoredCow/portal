<?php

namespace Modules\Prospect\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use Modules\Prospect\Entities\Prospect;
use Modules\Prospect\Entities\ProspectDocument;
use Modules\Prospect\Contracts\ProspectServiceContract;

class ProspectController extends Controller
{
    protected $service;

    public function __construct(ProspectServiceContract $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('prospect::index', $this->service->index());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('prospect::create', $this->service->create());
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     */
    public function store(Request $request)
    {
        $prospect = $this->service->store($request->all());

        return redirect(route('prospect.edit', [$prospect, 'contact-persons']));
    }

    /**
     * Show the specified resource.
     * @param int $id
     */
    public function show($id, $section = null)
    {
        return redirect(route('prospect.edit', [$id, 'overview']));

        // return view('prospect::show', $this->service->show($id, $section));
    }

    /**
     * Show the form for editing the specified resource.
     * @param Prospect $prospect
     */
    public function edit(Prospect $prospect, $section = null)
    {
        return view('prospect::edit', $this->service->edit($prospect, $section));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     */
    public function update(Request $request, $id)
    {
        $data = $this->service->update($request->all(), $id);

        return redirect($data['route'])->with('status', 'Prospect created/updated  succesfully!');
    }

    public function newProgressStage(Request $request)
    {
        return $this->service->addNewProgressStage($request->all());
    }

    public function openDocument(Request $request, $documentID)
    {
        $prospectDocument = ProspectDocument::find($documentID);

        return Storage::download($prospectDocument->file_path);
    }
}
