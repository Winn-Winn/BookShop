<?php

namespace App\Http\Controllers;

use App\Contracts\Services\UserServiceInterface;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /** UserService */
    private $UserService;

    /**
     * コンストラクタ
     *
     * @param UserServiceInterface $UserService
     */
    public function __construct(UserServiceInterface $UserService)
    {
        $this->UserService = $UserService;
    }

    /**
     * User List
     *
     * @return
     */
    public function list()
    {
        $users = $this->UserService->getUsers();
        if($users) {
            return response()->json([
                "status" => "success",
                "users" => $users
            ]);
        }
    }

    /**
     * User create
     *
     * @param UserRequest $request
     * @return
     */
    public function create(UserRequest $request)
    {
        $userInfo = $this->UserService->getUserInfo($request);
        if($userInfo) {
            $user = $this->UserService->updateUser($request);
        } else {
            $user = $this->UserService->saveUser($request);
        }

        if($user) {
            return response()->json([
                "status" => "success",
            ]);
        }
    }
}
