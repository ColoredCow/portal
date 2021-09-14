<?php

namespace Modules\HR\Http\Controllers;

use Modules\HR\Http\Requests\TagRequest;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Models\Tag;

class TagsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $attr['tags'] = Tag::orderBy('name')->get();

        return view('hr::tags.index')->with($attr);
    }

    public function store(Request $request)
    {
        $tag = Tag::create([
            'name' => $request['name'],
            'description' => $request['description'] ?? null,
            'background_color' => $request['color']
        ]);

        return redirect(route('hr.tags.index'))->with('status', 'Tag created successfully!');
    }

    public function edit(Tag $tag)
    {
        return view('hr::tags.edit')->with(['tag' => $tag]);
    }

    public function update(TagRequest $request, Tag $tag)
    {
        $validated = $request->validated();
        $tag->update([
            'name' => $request['name'],
            'description' => $request['description'] ?? null,
            'background_color' => $request['color']
        ]);

        return redirect(route('hr.tags.index'))->with('status', 'Tag updated successfully!');
    }

    public function destroy(Tag $tag)
    {
        $tag->delete();

        return redirect(route('hr.tags.index'))->with('status', 'Tag deleted successfully!');
    }
}
