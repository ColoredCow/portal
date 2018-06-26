<?php

namespace App\Http\Controllers;

use App\Helpers\FileHelper;
use App\Http\Requests\OrganizationRequest;
use App\Models\Organization;
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
        $organization = Organization::create([
            'slug' => $validated['slug'],
            'name' => $validated['name'],
            'contact_email' => $validated['admin_email'],
        ]);

        $organization->configurations()->create([
            'key' => 'service_account_client_id',
            'value' => $validated['gsuite_sa_client_id'],
        ]);

        $path = self::upload($validated['gsuite_dwd_private_key']);
        $organization->configurations()->create([
            'key' => 'service_account_private_key_file',
            'value' => $path,
        ]);

        dd('successful onboarding');
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
