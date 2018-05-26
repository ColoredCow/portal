<?php

namespace App\Http\Controllers\KnowledgeCafe\Library;

use App\Http\Controllers\Controller;
use App\Services\BookServices;
use App\Http\Requests\KnowledgeCafe\Library\BookRequest;
use App\Models\KnowledgeCafe\Library\Book;
use App\Models\KnowledgeCafe\Library\BookCategory;

class BookController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Book::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $this->authorize('list', Book::class);
        $books = Book::with('categories')->orderBy('title')->paginate(config('constants.pagination_size'));
        $categories = BookCategory::orderBy('name')->get();
        return view('knowledgecafe.library.books.index', compact('books', 'categories'));
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
        $stored = Book::_create($request->validated());
        return response()->json(['error'=> !$stored]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\KnowledgeCafe\Library\Book  $book
     * @return \Illuminate\View\View
     */
    public function show(Book $book)
    {
        return view('knowledgecafe.library.books.show', compact('book'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\KnowledgeCafe\Library\Book  $book
     * @return void
     */
    public function edit(Book $book)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\KnowledgeCafe\Library\Book  $book
     * @return void
     */
    public function update(BookRequest $request, Book $book)
    {
        return response()->json([
            'success' => $book->_update($request->validated())
        ]); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\KnowledgeCafe\Library\Book  $book
     * @return void
     */
    public function destroy(Book $book)
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
            $ISBN = $validated['isbn'];
        }

        if(!$ISBN || strlen($ISBN) < 13) {
            return response()->json([
                'error' => true,
                'message' => 'Invalid ISBN : '. $ISBN
            ]);
        }

        $book = Book::where('isbn', $ISBN)->first();

        if($book) {
            return response()->json([
                'error' => false,
                'book' => $book
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
        $info = collect($book['volumeInfo']);
        $book = collect($book);
        $data['title'] = $info->get('title');
        $data['author'] = implode($info->get('authors', []));
        $data['readable_link'] = $book->get("accessInfo")["webReaderLink"];
        $data['categories'] = implode($info->get('categories', []));
        $data['thumbnail'] = $info->get('imageLinks')['thumbnail'];
        $data['self_link'] = $book->get('self_link');
        return $data;
    }

}

