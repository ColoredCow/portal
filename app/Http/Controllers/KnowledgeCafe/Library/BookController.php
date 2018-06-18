<?php

namespace App\Http\Controllers\KnowledgeCafe\Library;

use App\Http\Controllers\Controller;
use App\Services\BookServices;
use App\Http\Requests\KnowledgeCafe\Library\BookRequest;
use App\Models\KnowledgeCafe\Library\Book;
use App\Models\KnowledgeCafe\Library\BookCategory;
use Illuminate\Http\Request;

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
        $searchString = (request()->has('search')) ? request()->input('search'): false;
        $books = Book::getList($searchString);
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
        $validatedData = $request->validated();
        $ISBN = isset($validatedData['isbn']) ? $validatedData['isbn'] : null;
        $stored = Book::firstOrCreate(['isbn' => $ISBN], $validatedData);
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
     * @return json
     */
    public function update(BookRequest $request, Book $book)
    {
        $validatedData = $request->validated();
        if (!isset($validatedData['categories'])) {
            return response()->json([
                'isUpdated' => false
            ]);
        }
        $categories = array_pluck($validatedData['categories'], 'id');
        $isUpdated = $book->categories()->sync($categories);
        return response()->json(['isUpdated' => $isUpdated]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\KnowledgeCafe\Library\Book  $book
     * @return void
     */
    public function destroy(Book $book)
    {
        return response()->json(['isDeleted' => $book->delete() ]);
    }


    /**
    * Fetch the book info.
    *
    * @param  \App\Http\Requests\BookRequest  $request
    * @return \Illuminate\Http\JsonResponse
    */
    public function fetchBookInfo(BookRequest $request)
    {
        $validated = $request->validated();
        $method = $validated['add_method'];

        if ($method === 'from_image' && $request->hasFile('book_image')) {
            $file = $request->file('book_image');
            $ISBN = BookServices::getISBN($file);
        } elseif ($method ==='from_isbn') {
            $ISBN = $validated['isbn'];
        }

        if (!$ISBN || strlen($ISBN) < 13) {
            return response()->json([
                'error' => true,
                'message' => 'Invalid ISBN : '. $ISBN
            ]);
        }

        $book = Book::where('isbn', $ISBN)->first();

        if ($book) {
            return response()->json([
                'error' => false,
                'book' => $book
            ]);
        }

        $book= BookServices::getBookDetails($ISBN);

        if (!isset($book['items'])) {
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
    public function formatBookData($book)
    {
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

    public function markBook(Request $request)
    {
        $bookID = $request->book_id;
        $read = $request->is_read;
        $book = Book::find($bookID);
        $isMarked = ($book) ? $book->markBook($read) : false;
        return response()->json([
            'isMarked' => $isMarked,
            'readers' => $book->readers
        ]);
    }

    public function getBookList()
    {
        $books = (request()->has('cat')) ?
                Book::getByCategoryName(request()->input('cat')) :
                Book::with(['categories'])->orderBy('title')
                ->get();

        $data = [];
        foreach ($books as $index => $book) {
            $data['books'][$index] = $book->toArray();
            $data['books'][$index]['thumbnail'] = $book->getThumbnailBySize();
            $data['books'][$index]['categories'] = $book->categories()->pluck('name')->toArray();
        }

        $data['categories'] = BookCategory::has('books')->pluck('name')->toArray();
        return response()->json($data);
    }

    public function addToUserWishList()
    {
        $bookID = request()->book_id;
        $book = Book::find($bookID);
        $isAdded = ($book) ? $book->addToUserWishlist() : false;
        return response()->json([
            'isAdded' => $isAdded
        ]);
    }

    public function disableSuggestion()
    {
        session(['disable_book_suggestion' => true]);
        return redirect()->back()->with('status', 'Book suggestions has been disabled.');
    }

    public function enableSuggestion()
    {
        session(['disable_book_suggestion' => false]);
        return redirect()->back()->with('status', 'Book suggestions has been enabled.');
    }
}
