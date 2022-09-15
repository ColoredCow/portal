<?php

namespace App\Http\Controllers\KnowledgeCafe\Library;

use App\Http\Controllers\Controller;
use App\Http\Requests\KnowledgeCafe\Library\BookRequest;
use App\Models\KnowledgeCafe\Library\Book;
use App\Models\KnowledgeCafe\Library\BookAMonth;
use App\Models\KnowledgeCafe\Library\BookCategory;
use App\Services\BookServices;
use Carbon\Carbon;
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
    public function index(Request $request)
    {
        $this->authorize('list', Book::class);
        $searchCategory = $request->category_name ?? false;
        $searchString = (request()->has('search')) ? request()->input('search') : false;
        $filter_by = request()->input('filter_by') ?? null;
        $books = Book::getList($searchString, $filter_by);
        $categories = BookCategory::orderBy('name')->get();

        if (request()->has('wishlist')) {
            $books = auth()->user()->booksInWishlist;
        } else {
            $books = Book::getList($searchString, $filter_by);
        }
        $books = $searchCategory ? Book::getByCategoryName($searchCategory) : Book::getList($searchString);
        $loggedInUser = auth()->user();
        $books->load('wishers');

        return view('knowledgecafe.library.books.index', compact('books', 'loggedInUser', 'categories'));
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
     * @param  BookRequest  $request
     */
    public function store(BookRequest $request)
    {
        $validatedData = $request->validated();
        $ISBN = isset($validatedData['isbn']) ? $validatedData['isbn'] : null;
        $stored = Book::firstOrCreate(['isbn' => $ISBN], $validatedData);

        return response()->json(['error' => false]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\KnowledgeCafe\Library\Book  $book
     * @return \Illuminate\View\View
     */
    public function show(Book $book)
    {
        $isBookAMonth = $book->bookAMonths()
            ->inCurrentYear()
            ->inCurrentMonth()
            ->where('user_id', auth()->user()->id)
            ->get()
            ->isNotEmpty();

        return view('knowledgecafe.library.books.show', compact('book', 'isBookAMonth'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\KnowledgeCafe\Library\BookRequest  $request
     * @param  \App\Models\KnowledgeCafe\Library\Book  $book
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(BookRequest $request, Book $book)
    {
        $validatedData = $request->validated();
        if (isset($validatedData['number_of_copies'])) {
            $book->number_of_copies = $validatedData['number_of_copies'];
            $book->save();

            return response()->json(['isUpdated' => $book]);
        }
        if (isset($validatedData['categories'])) {
            $categories = array_pluck($validatedData['categories'], 'id');
            $isUpdated = $book->categories()->sync($categories);

            return response()->json(['isUpdated' => $isUpdated]);
        }

        return response()->json(['isUpdated' => false]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\KnowledgeCafe\Library\Book  $book
     */
    public function destroy(Book $book)
    {
        return response()->json(['isDeleted' => $book->delete()]);
    }

    /**
     * Fetch the book info.
     *
     * @param  BookRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetchBookInfo(BookRequest $request)
    {
        $validated = $request->validated();
        $method = $validated['add_method'];
        $ISBN = null;

        if ($method === 'from_image' && $request->hasFile('book_image')) {
            $file = $request->file('book_image');
            $ISBN = BookServices::getISBN($file);
        } elseif ($method === 'from_isbn') {
            $ISBN = $validated['isbn'];
        }

        if (! $ISBN || strlen($ISBN) < 13) {
            return response()->json([
                'error' => true,
                'message' => 'Invalid ISBN : ' . $ISBN,
            ]);
        }

        $book = Book::where('isbn', $ISBN)->first();

        if ($book) {
            return response()->json([
                'error' => false,
                'book' => $book,
            ]);
        }

        $book = BookServices::getBookDetails($ISBN);

        if (! isset($book['items'])) {
            return response()->json([
                'error' => true,
                'message' => 'Invalid ISBN : ' . $ISBN,
            ]);
        }

        $book = $this->formatBookData($book);
        $book['isbn'] = $ISBN;

        return response()->json([
            'error' => false,
            'book' => $book,
        ]);
    }

    /**
     * @param  array  $book
     * @return array
     */
    public function formatBookData($book)
    {
        $data = [];
        $book = $book['items'][0];
        $info = collect($book['volumeInfo']);
        $book = collect($book);
        $data['title'] = $info->get('title');
        $data['author'] = implode($info->get('authors', []));
        $data['readable_link'] = $book->get('accessInfo')['webReaderLink'];
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
            'readers' => $book->readers,
        ]);
    }

    public function markAsBorrowed(Book $book)
    {
        $book->markAsBorrowed();

        return response()->json([
            'isBorrowed' => true,
            'borrowers' => $book->borrowers,
        ]);
    }

    public function putBackToLibrary(Book $book)
    {
        $book->putBackToLibrary();

        return response()->json([
            'isBorrowed' => true,
            'borrowers' => $book->borrowers,
        ]);
    }

    public function getBooksCount()
    {
        $books = (request()->has('cat')) ?
        Book::getByCategoryName(request()->input('cat'))->count() :
        Book::count();

        return $books;
    }

    public function getBookList()
    {
        try {
            $pageNumber = ((int) request()->get('page', 1)) > 0 ? ((int) request()->get('page', 1)) : 1;
        } catch (\Exception $e) {
            $pageNumber = 1;
        }
        $books = (request()->has('cat')) ?
        Book::getByCategoryName(request()->input('cat')) :
        Book::with(['categories'])->orderBy('title')->skip(($pageNumber - 1) * 50)->take(50)->get();

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
        $isAdded = $book ? $book->addToWishlist() : false;

        return response()->json([
            'isAdded' => $isAdded,
        ]);
    }

    public function removeFromUserWishList()
    {
        $bookID = request()->book_id;
        $book = Book::find($bookID);
        $isAdded = $book ? $book->removeFromWishlist() : false;

        return response()->json([
            'isAdded' => $isAdded,
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

    public function selectBookForCurrentMonth(Book $book)
    {
        $book->selectBookForCurrentMonth();

        return response()->json(['isBookAMonth' => true]);
    }

    public function unselectBookFromCurrentMonth(Book $book)
    {
        $book->unselectBookFromCurrentMonth();

        return response()->json(['isBookAMonth' => false]);
    }

    public function bookAMonthIndex()
    {
        $booksCollection = BookAMonth::all()
            ->groupBy(function ($item) {
                return Carbon::parse($item->created_at)->format('Y');
            }, true)
            ->transform(function ($item) {
                return $item->groupBy(function ($item) {
                    return Carbon::parse($item->created_at)->format('n');
                }, 'desc');
            });

        return view('knowledgecafe.library.books.book-a-month')->with('booksCollection', $booksCollection);
    }
}
