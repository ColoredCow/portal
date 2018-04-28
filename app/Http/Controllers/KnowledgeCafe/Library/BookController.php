<?php

namespace App\Http\Controllers\KnowledgeCafe\Library;

use App\Http\Controllers\Controller;
use App\Services\BookServices;
use App\Http\Requests\KnowledgeCafe\Library\BookRequest;
use App\Models\KnowledgeCafe\Library\Book;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $books = Book::all();
        return view('knowledgecafe.library.books.index', compact('books'));
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
     * @param  \App\Http\Requests\BookRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BookRequest $request)
    {

        $book = Book::create($request->validated());
        return response()->json(['error'=> false]);
    }

    /**
     * Display the specified resource.
     *
     * @param  App\Models\KnowledgeCafe\Library\Book  $book
     * @return \Illuminate\View\View
     */
    public function show(Book $book)
    {
        return view('knowledgecafe.library.books.show', compact('book'));
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
     * @param  \App\Http\Requests\BookRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetchBookInfo(BookRequest $request) {
        $validated = $request->validated();
        $method = $validated['add_method'];

        if($method === 'from_image' && $request->hasFile('book_image')) {
            $file = $request->file('book_image');
            $ISBN = BookServices::getISBN($file);
        } else if($method ==='from_isbn') {
            $ISBN = $request->input('isbn');
        } 
        
        if(!$ISBN || strlen($ISBN) < 13) {
            return response()->json([
                'error' => true, 
                'message' => 'Invalid ISBN : '. $ISBN
            ]);
        }

        $book= BookServices::getBookDetails($ISBN);

        if(!isset($book['items'])) {
            return response()->json([
                'error' => true, 
                'message' => 'Invalid ISBN : '. $ISBN
            ]);
        }

        $book = $this->formatBookData($book);
        $book['isbn'] = $ISBN;

        return response()->json([
            'error' => false, 
            'book' => $book
        ]);
    }

    /**
     * @param  Array  $book
     * @return Array
     */
    public function formatBookData($book) {
        $data = []; 
        $book = $book['items'][0];
        $info = $book['volumeInfo'];
        $data['title'] = $info['title'];
        $data['author'] = implode($info['authors']);
        $data['readable_link'] = $book["accessInfo"]["webReaderLink"];
        $data['categories'] = implode($info['categories']);
        $data['thumbnail'] = $info['imageLinks']['thumbnail'];
        return $data;
    }   
    
}

