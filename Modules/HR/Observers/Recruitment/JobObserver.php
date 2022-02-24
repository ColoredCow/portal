<?php

namespace Modules\HR\Observers\Recruitment;

use Modules\HR\Entities\Job;
use Modules\HR\Entities\Round;
use Corcel\Model\Post as Corcel;
use Corcel\Model\TermRelationship as TermRelationship;
use Corcel\Model\Term as Term;

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
        if (! config('database.connections.wordpress.enabled')) {
            return;
        }
        $job->rounds()->attach(Round::pluck('id')->toArray());
        $data = request()->all();
        $corcel = new Corcel();
        $corcel->post_title = $data['title'];
        $corcel->post_content = $data['description'];
        $corcel->post_type = config('hr.post-type.career');
        $corcel->post_name = str_replace(' ', '-', strtolower($data['title']));
        if ($data['status'] == 'published') {
            $corcel->post_status = 'publish';
        } elseif ($data['status'] == 'archived') {
            $corcel->post_status = 'archived';
        } elseif ($data['status'] == 'pending review') {
            $corcel->post_status = 'Pending';
        } else {
            $corcel->post_status = 'draft';
        }
        $corcel->save();
        $corcel->saveMeta('hr_id', $job['id']);
        $post = $corcel->hasMeta('hr_id', $job['id'])->first();
        $term = Term::select('term_id')->where(['name' => $data['domain']])->first();
        $relation = new TermRelationship();
        $relation->object_id = $post->ID;
        $relation->term_taxonomy_id = $term->term_id;
        $relation->save();
    }

    /**
     * Listen to the Job update event.
     *
     * @param  \Modules\HR\Entities\Job  $job
     * @return void
     */
    public function updated(Job $job)
    {
        if (! config('database.connections.wordpress.enabled')) {
            return;
        }
        $data = request()->all();
        $corcel = new Corcel();
        $post = $corcel->hasMeta('hr_id', $job['id'])->first();
        $corcel = $corcel->find($post->ID);
        $corcel->post_title = $data['title'];
        $corcel->post_content = $data['description'];
        $corcel->post_type = config('hr.post-type.career');
        if ($data['status'] == 'published') {
            $corcel->post_status = 'publish';
        } elseif ($data['status'] == 'archived') {
            $corcel->post_status = 'archived';
        } elseif ($data['status'] == 'pending review') {
            $corcel->post_status = 'Pending';
        } else {
            $corcel->post_status = 'draft';
        }
        $corcel->post_name = str_replace(' ', '-', strtolower($data['title']));
        $corcel->update();
        $term = Term::select('term_id')->where(['name' => $data['domain']])->first();
        $relation = TermRelationship::where(['object_id' => $post->ID])->update(['term_taxonomy_id' => $term->term_id]);
    }

    /**
     * Listen to the Job delete event.
     *
     * @param  \Modules\HR\Entities\Job  $job
     * @return void
     */
    public function deleted(Job $job)
    {
        if (! config('database.connections.wordpress.enabled')) {
            return;
        }
        Corcel::where(['post_type' => 'career', 'post_title' => $job['title']])->delete();
    }
}
