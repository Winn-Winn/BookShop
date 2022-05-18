<?php

namespace App\Dao;

use App\Models\CommentReaction;
use App\Contracts\Dao\CommentReactDaoInterface;

/**
 * BookDao
 *
 * @author
 */
class CommentReactDao implements CommentReactDaoInterface
{
    /**
     * getCommentList
     * 
     * @param request
     * @return
     */
    public function getCommentList($request) {
        return CommentReaction::where('book_id', '=', $request['book_id'])->get();
    }
    
    /**
     * getCommentInfo
     * 
     * @param request
     * @return
     */
    public function getCommentInfo($request) {
        $comments = CommentReaction::where('book_id', '=', $request['book_id'])
                    ->where('user_id', '=', $request['user_id'])
                    ->get();
        return $comments;
    }
    
    /**
     * updateComment
     * 
     * @param request
     * @return
     */
    public function updateComment($request) {
        $comment = CommentReaction::find($request->book_id);
        $comment->comment = $request->comment;
        $comment->save();
        return $comment;
    }
    
    /**
     * saveComment
     * 
     * @param request
     * @return
     */
    public function saveComment($request) {
        $comment = new CommentReaction();
        $comment->comment = $request['comment'];
        $comment->react = $request['react'];
        $comment->user_id = $request['user_id'];
        $comment->book_id = $request['book_id'];
        $comment->save();
        return $comment;
    }
}
