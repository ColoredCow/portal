<?php

namespace Modules\HR\Observers\Recruitment;

use Modules\HR\Entities\Job;
use Modules\HR\Entities\Round;
use Corcel\Model\Post as Corcel;

class JobObserver
{
    /**
     * Listen to the Job create event.
     *
     * @param  \Modules\HR\Entities\Job  $job
     * @return void
     */
    public function created(Job $job)
    {
        $job->rounds()->attach(Round::all()->pluck('id')->toArray());
        $data = request()->all();

        if ($data['status'] == 'published') {
            $Corcel = new Corcel();
            $Corcel->post_title = $data['title'];
            $Corcel->post_content = $data['description'];
            $Corcel->post_type = 'career';
            $Corcel->save();
            $Corcel->saveMeta('hr_id', $job['id']);
        }
    }

    /**
     * Listen to the Job update event.
     *
     * @param  \Modules\HR\Entities\Job  $job
     * @return void
     */
    public function updated(Job $job)
    {
        $data = request()->all();

        if ($data['status'] == 'published') {
            $Corcel = new Corcel();
            $Corcel->post_title = $data['title'];
            $Corcel->post_content = $data['description'];
            $Corcel->post_type = 'career';
            $Corcel->save();
            $Corcel->saveMeta('hr_id', $job['id']);
            $post = Corcel::hasMeta('hr_id', $job['id'])->first();
            $corcel = Corcel::find($post->ID);
            $corcel->delete();
        }
    }

    /**
     * Listen to the Job delete event.
     *
     * @param  \Modules\HR\Entities\Job  $job
     * @return void
     */
    public function deleted(Job $job)
    {
        Corcel::where(['post_type' => 'career', 'post_title' => $job['title']])->delete();
    }
}
