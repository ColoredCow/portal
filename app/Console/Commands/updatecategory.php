<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class updatecategory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:category';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
       $rows = \DB::table('library_books2')->get();

       foreach($rows as $row) {
           $bookID = \DB::table('library_books')->where('isbn', $row->isbn)->pluck('id')->first();
           $categoryID = \DB::table('book_categories')->where('name', $row->categories)->pluck('id')->first();
           $this->info("Book ID " . $bookID);
           $this->info("Category ID " . $categoryID);

           if($bookID && $categoryID)
           \DB::table('library_book_category')->insert([ 'book_category_id' => $categoryID, 'library_book_id' => $bookID]);
       }
    }
}
