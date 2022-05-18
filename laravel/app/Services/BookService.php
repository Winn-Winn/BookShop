<?php

namespace App\Services;

use App\Contracts\Services\BookServiceInterface;
use App\Contracts\Dao\BookDaoInterface;

/**
 * BookService
 *
 * @author
 */
class BookService implements BookServiceInterface
{
    /**  BookDao*/
    private $BookDao;

    /**
    * コンストラクタ
    *
    * @param BookDaoInterface
    */
    public function __construct(BookDaoInterface $BookDao)
    {
        $this->BookDao = $BookDao;
    }

    /**
     * saveBook
     * 
     * @param Request $request
     *
     */
    public function saveBook($request)
    {
        return $this->BookDao->saveBook($request);
    }

    /**
     * updateBook
     * 
     * @param Request $request
     *
     */
    public function updateBook($request)
    {
        return $this->BookDao->updateBook($request);
    }

    /**
     *getBooksList
     *
     * @param Request $request
     */
    public function getBooksList($request)
    {
        return $this->BookDao->getBooksList($request);
    }

    /**
     * getBook
     * 
     * @param Request $request
     *
     */
    public function getBook($request)
    {
        return $this->BookDao->getBook($request);
    }

    /**
     * deleteBook
     * 
     * @param Request $request
     *
     */
    public function deleteBook($request)
    {
        return $this->BookDao->deleteBook($request);
    }
}
