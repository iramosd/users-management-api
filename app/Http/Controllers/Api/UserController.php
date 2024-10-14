<?php

namespace App\Http\Controllers\Api;

use App\Contracts\UserServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{

    private UserServiceInterface $service;
    public function __construct() {
        $this->service = new UserService();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      if (! Gate::allows('viewAny', auth()->user())) {
            abort(403);
        }

        return UserResource::collection($this->service->list());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        if (! Gate::allows('create', auth()->user())) {
            abort(403);
        }

        return new UserResource($this->service->create($request->validated()));
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        if (! Gate::allows('view', auth()->user())) {
            abort(403);
        }

        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, User $user)
    {
        if (! Gate::allows('update', auth()->user())) {
            abort(403);
        }

        $this->service->update($user, $request->validated());

        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if (! Gate::allows('delete', auth()->user())) {
            abort(403);
        }

        $this->service->delete($user);

        return response()->noContent();
    }
}
