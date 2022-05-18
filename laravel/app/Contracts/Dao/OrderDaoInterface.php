<?php

namespace App\Contracts\Dao;

/**
 * OrderDaoInterfaceInterface
 *
 * @author
 */
interface OrderDaoInterface
{
    /**
     * saveOrderByUser
     * 
     * @param request
     * @return
     */
    public function saveOrderByUser($request);

    /**
     * getOrderByID
     * 
     * @param request
     * @return
     */
    public function getOrderByID($request);

    /**
     * getOrderList
     * 
     * @param request
     * @return
     */
    public function getOrderList($request);

    /**
     * orderByUser
     * 
     * @param request
     * @return 
    */
    public function orderByUser($request);
}
