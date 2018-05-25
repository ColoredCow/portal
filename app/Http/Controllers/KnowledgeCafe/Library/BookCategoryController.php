<?php

namespace App\Http\Controllers\KnowledgeCafe\Library;

use App\Models\KnowledgeCafe\Library\BookCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
        $categories = BookCategory::with('books')->orderBy('name')->get();
        return view('knowledgecafe.library.categories.index')
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
     * @param  \Illuminate\Http\Request  $request
     *  @return void
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\KnowledgeCafe\Library\BookCategory  $bookCategory
     *  @return void
     */
    public function show(BookCategory $bookCategory)
    {
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\KnowledgeCafe\Library\BookCategory  $bookCategory
     * @return void
     */
    public function edit(BookCategory $bookCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\KnowledgeCafe\Library\BookCategory  $bookCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BookCategory $bookCategory)
    {
        $name = $request->input('name', '');
        if(!$name) {
            return response()->json(['success' => false]);
        }
        return response()->json(['success' => $bookCategory->update(['name' => $name]) ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\KnowledgeCafe\Library\BookCategory  $bookCategory
     * @return void
     */
    public function destroy(BookCategory $bookCategory)
    {
        return response()->json(['success' => $bookCategory->delete() ]);
    }

     /**
     * @param  Array  $categories
     * @return Array
     */
    public function formatCategoryData($categories) {
        $data = [];
        foreach($categories as $category) {
            $data[] = [
                'id' => $category->id,
                'name' =>  $category->name,
                'assign_books_count' => $category->books->count()
            ];
        }
        return $data;
    }
}
