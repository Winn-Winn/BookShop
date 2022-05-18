<?php

namespace App\Services;

use App\Contracts\Services\UserServiceInterface;
use App\Contracts\Dao\UserDaoInterface;

/**
 * UserService
 *
 * @author
 */
class UserService implements UserServiceInterface
{
    /**  UserDao*/
    private $UserDao;

    /**
    * コンストラクタ
    *
    * @param UserDaoInterface
    */
    public function __construct(UserDaoInterface $UserDao)
    {
        $this->UserDao = $UserDao;
    }

    /**
     * getUsers
     * 
     * @param Request $request
     */
    public function getUsers()
    {
        return $this->UserDao->getUsers();
    }

    /**
     * saveUser
     * 
     * @param Request $request
     *
     */
    public function saveUser($request)
    {
        return $this->UserDao->saveUser($request);
    }

    /**
     * updateUser
     * 
     * @param Request $request
     *
     */
    public function updateUser($request)
    {
        return $this->UserDao->updateUser($request);
    }

    /**
     * getuserInfo
     * 
     * @param Request $request
     *
     */
    public function getuserInfo($request)
    {
        return $this->UserDao->getuserInfo($request);
    }
}
