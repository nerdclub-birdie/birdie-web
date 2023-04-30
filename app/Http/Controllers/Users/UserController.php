<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Resources\Users\UserCollection;
use App\Http\Resources\Users\UserResource;
use App\Http\Response;
use App\Services\Users\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private UserService $_service;
    public function __construct(UserService $service)
    {
        $this->_service = $service;
    }

    public function all(Request $request): UserCollection
    {
        $pages = $request->get("pages", 10);
        $users = $this->_service->model();
        return new UserCollection($users::paginate($pages));
    }

    public function get(Request $request, $id): UserResource
    {
        $language = $request->get("language");
        $user = $this->_service->find($id);
        return new UserResource($user, $language);
    }

    public function update(Request $request, $id): UserResource
    {
        $data = $request->all();
        $user = $this->_service->update($id, $data);
        return new UserResource($user);
    }

    public function delete($id): JsonResponse
    {
        $this->_service->delete($id);
        return Response::ok();
    }

}
