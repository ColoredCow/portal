<?php

namespace Modules\ProjectContract\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\ProjectContract\Services\ProjectContractService;
use App\Models\Client;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Modules\ProjectContract\Entities\ProjectContractMeta;
use Modules\ProjectContract\Http\Requests\ProjectContractRequest;

class ProjectContractController extends Controller
{
    use AuthorizesRequests;
    protected $service;
    public function __construct(ProjectContractService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $this->authorize('viewAny', ProjectContractMeta::class);
        $projects = $this->service->index();

        return view('projectcontract::index')->with(['projects' => $projects]);
    }

    public function create()
    {
        return view('projectcontract::index');
    }

    public function store(ProjectContractRequest $ProjectContractMeta)
    {
        $this->authorize('viewForm', ProjectContractMeta::class);
        $this->service->store($ProjectContractMeta);

        return redirect(route('projectcontract.index'))->with('success', 'Project Contract created successfully');
    }

    public function show($id)
    {
        $project = $this->service->index()->find($id);

        return view('projectcontract::show')->with([
            'project' => $project,
        ]);
    }

    public function edit($id)
    {
        $this->authorize('update', ProjectContractMeta::class);
        $project = ProjectContractMeta::where('id', $id)->first();
        $clients = client::all();

        return view('projectcontract::edit-project-contract')->with([
            'project' => $project,
            'clients' => $clients,
        ]);
    }

    public function viewForm()
    {
        $this->authorize('viewForm', ProjectContractMeta::class);
        $clients = client::all();

        return view('projectcontract::add-new-client')->with('clients', $clients);
    }

    public function update(ProjectContractRequest $ProjectContractMeta, $id)
    {
        $this->authorize('update', ProjectContractMeta::class);
        $this->service->update($ProjectContractMeta, $id);

        return redirect(route('projectcontract.index'))->with('success', 'Project Contract updated successfully');
    }

    public function delete($id)
    {
        $this->authorize('delete', ProjectContractMeta::class);
        $this->service->delete($id);

        return redirect(route('projectcontract.index'));
    }
}
