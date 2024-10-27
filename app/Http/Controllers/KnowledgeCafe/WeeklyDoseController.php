<?php
namespace App\Http\Controllers\KnowledgeCafe;

use App\Http\Controllers\Controller;
use App\Http\Requests\KnowledgeCafe\WeeklyDoseRequest;
use App\Models\KnowledgeCafe\WeeklyDose;

class WeeklyDoseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $this->authorize('list', WeeklyDose::class);

        return view('weeklydose')->with([
            'weeklydoses' => WeeklyDose::latest()->paginate(config('constants.pagination_size')),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  WeeklyDoseRequest  $request
     *
     * @return WeeklyDose
     */
    public function store(WeeklyDoseRequest $request)
    {
        $validated = $request->validated();

        return WeeklyDose::create([
            'description' => $validated['description'],
            'url' => $validated['url'],
            'recommended_by' => $validated['recommended_by'],
        ]);
    }
}
