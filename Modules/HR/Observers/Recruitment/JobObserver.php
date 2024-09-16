<?php

namespace Modules\HR\Observers\Recruitment;

use Corcel\Model\Option as Option;
use Corcel\Model\Post as Corcel;
use Corcel\Model\Term as Term;
use Corcel\Model\TermRelationship as TermRelationship;
use Modules\HR\Entities\Job;
use Modules\HR\Entities\Round;

class JobObserver
{
    /**
     * Listen to the Job create event.
     *
     * @param  Job  $job
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
        $corcel->saveMeta(config('hr.slugs.job-form.key'), config('hr.slugs.job-form.value'));
        $post = $corcel->hasMeta('hr_id', $job->id)->first();
        $term = Term::select('term_id')->where(['name' => $job->domain])->first();
        if ($term) {
            $relation = new TermRelationship();
            $relation->object_id = $post->ID;
            $relation->term_taxonomy_id = $term->term_id;
            $relation->save();
        }
        $job->opportunity_id = $post->ID;
        $job->link = Option::get('siteurl') . $post->post_type . '/' . $post->post_name . '/';
        $job->save();
    }

    /**
     * Listen to the Job update event.
     *
     * @param Job  $job
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
        if ($post) {
            $corcel = $corcel->find($post->ID);
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
    }

    /**
     * Listen to the Job delete event.
     *
     * @param  Job  $job
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
