<?php

namespace App\Services;

use App\Contracts\Dao\CommentReactDaoInterface;
use App\Contracts\Services\CommentReactServiceInterface;

/**
 * CommentReactService
 *
 * @author
 */
class CommentReactService implements CommentReactServiceInterface
{
     /**  CommentReactDao*/
     private $CommentReactDao;

     /**
     * コンストラクタ
     *
     * @param BookDaoInterface 
     */
     public function __construct(CommentReactDaoInterface $CommentReactDao)
     {
         $this->CommentReactDao = $CommentReactDao;
     }


     /**
     * getCommentList
     * 
     * @param Request request
     * @return
     */
    public function getCommentList($request)
    {
        return $this->CommentReactDao->getCommentList($request);
    }
    
    /**
     * getCommentInfo
     * 
     * @param Request request
     * @return
     */
    public function getCommentInfo($request) {
        return $this->CommentReactDao->getCommentInfo($request);
    }
    
    /**
     * updateComment
     * 
     * @param Request request
     * @return
     */
    public function updateComment($request) {
        return $this->CommentReactDao->updateComment($request);
    }
    
    /**
     * saveComment
     * 
     * @param Request request
     * @return
     */
    public function saveComment($request) {
        return $this->CommentReactDao->saveComment($request);
    }
}
