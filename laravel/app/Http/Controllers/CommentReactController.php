<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contracts\Services\CommentReactServiceInterface;

class CommentReactController extends Controller
{
    /** CommentReactService */
    private $CommentReactService;

    /**
     * コンストラクタ
    *
    * @param UserServiceInterface $CommentReactService
    */
    public function __construct(CommentReactServiceInterface $CommentReactService)
    {
        $this->CommentReactService = $CommentReactService;
    }

    /**
     * get Comment and React List
     *
     * @param Request $request
     * @return response()
     */
    public function list(Request $request)
    {
        $commentList = $this->CommentReactService->getCommentList($request);
        $cmt_count = 0;
        $react_count = 0;
        foreach ($commentList as $key => $value) {
            if($value['comment'] != null) {
                $cmt_count += 1;
            }
            if($value['react'] != null) {
                $react_count += 1;
            }
        }
        if($commentList) {
            return response()->json([
                "status" => "success",
                "commentList" => $commentList,
                "cmt_count" => $cmt_count,
                "react_count" => $react_count
            ]);
        }
    }

    /**
     * add a comment and react
     *
     * @param Request $request
     * @return response()
     */
    public function addComment(Request $request)
    {
        $commentInfo = $this->CommentReactService->getCommentInfo($request);
        if(!$commentInfo->isEmpty()) {
            $this->CommentReactService->updateComment($request);

            return response()->json([
                "status" => "success",
                "message" => "You updated a comment or react."
            ]);

        } else {
            $this->CommentReactService->saveComment($request);

            return response()->json([
                "status" => "success",
                "message" => "You added a comment or react."
            ]);
        }
    }
}
