<?php

namespace Modules\Media\Http\Controllers;

use Modules\Media\Entities\Media;
use Modules\Media\Http\Requests\MediaRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $media = Media::orderBy('id', 'desc')->paginate(24);

        return view('media::media.index', ['media' => $media]);
    }

    /**
     * Show the form for creating a new resource.
     * @return RedirectResponse
     * Store a newly created resource in storage.
     * @param MediaRequest $request
     * @return RedirectResponse
     */
    public function store(MediaRequest $request)
    {
        $request->validated();
        $imageName = time() . '.' . $request->file->extension();
        $request->file->storeAs('public/images', $imageName);
        $postData = ['event_name' => $request->event_name, 'img_url' => $imageName, 'uploaded_by' => Auth()->user()->id, 'description' => $request->description];
        Media::create($postData);

        return redirect(route('media.index'))->with(['message', 'status' => 'Photo added successfully!']);
    }

    /**
     * Show the specified resource.
     * @param Media $media
     * @return Renderable
     */
    public function show(Media $media)
    {
        return view('media::media.show', ['media' => $media]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param Media $media
     * @return Renderable
     */
    public function edit(Media $media)
    {
        return view('media::media.edit', ['Media' => $media]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param Media $Media
     * @return RedirectResponse
     */
    public function update(Request $request, Media $Media)
    {
        $imageName = '';
        if ($request->hasFile('file')) {
            $imageName = time() . '.' . $request->file->extension();
            $request->file->storeAs('public/images', $imageName);
            if ($Media->img_url) {
                Storage::delete('public/images/' . $Media->img_url);
            }
        } else {
            $imageName = $Media->img_url;
        }
        $postData = ['event_name' => $request->event_name, 'img_url' => $imageName, 'uploaded_by' => Auth()->user()->id, 'description' => $request->description];
        $Media->update($postData);

        return redirect(route('media.index'))->with(['message', 'status' => 'Photo updated successfully!']);
    }
    /**
     * Remove the specified resource from storage.
     * @param Media $media
     * @return RedirectResponse
     */
    public function destroy(Media $media)
    {
        Storage::delete('public/images/' . $media->img_url);
        $media->delete();

        return redirect(route('media.index'))->with(['message', 'status' => 'Photo deleted successfully!']);
    }
}
