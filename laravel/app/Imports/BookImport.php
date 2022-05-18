<?php

namespace App\Imports;

use App\Models\Book;
use Maatwebsite\Excel\Concerns\ToModel;

class BookImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Book([
            'user_id'     => 1,
            'title'     => $row[0],
            'description'    => $row[1], 
            'author'    => $row[2], 
            'price'    => $row[3], 
            'number_of_books'    => $row[4], 
        ]);
    }
}
