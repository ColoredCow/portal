<?php

namespace Modules\ProjectContract\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\ProjectContract\Services\ProjectContractService;
use App\Models\Client;
use Modules\ProjectContract\Http\Requests\ProjectContractRequest;

class ProjectContractController extends Controller
{
    protected $service;
    public function __construct(ProjectContractService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $projects = $this->service->index();

        return view('projectcontract::index')->with('projects', $projects);
    }

    public function create()
    {
        return view('projectcontract::index');
    }

    public function store(ProjectContractRequest $ProjectContractMeta)
    {
        $this->service->store($ProjectContractMeta);

        return redirect(route('projectcontract.index'))->with('success', 'Project Contract created successfully');
    }

    public function show()
    {
        return view('projectcontract::index');
    }

    public function edit($id)
    {
        $projectId = [];
        $projects = $this->service->index($id);

        foreach ($projects as $project) {
            $projectId = $project;
        }
        $clients = client::all();

        return view('projectcontract::edit-project-contract')->with([
            'projectId' => $projectId,
            'clients' => $clients,
        ]);
    }

    public function delete($id)
    {
        $this->service->delete($id);

        return redirect(route('projectcontract.index'));
    }

    public function viewForm()
    {
        $clients = client::all();

        return view('projectcontract::add-new-client')->with('clients', $clients);
    }

    public function update(ProjectContractRequest $ProjectContractMeta, $id)
    {
        $this->service->update($ProjectContractMeta, $id);

        return redirect(route('projectcontract.index'))->with('success', 'Project Contract updated successfully');
    }
}
