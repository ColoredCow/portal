<?php

namespace Modules\ProjectContract\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Client\Entities\Country;
use Modules\ProjectContract\Services\ProjectContractMailService;
use Modules\ProjectContract\Services\ProjectContractService;

class ProjectContractController extends Controller
{
    protected $service;
    protected $mailservice;
    public function __construct(ProjectContractService $service, ProjectContractMailService $mailservice)
    {
        $this->service = $service;
        $this->mailservice = $mailservice;
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
    public function store(Request $request)
    {
        $data = $request->all();
        $contract = $this->service->store($data);
        $this->service->storeUser($contract);

        return redirect(route('projectcontract.index'))->with('success', 'Project Contract created successfully');
    }
    public function show()
    {
        return view('projectcontract::index');
    }
    public function edit($id)
    {
        $contracts = $this->service->viewContract($id);

        $contractsmeta = $this->service->viewContractMeta($id);

        $comment = $this->service->viewComments($id);

        $reviewer = $this->service->viewInternalReviewer($id);

        return view('projectcontract::edit-project-contract')->with('contracts', $contracts)->with('contractsmeta', $contractsmeta)->with('comments', $comment)->with('reviewer', $reviewer)->with('countries', Country::all());
    }
    public function delete($id)
    {
        $this->service->delete($id);

        return redirect(route('projectcontract.index'));
    }
    public function viewForm()
    {
        $clients = Client::all();

        return view('projectcontract::add-new-client')->with('clients', $clients)->with('countries', Country::all());
    }
    public function update(Request $ProjectContractMeta)
    {
        $this->service->updateInternal($ProjectContractMeta);

        return redirect(route('projectcontract.index'))->with('success', 'Project Contract updated successfully');
    }

    public function viewContract($id)
    {
        $contracts = $this->service->viewContract($id);

        $contractsmeta = $this->service->viewContractMetaGroup($id);

        $comment = $this->service->viewComments($id);

        $user = $this->service->getStatus($contracts->id);

        $client = $this->service->getClientStatus($contracts->id);

        $finance = $this->service->getFinanceStatus($contracts->id);

        $users = $this->service->getUsers();

        return view('projectcontract::view-contract')->with('contracts', $contracts)->with('contractsmeta', $contractsmeta)->with('comments', $comment)->with('user', $user)->with('client', $client)->with('finance', $finance)->with('users', $users);
    }

    public function sendReview(Request $request)
    {
        $data = $request->all();
        $this->service->storeReveiwer($data);
        $link = ReviewController::review($request['id'], $request['email']);
        $this->mailservice->sendClientReview($request['email'], $link);

        return redirect(route('projectcontract.index'))->with('success');
    }

    public function clientResponse($id)
    {
        $this->service->updateContract($id);
        $this->mailservice->sendClientResponse($this->service->getUserEmail($id));

        return 'Thank you for finalize';
    }
    public function clientUpdate(Request $request)
    {
        $data = $request->all();
        $this->service->editContract($data);
        $this->mailservice->sendClientUpdate($this->service->getUserEmail($request['id']));

        return 'Thank you for your update';
    }
    public function sendFinanceReview(Request $request)
    {
        $data = $request->all();
        $this->service->storeInternalReveiwer($data);
        $this->mailservice->sendFinanceReview($request['email']);

        return redirect(route('projectcontract.index'))->with('success');
    }
    public function internalResponse($id)
    {
        $this->service->updateInternalContract($id);

        return redirect(route('projectcontract.index'))->with('success');
    }
    public function commentHistory($id)
    {
        return $this->service->getCommentHistory($id);
    }
}
