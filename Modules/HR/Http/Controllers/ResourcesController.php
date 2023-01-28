<?php

namespace Modules\HR\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Modules\HR\Entities\Job;
use App\Models\Category;
use App\Models\Resource;
use App\Models\UsersResourcesAndGuidelines;

class ResourcesController extends Controller
{
    public function index()
    {
        $resources = Resource::all();
        $categories = Category::all();
        $usersResourcesAndGuidelines = UsersResourcesAndGuidelines::get();

        return view('hr::guidelines-resources.index', compact('resources', 'categories', 'usersResourcesAndGuidelines'));
    }

    public function getUserSuggestionAndAvatar($id)
    {
        $userResources = UsersResourcesAndGuidelines::where('id', $id)->first();

        return response()->json([
            'suggestion' => $userResources->post_suggestions,
            'avatar' => $userResources->employee->user->avatar
        ]);
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

        return redirect()->back()->with('status', 'Resource deleted successfully!');
    }
}
