<?php

namespace App\Contracts\Services;

/**
 * BookServiceInterface
 *
 * @author
 */
interface BookServiceInterface
{
    /**
     * saveBook
     * 
     * @param request
     * @return
     */
    public function saveBook($request);

    /**
     * updateBook
     * 
     * @param quest request
     * @return
     */
    public function updateBook($request);

    /**
     * getBooksList
     * 
     * @return
     */
    public function getBooksList($request);

    /**
     * getBook
     * 
     * @param request
     * @return
     */
    public function getBook($request);

    /**
     * deleteBook
     * 
     * @param request
     * @return
     */
    public function deleteBook($request);
}
