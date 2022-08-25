<?php

namespace Modules\Media\Http\Controllers;

use Modules\Media\Entities\PhotoGallery;
use Illuminate\Contracts\Support\RedirectResponse;
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
        $photo_gallery = PhotoGallery::orderBy('id', 'desc')->paginate(24);
        return view('media::photo-gallery.index', ['photo_gallery' => $photo_gallery]);
    }

    /**
     * Show the form for creating a new resource.
     * @return RedirectResponse
     * Store a newly created resource in storage.
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'event_name' => 'required',
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
          ]);
        $imageName = time() . '.' . $request->file->extension();
        $request->file->storeAs('public/images', $imageName);
      
        $postData = ['event_name' => $request->event_name, 'img_url' => $imageName, 'uploaded_by' => Auth()->user()->id, 'description' => $request->description];
        PhotoGallery::create($postData);
        return redirect('/photo-gallery')->with(['message', 'status' => 'Photo added successfully!']);
    }

    /**
     * Show the specified resource.
     * @param $photoGallery
     * @return Renderable
     */
    public function show(PhotoGallery $photoGallery)
    {
        return view('media::photo-gallery.show', ['photoGallery' => $photoGallery]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param $PhotoGallery
     * @return Renderable
     */
    public function edit(PhotoGallery $PhotoGallery)
    {
        return view('media::photo-gallery.edit', ['PhotoGallery' => $PhotoGallery]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param $PhotoGallery
     * @return RedirectResponse
     */
    public function update(Request $request, PhotoGallery $PhotoGallery)
    {
        $imageName = '';
        if ($request->hasFile('file')) {
            $imageName = time() . '.' . $request->file->extension();
            $request->file->storeAs('public/images', $imageName);
            if ($PhotoGallery->img_url) {
                Storage::delete('public/images/' . $PhotoGallery->img_url);
            }
        } else {
            $imageName = $PhotoGallery->img_url;
        }
        $postData = ['event_name' => $request->event_name, 'img_url' => $imageName, 'uploaded_by' => Auth()->user()->id, 'description' => $request->description];
        $PhotoGallery->update($postData);
        return redirect('/photo-gallery')->with(['message', 'status' => 'Photo updated successfully!']);
    }
    /**
     * Remove the specified resource from storage.
     * @param $PhotoGallery
     * @return RedirectResponse
     */
    public function destroy(PhotoGallery $PhotoGallery)
    {
        Storage::delete('public/images/' . $PhotoGallery->img_url);
        $PhotoGallery->delete();
        return redirect('/photo-gallery')->with(['message', 'status' => 'Photo deleted successfully!']);
    }
}
