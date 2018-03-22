<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\HR\Job;
use App\Models\HR\Round;
use Illuminate\Http\Request;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = session('oauthuser');
        if (!$user) {
            return redirect('logout');
        }
        return view('hr.job.index')->with([
            'user' => $user,
            'jobs' => Job::with('applicants')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $title = $request->input('title');
        $postedBy = urldecode($request->input('by'));
        $link = urldecode($request->input('link'));

        $job = new Job();
        $job->title = $title;
        $job->posted_by = $postedBy;
        $job->link = $link;

        return json_encode($job->save());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = session('oauthuser');
        if (!$user) {
            return redirect('logout');
        }
        return view('hr.job.edit')->with([
            'user' => $user,
            'job' => Job::with('rounds')->find($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $facebook_post = $request->input('facebook_post');
        $instagram_post = $request->input('instagram_post');
        $twitter_post = $request->input('twitter_post');
        $linkedin_post = $request->input('linkedin_post');

        $rounds = $request->input('rounds');

        $job = Job::find($id);

        $job->rounds()->sync($rounds, false);

        $job->facebook_post = $facebook_post;
        $job->instagram_post = $instagram_post;
        $job->twitter_post = $twitter_post;
        $job->linkedin_post = $linkedin_post;

        $job->save();

        return redirect("/hr/jobs/$id/edit");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
