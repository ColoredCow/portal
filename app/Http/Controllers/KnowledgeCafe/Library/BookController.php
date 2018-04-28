<?php

namespace App\Http\Controllers\KnowledgeCafe\Library;

use App\Http\Controllers\Controller;
use App\Services\BookServices;
use App\Http\Requests\KnowledgeCafe\Library\BookRequest;

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
     * @param  \App\Http\Requests\BookRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetchBookInfo(BookRequest $request) {
        $validated = $request->validated();
        $method = $validated['add_method'];
        $ISBN = null;
        
        if($method === 'from_image' && $request->hasFile('book_image')) {
            $file = $request->file('book_image');
            $ISBN = BookServices::getISBN($file);
        } else if ($method ==='from_isbn') {
            $ISBN = $request->input('isbn');
        }

        if(!$ISBN || strlen($ISBN) < 13) {
            return response()->json([
                'view'=> null, 
                'error' => true, 
                'message' => 'Invalid ISBN : '. $ISBN
            ]);
        }

        $book= BookServices::getBookDetails($ISBN);

        if(!isset($book['items'])) {
            return response()->json([
                'view'=> null, 
                'error' => true, 
                'message' => 'Invalid ISBN : '. $ISBN
            ]);
        }

        $book = $book['items'][0];
        $info = $book['volumeInfo'];
        $view = view('knowledgecafe.library.books.info')->with(['info' => $info, 'book' => $book])->render();

        return response()->json([
            'view'=> $view, 
            'error' => false, 
            'book' => $book
        ]);
    }
}
