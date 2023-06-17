<?php

namespace Modules\ProjectContract\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\ProjectContract\Services\ProjectContractService;
use App\Models\Client;
use Modules\ProjectContract\Http\Requests\ProjectContractRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Modules\ProjectContract\Emails\ClientReview;
use Modules\ProjectContract\Emails\ClientApproveReview;
use Modules\ProjectContract\Emails\ClientUpdateReview;
use Modules\ProjectContract\Emails\FinanceReview;
use Illuminate\Support\Facades\Auth;

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
        $internal = $this->service->internal_reviewer();

        return view('projectcontract::index')->with('projects', $projects)->with('internal', $internal);
    }
    public function create()
    {
        return view('projectcontract::index');
    }
    public function store(Request $request)
    {
        $data = $request->all();
        $this->service->store($data);

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

    public function viewContract($id)
    {
        $contracts = $this->service->view_contract($id);

        $contractsmeta = $this->service->view_contractmeta($id);

        $comment = $this->service->view_comments($id);

        return view('projectcontract::view-contract')->with('contracts', $contracts)->with('contractsmeta', $contractsmeta)->with('comments', $comment);
    }

    public function sendreview(Request $request)
    {
        $data = $request->all();
        $this->service->store_reveiwer($data);
        $link = ReviewController::review($request['id'], $request['email']);
        Mail::to($request['email'])->send(new ClientReview($link));

        return redirect(route('projectcontract.index'))->with('success');
    }

    public function clientresponse($id)
    {
        $contract = $this->service->update_contract($id);
        Mail::to(Auth::user()->email)->send(new ClientApproveReview());

        return 'Thank you for finalise';
    }
    public function clientupdate(Request $request)
    {
        $data = $request->all();
        $this->service->edit_contract($data);
        Mail::to(Auth::user()->email)->send(new ClientUpdateReview());

        return 'Thank you for your update';
    }
    public function sendfinancereview(Request $request)
    {
        $data = $request->all();
        $this->service->store_internal_reveiwer($data);
        Mail::to($request['email'])->send(new FinanceReview());

        return redirect(route('projectcontract.index'))->with('success');
    }
}
