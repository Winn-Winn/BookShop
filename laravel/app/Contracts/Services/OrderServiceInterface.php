<?php

namespace App\Contracts\Services;

/**
 * OrderServiceInterface
 *
 * @author
 */
interface OrderServiceInterface
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
