<?php

namespace Modules\Media\Http\Controllers;

use Modules\Media\Entities\MediaTag;
use Modules\Media\Http\Requests\MediaTagRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;

class MediaTagController extends Controller
{
    /**
    * Display a listing of the resource.
    * @return Renderable
    */
    public function index()
    {
        $mediaTag = MediaTag::orderBy('id', 'desc')->paginate(24);

        return view('media::media.mediaTag.index', ['tags' => $mediaTag]);
    }

    /**
     * Show the form for creating a new resource.
     * @return RedirectResponse
     * Store a newly created resource in DB.
     * @param MediaTagRequest $request
     * @return RedirectResponse
     */
    public function store(MediaTagRequest $request)
    {
        $validated = $request->validated();

        $tagsData = [
            'media_tag_name	' => $validated['media_tag_name	'],
            'media_type' => null,
        ];
        MediaTag::create($tagsData);

        return redirect(route('mediaTag.index'))->with(['message', 'status' => 'Tag added successfully!']);
    }

    /**
     * Update the specified resource in DB.
     * @param Request $request
     * @param MediaTag $mediaTag
     * @return RedirectResponse
     */
    public function update(Request $request, MediaTag $mediaTag)
    {
        $tagsData = [
            'media_tag_name' => $request->media_tag_name,
        ];
        $mediaTag->update($tagsData);

        return redirect(route('media.index'))->with(['message', 'status' => 'media updated successfully!']);
    }

    /**
     * Remove the specified resource from DB.
     * @param MediaTag $mediaTag
     * @return RedirectResponse
     */
    public function destroy(MediaTag $mediaTag)
    {
        $mediaTag->delete();

        return redirect(route('media.index'))->with(['message', 'status' => 'Tag deleted successfully!']);
    }
}
