<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contracts\Services\OrderServiceInterface;

class OrderController extends Controller
{
    /** OrderService */
    private $OrderService;

    /**
     * コンストラクタ
     *
     * @param OrderServiceInterface $OrderService
     */
    public function __construct(OrderServiceInterface $OrderService)
    {
        $this->OrderService = $OrderService;
    }

    /**
     * checkout
     *
     * @param Request $request
     * @return response()
     */
    public function checkout(Request $request)
    {
        foreach ($request['cartList'] as $key => $value) {
            $total_prices = $value['price'] * $value['qty'];
            $save_data = [
                'book_id' => $value['book_id'],
                'user_id' => $value['user_id'],
                'name' => $value['name'],
                'qty' => $value['qty'],
                'total_price' => $total_prices,
            ];

            $order = $this->OrderService->getOrderByID($value);
            if(count($order) == 0) {
                $this->OrderService->saveOrderByUser($save_data);
            }

        }

        return response()->json([
            "status" => "success",
            "message" => "Your order is confirmed."
        ]);
    }

    /**
     * get Order List
     *
     * @param Request $request
     * @return response()
     */
    public function getOrderList(Request $request)
    {
        $orders = $this->OrderService->getOrderList($request);

        if(count($orders) == 0) {
            return response()->json([
                "status" => "error"
            ]);
        }

        return response()->json([
            "status" => "success",
            "orders" => $orders
        ]);
    }

    /**
     * get Order by user
     *
     * @param Request $request
     * @return response()
     */
    public function OrderByUser(Request $request)
    {
        $this->OrderService->orderByUser($request);

        return response()->json([
            "status" => "success",
            "message" => "You successfully ordered."
        ]);
    }
}
