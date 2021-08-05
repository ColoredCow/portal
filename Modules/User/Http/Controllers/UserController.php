<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Http\Response;
use Modules\User\Entities\User;
use Modules\User\Contracts\UserServiceContract;
use Modules\User\Http\Requests\UpdateUserRolesRequest;

class UserController extends ModuleBaseController
{
    protected $service;

    public function __construct(UserServiceContract $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $this->authorize('viewAny', User::class);
        $users = $this->service->index();

        return view('user::index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('user::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('user::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('user::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    public function updateUserRoles(UpdateUserRolesRequest $request)
    {
        $validatedData = $request->validated();

        return $this->service->updateUserRoles($validatedData);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', User::class);
        $this->service->delete($user);
    }
}
