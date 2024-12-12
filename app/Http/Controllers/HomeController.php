<?php

namespace App\Http\Controllers;

use App\Models\KnowledgeCafe\Library\Book; // Add this line to import the Book model
use Illuminate\Http\Request;
use Modules\User\Entities\UserMeta;
use Illuminate\Http\RedirectResponse;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     */
    public function index()
    {

        $unreadBook = session('disable_book_suggestion') ? null : Book::getRandomUnreadBook();

        $selectedLocation = auth()->user()->office_location ?? 'Default Location';

        return view('home')->with([
            'book' => $unreadBook,
            'selectedLocation' => $selectedLocation,
        ]);
    }

    /**
     * Store the user's office location.
     *
     * @param  Request  $request
     * @return RedirectResponse
     */
    public function storeEmployeeLocation(Request $request): RedirectResponse
    {

        $request->validate([
            'centre_name' => 'required|string|max:255',
        ]);

        UserMeta::updateOrCreate(
            ['user_id' => auth()->user()->id, 'meta_key' => 'office_location'],
            ['meta_value' => $request->centre_name]
        );

        return redirect()->route('home')->with('status', 'Location updated successfully!');
    }
}
