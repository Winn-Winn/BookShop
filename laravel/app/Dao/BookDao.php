<?php

namespace App\Dao;

use App\Contracts\Dao\BookDaoInterface;
use App\Models\Book;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * BookDao
 *
 * @author
 */
class BookDao implements BookDaoInterface
{
    /**
     * saveBook
     *
     * @param $request
     * @return
     */
    public function saveBook($request) {
        DB::beginTransaction();
        try {
            DB::table('books')->insert([
                'user_id' => Auth::user()->id,
                'title' => $request['title'],
                'description' => $request['description'],
                'author'=> $request['author'],
                'price'=> $request['price'],
                'number_of_books'=> $request['books_num'],
                'created_at'=> now(),
                'updated_at'=> now(),
            ]);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
        }
    }

    /**
     * updateBook
     *
     * @param $request
     * @return
     */
    public function updateBook($request) {
        DB::beginTransaction();
        $old_book = Book::select("books.*")
                            ->where("title", $request['title'])
                            ->first();
            
        if ($old_book) {  
            try {
                $insertData = array(
                    'title'=> $request['title'],
                    'description'=> $request['description'],
                    'author'=> $request['author'],
                    'price'=> $request['price'],
                    'number_of_books'=> $request['books_num'],
                    'updated_at'=> now(),
                );
                Book::select("books.*")
                    ->where("title", $request['title'])
                    ->update($insertData);

                DB::commit();
                return true;
            } catch (\Exception $e) {
                DB::rollback();
            }
        }
        return false;
    }

    /**
     * getBooksList
     *
     * @param $request
     * @return
     */
    public function getBooksList($request) {
        $sql = "SELECT
                        *
                    FROM
                        books
                    WHERE books.deleted_at IS NULL";

        $param = [];

        if ($request['title'] != "") {
            $sql = $sql.' AND books.title = :title';
            $param['title'] = $request['title'];
        }

        if ($request['author'] != "") {
            $sql = $sql.' AND books.author = :author';
            $param['author'] = $request['author'];
        }

        if ($request['price'] != "") {
            $sql = $sql.' AND books.price = :price';
            $param['price'] = $request['price'];
        }

        $booksList = DB::select($sql, $param);
        return $booksList;
    }

    public function getBook($request) {
        $book = "SELECT
                    *
                FROM
                    books
                WHERE
                    books.title = :title
                AND books.deleted_at IS NULL";

        $param = ["title" => $request['title']];
        $bookData = DB::select($book, $param);
        return $bookData;
    }

    /**
     * deleteBook
     * 
     * @param $request
     * @return 
    */
    public function deleteBook($request) {
        Book::find($request['book_id'])->delete();

        return true;
    }
}