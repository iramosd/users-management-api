<?php

namespace App\Http\Controllers\Api;

use App\Contracts\UserServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use Illuminate\Http\Request;

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
        $this->authorize('viewAny', $this);

        return UserResource::collection($this->service->list());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', $this);


    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $this->authorize('view', $this);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->authorize('update', $this);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->authorize('delete', $this);
    }
}
