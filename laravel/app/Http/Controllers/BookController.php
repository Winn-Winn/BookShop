<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Exports\BookExport;
use App\Imports\BookImport;
use Illuminate\Http\Request;
use App\Http\Requests\BookRequest;
use Maatwebsite\Excel\Facades\Excel;
use App\Contracts\Services\BookServiceInterface;

class BookController extends Controller
{
    /** BookService */
    private $BookService;

    /**
     * コンストラクタ
     *
     * @param BookServiceInterface $BookService
     */
    public function __construct(BookServiceInterface $BookService)
    {
        $this->BookService = $BookService;
    }

    /**
     * get List of Books
     *
     * @param Request $request
     * @return response()
     */
    public function list(Request $request)
    {
        $books = $this->BookService->getBooksList($request);

        if(count($books) == 0) {
            return response()->json([
                "status" => "error"
            ]);
        }

        return response()->json([
            "status" => "success",
            "books" => $books
        ]);
    }

    /**
     * create a book
     *
     * @param BookRequest $request
     * @return response()
     */
    public function create(BookRequest $request)
    {
        $bookData = $this->BookService->getBook($request);

        if($bookData) {
            $book = $this->BookService->updateBook($request);
        } else {
            $book = $this->BookService->saveBook($request);
        }

        if($book) {
            return response()->json([
                "status" => "success",
                "message" => "Book successfully created"
            ]);
        }
    }

    /**
     * delete a book
     *
     * @param Request $request
     * @return response()
     */
    public function delete(Request $request)
    {
        $this->BookService->deleteBook($request);

        return response()->json([
            "status" => "success",
            "message" => "You deleted a book."
        ]);
    }

    /**
     * Book Upload
     *
     * @param Request $request
     * @return response()
     */
    public function upload(Request $request)
    {
        Excel::import(new BookImport, $request->file('import_file'));
               
        return response()->json([
            "status" => "success",
            "message" => "You successfully upload."
        ]);
    }

    /**
     * Book Download
     * 
     * @return \Illuminate\Support\Collection
     */
    public function download() 
    {
        return Excel::download(new BookExport, 'books.xlsx');
    }

    /**
     * get Book by id
     *
     * @param $id
     * @return response()
     */
    public function bookData($id)
    {
        $book = Book::findOrFail($id);

        if($book) {
            return response()->json([
                "status" => "success",
                "book" => $book
            ]);
        }
    }
}
