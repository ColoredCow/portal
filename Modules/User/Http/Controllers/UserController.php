<?php

namespace Modules\User\Http\Controllers;

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
     */
    public function index()
    {
        $this->authorize('viewAny', User::class);
        $users = $this->service->index();

        return view('user::index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Show the specified resource.
     * @param int $id
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     */
    public function edit($id)
    {
    }

    public function updateUserRoles(UpdateUserRolesRequest $request)
    {
        $validatedData = $request->validated();

        return $this->service->updateUserRoles($validatedData);
    }

    /**
     * Remove the specified resource from storage.
     * @param User $user
     * @return void
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);
        $this->service->delete($user);
    }

    public function storeRoles(RoleRequest $role)
    {
        $this->service->$role;

        return redirect()->back();
    }

}
