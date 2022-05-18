<?php

namespace App\Dao;

use App\Models\Order;
use App\Contracts\Dao\OrderDaoInterface;

/**
 * OrderDao
 *
 * @author
 */
class OrderDao implements OrderDaoInterface
{
    /**
     * saveOrderByUser
     * 
     * @param request
     * @return
     */
    public function saveOrderByUser($request) {
        $order = new Order();
        $order->user_id = $request['user_id'];
        $order->book_id = $request['book_id'];
        $order->name = $request['name'];
        $order->qty = $request['qty'];
        $order->total_prices = $request['total_price'];
        $order->save();
        return $order;
    }

    /**
     * getOrderByID
     * 
     * @param request
     * @return
     */
    public function getOrderByID($request) {
        $order = Order::where('book_id', '=', $request['book_id'])
                    ->where('user_id', '=', $request['user_id'])
                    ->where('deleted_at', '=', NULL)
                    ->get();

        return $order;
    }

    /**
     * getOrderList
     * 
     ** @param request
     * @return
     */
    public function getOrderList($request) {
        $orderList = Order::where('user_id', '=', $request['user_id'])
                    ->where('deleted_at', '=', NULL)
                    ->get();

        return $orderList;
    }

    /**
     * orderByUser
     * 
     ** @param request
     * @return 
    */
    public function orderByUser($request) {
        Order::where('user_id',$request['user_id'])->delete();

        return true;
    }
}
