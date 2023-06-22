<?php

namespace Modules\ProjectContract\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\ProjectContract\Services\ProjectContractService;
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
    public function store(Request $request)
    {
        $data = $request->all();
        $contract = $this->service->store($data);
        $this->service->store_user($contract);

        return redirect(route('projectcontract.index'))->with('success', 'Project Contract created successfully');
    }
    public function show()
    {
        return view('projectcontract::index');
    }
    public function edit($id)
    {
        $contracts = $this->service->view_contract($id);

        $contractsmeta = $this->service->view_contractmeta($id);

        $comment = $this->service->view_comments($id);

        $reviewer = $this->service->view_internal_reviewer($id);

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
        $this->service->update_internal($ProjectContractMeta);

        return redirect(route('projectcontract.index'))->with('success', 'Project Contract updated successfully');
    }

    public function viewContract($id)
    {
        $contracts = $this->service->view_contract($id);

        $contractsmeta = $this->service->view_contractmeta($id);

        $comment = $this->service->view_comments($id);

        $user = $this->service->get_status($contracts->id);

        $client = $this->service->get_client_status($contracts->id);

        $finance = $this->service->get_finance_status($contracts->id);

        $users = $this->service->get_users();

        return view('projectcontract::view-contract')->with('contracts', $contracts)->with('contractsmeta', $contractsmeta)->with('comments', $comment)->with('user', $user)->with('client', $client)->with('finance', $finance)->with('users', $users);
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
        Mail::to($this->service->get_user_email($id))->send(new ClientApproveReview());

        return 'Thank you for finalise';
    }
    public function clientupdate(Request $request)
    {
        $data = $request->all();
        $this->service->edit_contract($data);
        Mail::to($this->service->get_user_email($request['id']))->send(new ClientUpdateReview());

        return 'Thank you for your update';
    }
    public function sendfinancereview(Request $request)
    {
        $data = $request->all();
        $this->service->store_internal_reveiwer($data);
        Mail::to($request['email'])->send(new FinanceReview());

        return redirect(route('projectcontract.index'))->with('success');
    }
    public function internalresponse($id)
    {
        $contract = $this->service->update_internal_contract($id);

        return redirect(route('projectcontract.index'))->with('success');
    }
    public function commenthistory($id)
    {
        $data = $this->service->get_comment_history($id);

        return $data;
    }
}
