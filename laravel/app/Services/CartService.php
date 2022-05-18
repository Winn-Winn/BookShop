<?php

namespace App\Services;

use App\Contracts\Dao\CartDaoInterface;
use App\Contracts\Services\CartServiceInterface;

/**
 * CartService
 *
 * @author
 */
class CartService implements CartServiceInterface
{
     /**  CartDao*/
     private $CartDao;

     /**
     * コンストラクタ
     *
     * @param CartDaoInterface 
     */
     public function __construct(CartDaoInterface $CartDao)
     {
         $this->CartDao = $CartDao;
     }


    /**
     * getCartList
     * 
     * @param Request request
     * @return
     */
    public function getCartList($request)
    {
        return $this->CartDao->getCartList($request);
    }

    /**
     * getCartByBookID
     * 
     * @param Request request
     * @return
     */
    public function getCartByBookID($request)
    {
        return $this->CartDao->getCartByBookID($request);
    }
    
    /**
     * updateCart
     * 
     * @param Request request
     * @return
     */
    public function updateCart($request) {
        return $this->CartDao->updateCart($request);
    }
    
    /**
     * addCart
     * 
     * @param Request request
     * @return
     */
    public function addCart($request) {
        return $this->CartDao->addCart($request);
    }

    /**
     * deleteCartByID
     * 
     * @param id
     * @return
     */
    public function deleteCartByID($id) {
        return $this->CartDao->deleteCartByID($id);
    }

    /**
     * clearAllCart
     *
     * @param Request request
     * @return 
    */
    public function clearAllCart($request) {
        return $this->CartDao->clearAllCart($request);
    }
}
