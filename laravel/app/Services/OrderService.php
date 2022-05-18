<?php

namespace App\Services;

use App\Contracts\Dao\OrderDaoInterface;
use App\Contracts\Services\OrderServiceInterface;

/**
 * OrderService
 *
 * @author
 */
class OrderService implements OrderServiceInterface
{
    /** OrderDao*/
    private $OrderDao;

    /**
 * コンストラクタ
 *
 * @param OrderDaoInterface OrderDao
 */
    public function __construct(OrderDaoInterface $OrderDao)
    {
        $this->OrderDao = $OrderDao;
    }

     /**
     * saveOrderByUser
     * 
     * @param Request request
     * @return
     */
    public function saveOrderByUser($request) {
        return $this->OrderDao->saveOrderByUser($request);
    }

    /**
     * getOrderByID
     * 
     * @param Request request
     * @return
     */
    public function getOrderByID($request) {
        return $this->OrderDao->getOrderByID($request);
    }

    /**
     * getOrderList
     * 
     * @param Request request
     * @return
     */
    public function getOrderList($request) {
        return $this->OrderDao->getOrderList($request);
    }

    /**
     * orderByUser
     * 
     * @param Request request
     * @return 
    */
    public function orderByUser($request) {
        return $this->OrderDao->orderByUser($request);
    }
}
