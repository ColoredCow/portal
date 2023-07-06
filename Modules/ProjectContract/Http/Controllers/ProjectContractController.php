<?php

namespace Modules\ProjectContract\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\ProjectContract\Services\ProjectContractService;
use Modules\ProjectContract\Services\ProjectContractMailService;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Modules\ProjectContract\Emails\ClientReview;
use Modules\ProjectContract\Emails\ClientApproveReview;
use Modules\ProjectContract\Emails\ClientUpdateReview;
use Modules\ProjectContract\Emails\FinanceReview;
use Modules\Client\Entities\Country;

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
        $clients = client::all();

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
        $contract = $this->service->updateContract($id);
        $this->mailservice->sendClientResponse($this->service->getUserEmail($id));

        return 'Thank you for finalise';
    }
    public function clientUpdate(Request $request)
    {
        $data = $request->all();
        $this->service->editContract($data);
        $this->mailservice->sendClientUpdate($this->service->getUserEmail($request['id']));
        Mail::to($this->service->getUserEmail($request['id']))->send(new ClientUpdateReview());

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
        $contract = $this->service->updateInternalContract($id);

        return redirect(route('projectcontract.index'))->with('success');
    }
    public function commentHistory($id)
    {
        $data = $this->service->getCommentHistory($id);

        return $data;
    }
}
