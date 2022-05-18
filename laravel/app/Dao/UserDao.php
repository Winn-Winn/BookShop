<?php

namespace App\Dao;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Contracts\Dao\UserDaoInterface;

/**
 * UserDao
 *
 * @author
 */
class UserDao implements UserDaoInterface
{
    /**
     * getUsers
     * 
     * @return
     */
    public function getUsers() {
        $users = DB::table('users')->get();

        return $users;
    }

    /**
     * saveUser
     *
     * @param $request
     * @return
     */
    public function saveUser($request) {
        DB::beginTransaction();
        try {
            DB::table('users')->insert([
                'name' => $request['name'],
                'role' => $request['role'] == true ? 1:0,
                'email'=> $request['email'],
                'password'=> $request['password'],
                'created_at'=> now(),
                'updated_at'=> now(),
            ]);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
        }
    }

    /**
     * updateUser
     *
     * @param $request
     * @return
     */
    public function updateUser($request) {
        DB::beginTransaction();
        $old_user = User::select("users.*")
                            ->where("email", $request['email'])
                            ->first();
            
        if ($old_user) {  
            try {
                $insertData = array(
                    'name'=> $request['name'],
                    'role'=> $request['role'],
                    'email'=> $request['email'],
                    'password'=> $request['password'],
                    'updated_at'=> now(),
                );
                User::select("users.*")
                    ->where("email", $request['email'])
                    ->update($insertData);

                DB::commit();
                return true;
            } catch (\Exception $e) {
                DB::rollback();
            }
        }
        return false;
    }

    /**
     * getUserInfo
     *
     * @param $request
     * @return
     */
    public function getUserInfo($request) {
        $userInfo = "SELECT
                        users.name,
                        users.role,
                        users.email,
                        users.password
                    FROM
                        users
                    WHERE
                        users.email = :email
                    AND
                        users.password = :password";

        $param = [
            "email" => $request['email'],
            "password" => $request['password']
        ];
        $user = DB::select($userInfo, $param);
        return $user;
    }
}