<?php

namespace Modules\ProjectContract\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\URL;
use Modules\Client\Entities\Country;
use Modules\ProjectContract\Services\ProjectContractService;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Renderable
     */
    protected $services;
    public function __construct(ProjectContractService $services)
    {
        $this->services = $services;
    }

    public function index($id, $email)
    {
        $contracts = $this->services->viewContract($id);
        $contractsmeta = $this->services->viewContractMeta($id);
        $reviewer = $this->services->viewReviewer($id, $email);
        $comment = $this->services->viewComments($id);

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
