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
        $job_status = $job->status;
        $corcel = new Corcel();
        $corcel->post_title = $job->title;
        $corcel->post_content = $job->description;
        $corcel->post_type = config('hr.post-type.career');
        $corcel->post_name = str_replace(' ', '-', strtolower($job->title));
        $corcel->post_status = config('hr.opportunities-status-wp-mapping')[$job_status];
        $corcel->save();
        $corcel->saveMeta('hr_id', $job->id);
        $post = $corcel->hasMeta('hr_id', $job->id)->first();
        $term = Term::select('term_id')->where(['name' => $job->domain])->first();
        if ($term) {
            $relation = new TermRelationship();
            $relation->object_id = $post->ID;
            $relation->term_taxonomy_id = $term->term_id;
            $relation->save();
        }
        $job->opportunity_id = $post->ID;
        $job->save();
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
        $corcel = new Corcel();
        $job_status = $job->status;
        $post = $corcel->hasMeta('hr_id', $job->id)->first();
        $corcel = $post ? $corcel->find($post->ID) : null;
        $corcel->post_title = $job->title;
        $corcel->post_content = $job->description;
        $corcel->post_type = config('hr.post-type.career');
        $corcel->post_status = $job->status ? (config('hr.opportunities-status-wp-mapping')[$job_status]) : 'draft';
        $corcel->post_name = str_replace(' ', '-', strtolower($job->title));
        $corcel->update();
        $term = Term::select('term_id')->where(['name' => $job->domain])->first();
        if ($term) {
            $relation = TermRelationship::where(['object_id' => $post->ID])->update(['term_taxonomy_id' => $term->term_id]);
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
        if (! config('database.connections.wordpress.enabled')) {
            return;
        }
        Corcel::where(['post_type' => 'career', 'post_title' => $job['title']])->delete();
    }
}
