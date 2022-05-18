<?php

namespace App\Contracts\Services;

/**
 * CartServiceInterface
 *
 * @author
 */
interface CartServiceInterface
{
    /**
     * getCartList
     * 
     * @param request
     * @return
     */
    public function getCartList($request);

    /**
     * getCartByBookID
     * 
     * @param request
     * @return
     */
    public function getCartByBookID($request);
    
    /**
     * updateCart
     * 
     * @param request
     * @return
     */
    public function updateCart($request);
    
    /**
     * addCart
     * 
     * @param request
     * @return
     */
    public function addCart($request);

    /**
     * deleteCartByID
     * 
     * @param id
     * @return
     */
    public function deleteCartByID($id);

    /**
     * clearAllCart
     * 
     * @param request
     * @return 
    */
    public function clearAllCart($request);
}
