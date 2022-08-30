<?php

namespace Modules\HR\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Modules\HR\Entities\Job;
use App\Models\Category;
use App\Models\Resource;

class ResourcesController extends Controller
{
    public function index()
    {
        $jobs = Job::all();

        return view('hr::guidelines-resources.index', compact('jobs'));
    }

    public function show($job)
    {
        $job = Job::find($job);

        $resources = $job->resources;

        $categories = Category::all();

        return view('hr::guidelines-resources.show', compact('categories', 'resources', 'job'));
    }

    public function store(Request $request)
    {
        $category = Category::create([
            'name' => $request['name'],
            'slug' => str_slug($request['name'], '-')
        ]);

        return redirect()->back();
    }

    public function create(Request $request)
    {
        $resources = Resource::create([
            'resource_link' => $request['resource_link'],
            'hr_resource_category_id' => $request['category-type'],
            'job_id' => $request['job_id'],
        ]);

        return redirect()->back();
    }

    public function update(Request $request, Resource $resource)
    {
        $resource->update([
            'resource_link' => $request['name'],
            'hr_resource_category_id' => $request['category-type']
        ]);

        return redirect()->back()->with('status', 'Category updated successfully!');
    }

    public function destroy(Resource $resource)
    {
        $resource->delete();

        return redirect()->back()->with('status', 'Category deleted successfully!');
    }
}
