<?php

namespace App\Contracts\Dao;

/**
 * UserDaoInterface
 *
 * @author
 */
interface UserDaoInterface
{
    /**
     * getUsers
     * 
     * @param request
     * @return
     */
    public function getUsers();

    /**
     * saveUser
     * 
     * @param request
     * @return
     */
    public function saveUser($request);

    /**
     * updateUser
     * 
     * @param request
     * @return
     */
    public function updateUser($request);

    /**
     * getUserInfo
     * 
     * @param request
     * @return
     */
    public function getUserInfo($request);

}
