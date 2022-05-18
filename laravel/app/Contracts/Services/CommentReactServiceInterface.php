<?php

namespace App\Contracts\Services;

/**
 * BookServiceInterface
 *
 * @author
 */
interface CommentReactServiceInterface
{
    /**
     * getCommentList
     * 
     * @param request
     * @return
     */
    public function getCommentList($request);
    
    /**
     * getCommentInfo
     * 
     * @param request
     * @return
     */
    public function getCommentInfo($request);
    
    /**
     * updateComment
     * 
     * @param request
     * @return
     */
    public function updateComment($request);
    
    /**
     * saveComment
     * 
     * @param request
     * @return
     */
    public function saveComment($request);
}
