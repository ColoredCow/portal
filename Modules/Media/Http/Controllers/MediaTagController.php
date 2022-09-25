<?php

namespace Modules\Media\Http\Controllers;

use Modules\Media\Entities\MediaTags;
use Modules\Media\Http\Requests\MediaTagRequest;
use Illuminate\Routing\Controller;

class MediaTagController extends Controller
{
    public function index()
    {
        $mediaTag = MediaTags::all();

        return view('media::media.mediaTag.index')->with(['tags' => $mediaTag]);
    }

    public function store(MediaTagRequest $request)
    {
        $tagsData = new MediaTags();
        $tagsData->media_tag_name = $request['media_tag_name'];
        $tagsData->save();

        return redirect(route('media.Tag.index'))->with(['message', 'status' => 'Tag added successfully!']);
    }

    public function update(MediaTagRequest $request, $id)
    {
        $mediaData = MediaTags::find($id);

        $mediaData->media_tag_name = $request['media_tag_name'];
        $mediaData->save();

        return redirect()->back()->with(['message', 'status' => 'Tag updated successfully!']);
    }

    public function destroy(MediaTags $request, $id)
    {
        $mediaTag = $request->find($id);
        $mediaTag->delete();

        return redirect()->back()->with(['message', 'status' => 'Tag deleted successfully!']);
    }
}
