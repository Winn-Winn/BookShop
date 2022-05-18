<?php

namespace App\Dao;

use App\Models\Cart;
use App\Contracts\Dao\CartDaoInterface;

/**
 * CartDao
 *
 * @author
 */
class CartDao implements CartDaoInterface
{
    /**
     * getCartList
     * 
     * @param $user_id
     * @return
     */
    public function getCartList($user_id) {
        $cartList = Cart::where('user_id', '=', $user_id)
                    ->where('deleted_at', '=', NULL)
                    ->get();

        return $cartList;
    }

    /**
     * getCartByBookID
     * 
     * @param request
     * @return
     */
    public function getCartByBookID($request) {
        $cartByBookID = Cart::where('book_id', '=', $request['book_id'])
                    ->where('user_id', '=', $request['user_id'])
                    ->get();

        return $cartByBookID;
    }

    /**
     * updateCart
     * 
     * @param request
     * @return
     */
    public function updateCart($request) {
        $cartByBookID = Cart::where('book_id', '=', $request['book_id'])
                        ->where('user_id', '=', $request['user_id'])
                        ->where('deleted_at', '=', NULL)
                        ->update(['qty' => $request['qty']]);

        return $cartByBookID;
    }
    
    /**
     * addCart
     * 
     * @param request
     * @return
     */
    public function addCart($request) {
        $cart = new Cart();
        $cart->user_id = $request['user_id'];
        $cart->book_id = $request['book_id'];
        $cart->name = $request['name'];
        $cart->qty = $request['quantity'];
        $cart->price = $request['price'];
        $cart->save();
        return $cart;
    }

    /**
     * deleteCartByID
     *
     * @param request
     * @return 
    */
    public function deleteCartByID($id) {
        Cart::find($id)->delete();

        return true;
    }

    /**
     * clearAllCart
     *
     * @param request
     * @return
    */
    public function clearAllCart($request) {
        Cart::where('user_id',$request['user_id'])->delete();

        return true;
    }
}
