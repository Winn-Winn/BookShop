<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Contracts\Services\CartServiceInterface;

class CartController extends Controller
{
    /** CartService */
    private $CartService;

    /**
     * コンストラクタ
     *
     * @param CartServiceInterface $CartService
     */
    public function __construct(CartServiceInterface $CartService)
    {
        $this->CartService = $CartService;
    }

    /**
     * get Cart List
     *
     * @param $user_id
     * @return response()
     */
    public function cartList($user_id)
    {
        $cartList = $this->CartService->getCartList($user_id);

        return response()->json([
            "status" => "success",
            "cartList" => $cartList
        ]);
    }

    /**
     * get cart by book id
     *
     * @param Request $request
     * @return response()
     */
    public function getCartDataByBook(Request $request)
    {
        $cartByBookID = $this->CartService->getCartByBookID($request);

        return response()->json([
            "status" => "success",
            "cartByBookID" => $cartByBookID
        ]);
    }

    /**
     * add a cart item
     *
     * @param Request $request
     * @return response()
     */
    public function addToCart(Request $request)
    {
        $book = Book::findOrFail($request['book_id']);
          
        $cartByBookID = $this->CartService->getCartByBookID($request);

        if($cartByBookID->isEmpty()) {
            $book_data = [
                'book_id' => $request['book_id'],
                'user_id' => $request['user_id'],
                'name' => $book->title,
                'quantity' => 1,
                'price' => $book->price,
            ];

            $this->CartService->addCart($book_data);
        } else {
            $qty = $cartByBookID[0]['qty'] + 1;
            $update_data = [
                'book_id' => $request['book_id'],
                'user_id' => $request['user_id'],
                'qty' => $qty
            ];

            $this->CartService->updateCart($update_data);
        }

        return response()->json([
            "status" => "success"
        ]);
    }

    /**
     * update cart data
     *
     * @param Request $request
     * @return response()
     */
    public function updateCart(Request $request)
    {
        foreach ($request['cartList'] as $key => $value) {
            $update_data = [
                'book_id' => $value['book_id'],
                'user_id' => $value['user_id'],
                'qty' => $value['qty']
            ];

            $this->CartService->updateCart($update_data);
        }

        return response()->json([
            "status" => "success",
            "message" => "You successfully update a cart."
        ]);
    }

    /**
     * remove a cart
     *
     * @param $id
     * @return repsonse()
     */
    public function removeCart($id)
    {
        $this->CartService->deleteCartByID($id);

        return response()->json([
            "status" => "success",
            "message" => "You successfully remove a cart."
        ]);
    }

    /**
     * empty cart
     *
     * @param Request $request
     * @return response()
     */
    public function clearAllCart(Request $request)
    {
        $this->CartService->clearAllCart($request);

        return response()->json([
            "status" => "success",
            "message" => "You successfully clear carts."
        ]);
    }
}
