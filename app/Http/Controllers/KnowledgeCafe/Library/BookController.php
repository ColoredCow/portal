<?php

namespace App\Http\Controllers\KnowledgeCafe\Library;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\BookServices;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('knowledgecafe.library.books.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('knowledgecafe.library.books.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return @return void
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return @return void
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return @return void
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return @return void
     */
    public function destroy($id)
    {
        //
    }


     /**
     * Fetch the book info.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return @return json
     */
    public function fetchBookInfo(Request $request) {
        $method = $request->input('add_method');

        if($method === 'from_image') {
            $file = $request->file('book_image');
            $ISBNNumber = BookServices::getISBN($file);

            if(!$ISBNNumber || strlen($ISBNNumber) < 13) {
                return json_encode(['view'=> null, 'error' => true, 'message' => 'Could not fetch valid ISBN : '. $ISBNNumber]);
            }
            $book= BookServices::getBookDetails($ISBNNumber);
        } 

        if($method ==='from_isbn') {
            $ISBNNumber = $request->input('isbn');
            $book = BookServices::getBookDetails($ISBNNumber);
        }  

        if(!isset($book['items'])) {
            return json_encode(['view'=> null, 'error' => true, 'message' => 'Invalid ISBN : '. $ISBNNumber]);
        }

        $book = $book['items'][0];
        $info = $book['volumeInfo'];
        $view = view('knowledgecafe.library.books.info')->with(['info' => $info, 'book' => $book])->render();

        return json_encode(['view'=> $view, 'error' => false, 'book' => $book]);
    }
}
