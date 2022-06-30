<?php

namespace Modules\HR\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Modules\HR\Entities\Job;
use App\Models\Category;

class ResourcesController extends Controller
{
    public function index()
    {
        $jobs = Job::all();
        
        return view('hr::guidelines-resources.index', compact('jobs'));
    }

    public function show()
    {
        $categories = Category::all();

        return view('hr::guidelines-resources.show', compact('categories'));
    }

    public function store(Request $request)
    {
        $category = Category::create([
            'name' => $request['name'],
            'slug' => str_slug($request['name'], '-')
        ]);

        return redirect()->back();
    }
}
