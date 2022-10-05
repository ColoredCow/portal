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
        $validated = $request->validated();
        $path = config('media.path');
        $fileName = time() . '.' . $request->file->extension();

        $request->file->storeAs(
            $path,
            $fileName,
        );

        $postData = [
            'event_name' => $validated['event_name'],
            'description' => $validated['description'],
            'file_url' => $fileName,
            'uploaded_by' => Auth()->user()->id
        ];
        Media::create($postData);

        return redirect(route('media.index'))->with(['message', 'status' => 'Media added successfully!']);
    }

    /**
     * Show the specified resource.
     * @param Media $media
     * @return Renderable
     */
    public function show(Media $media)
    {
        $time = \Carbon\Carbon::parse($media->created_at)->diffForHumans();

        return view('media::media.show')->with([
            'media' => $media,
            'time' => $time
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param Media $media
     * @return Renderable
     */
    public function edit(Media $media)
    {
        return view('media::media.edit', ['media' => $media]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param Media $Media
     * @return RedirectResponse
     */
    public function update(Request $request, Media $Media)
    {
        $path = config('media.path');
        $fileName = '';
        if ($request->hasFile('file')) {
            $fileName = time() . '.' . $request->file->extension();
            $request->file->storeAs(
                $path,
                $fileName,
            );
            if ($Media->file_url) {
                Storage::delete($path . $Media->file_url);
            }
        } else {
            $fileName = $Media->file_url;
        }
        $postData = [
            'event_name' => $request->event_name,
            'description' => $request->description,
            'file_url' => $fileName,
            'uploaded_by' => Auth()->user()->id
        ];
        $Media->update($postData);

        return redirect(route('media.index'))->with(['message', 'status' => 'Media updated successfully!']);
    }
    /**
     * Remove the specified resource from storage.
     * @param Media $media
     * @return RedirectResponse
     */
    public function destroy(Media $media)
    {
        $path = config('media.path');
        Storage::delete($path . $media->file_url);
        $media->delete();

        return redirect(route('media.index'))->with(['message', 'status' => 'Media deleted successfully!']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function fileUploadPost(Request $request)
    {
        $fileName = time().'.'.$request->file->extension();

        $path = Storage::disk('s3')->put('file', $request->file);
        $path = Storage::disk('s3')->url($path);

        return back()
            ->with(['message', 'status' => 'You have successfully upload image.'])
            ->with('file', $path);
    }
}
