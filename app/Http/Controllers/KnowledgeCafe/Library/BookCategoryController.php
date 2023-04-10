<?php

namespace App\Http\Controllers\KnowledgeCafe\Library;

use App\Models\KnowledgeCafe\Library\BookCategory;
use App\Models\KnowledgeCafe\Library\Book;
use App\Http\Controllers\Controller;
use App\Http\Requests\KnowledgeCafe\Library\BookCategoryRequest;

class BookCategoryController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(BookCategory::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $categories = BookCategory::withCount('books')->orderBy('name')->get();
        $books = Book::all();

        return view('knowledgecafe.library.categories.index')
        ->with('books', $books)
        ->with('categories', $this->formatCategoryData($categories));
    }

    /**
     * Show the form for creating a new resource.
     *
     *  @return void
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  BookCategoryRequest  $request
     */
    public function store(BookCategoryRequest $request)
    {
        return response()->json(['category' => BookCategory::firstOrCreate($request->validated())]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  BookCategoryRequest  $request
     * @param  BookCategory  $bookCategory
     */
    public function update(BookCategoryRequest $request, BookCategory $bookCategory)
    {
        return response()->json(
            ['isUpdated' => $bookCategory->update($request->validated())]
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\KnowledgeCafe\Library\BookCategory  $bookCategory
     */
    public function destroy(BookCategory $bookCategory)
    {
        return response()->json(['isDeleted' => $bookCategory->delete()]);
    }

    /**
     * @param mixed $categories
     */
    public function formatCategoryData($categories)
    {
        $data = [];
        foreach ($categories as $category) {
            $data[] = [
                'id' => $category->id,
                'name' =>  $category->name,
                'assign_books_count' => $category->books_count
            ];
        }

        return $data;
    }
}
