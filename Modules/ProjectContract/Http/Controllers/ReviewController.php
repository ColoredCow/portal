<?php

namespace Modules\ProjectContract\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\URL;
use Modules\ProjectContract\Services\ProjectContractService;
use Modules\Client\Entities\Country;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    protected $services;
    public function __construct(ProjectContractService $services)
    {
        $this->services = $services;
    }

    public function index($id, $email)
    {
        $contracts = $this->services->view_contract($id);
        $contractsmeta = $this->services->view_contractmeta($id);
        $reviewer = $this->services->view_reviewer($id, $email);
        $comment = $this->services->view_comments($id);

        return view('projectcontract::review-contract')->with('contracts', $contracts)->with('contractsmeta', $contractsmeta)->with('reviewer', $reviewer)->with('comments', $comment)->with('countries', Country::all());
    }

    public static function review($id, $email)
    {
        return URL::SignedRoute(
            'review',
            ['user' => $id, 'email' => $email]
        );
    }
}
