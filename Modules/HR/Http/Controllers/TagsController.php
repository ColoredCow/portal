<?php

namespace Modules\HR\Http\Controllers;

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
        $attr['tags'] = Tag::orderBy('tname')->get();

        return view('hr::tags.index')->with($attr);
    }

    public function store(Request $request)
    {
        $tag = Tag::create([
            'tname'=>$request['name'],
            'description'=>$request['description'] ?? null,
            'background_color'=>$request['color']
        ]);

        return redirect(route('hr.tags.index'))->with('status', 'Tag created successfully!');
    }

    public function edit(int $id)
    {
        $attr['tags'] = Tag::find($id);

        return view('hr::tags\edit')->with($attr);
    }

    public function update(Request $request, int $id)
    {
        $tag = Tag::find($id);
        $tag->update([
            'tname'=>$request['name'],
            'description'=>$request['description'] ?? null,
            'background_color'=>$request['color']
        ]);

        return redirect(route('hr.tags.index'))->with('status', 'Tag updated successfully!');
    }

    public function destroy($id)
    {
        Tag::destroy($id);

        return redirect(route('hr.tags.index'))->with('status', 'Tag deleted successfully!');
    }
}
