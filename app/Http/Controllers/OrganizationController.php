<?php

namespace App\Http\Controllers;

use App\Facades\Tenant;
use App\Helpers\FileHelper;
use App\Http\Requests\OrganizationRequest;
use App\Models\Organization;
use App\Services\LoginService;
use Illuminate\Http\UploadedFile;

class OrganizationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('organizations.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\OrganizationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrganizationRequest $request)
    {
        $validated = $request->validated();
        $user = session('user', null);
        $organization = Organization::create([
            'slug' => Tenant::resolveName($user->user['domain']),
            'name' => $validated['name'],
            'contact_email' => $validated['admin_email'],
        ]);

        $path = self::upload($validated['gsuite_dwd_private_key']);
        $organization->configurations()->create([
            'key' => 'service_account_private_key_file',
            'value' => $path,
        ]);

        return LoginService::login();
    }

    /**
     * Upload private key file.
     *
     * @param  \Illuminate\Http\UploadedFile  $privateKeyFile
     * @return string    path of the uploaded file
     */
    protected static function upload(UploadedFile $privateKeyFile)
    {
        $fileName = $privateKeyFile->getClientOriginalName();

        if ($fileName) {
            return $privateKeyFile->storeAs(FileHelper::getGSuiteCredentialsDirectory(), $fileName);
        }

        return $privateKeyFile->store(FileHelper::getGSuiteCredentialsDirectory());
    }
}
