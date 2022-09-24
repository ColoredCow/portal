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

    public function update(MediaTagRequest $request, MediaTags $mediaTag)
    {
        $tagsData = [
            'media_tag_name' => $request->media_tag_name,
        ];
        $mediaTag->update($tagsData);

        return redirect(route('media.index'))->with(['message', 'status' => 'media updated successfully!']);
    }

    public function destroy(MediaTags $request, $id)
    {
        $mediaTag = $request->find($id);
        $mediaTag->delete();

        return redirect()->back()->with(['message', 'status' => 'Tag deleted successfully!']);
    }
}
