<?php

namespace App\Exports;

use App\Models\Book;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;


class BookExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Book::select("title", "description", "author", "price", "number_of_books")
                    ->get();
    }
  
    /**
     * header
     *
     * @return response()
     */
    public function headings(): array
    {
        return ["Title", "Description", "Author", "Price", "Number of Books"];
    }
}
