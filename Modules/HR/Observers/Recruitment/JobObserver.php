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
        $job->rounds()->attach(Round::pluck('id')->toArray());
        if (env('WORDPRESS_ENABLED') == true) {
            $data = request()->all();
            $Corcel = new Corcel();
            $Corcel->post_title = $data['title'];
            $Corcel->post_content = $data['description'];
            $Corcel->post_type = config('hr.post-type.career');
            $Corcel->post_name = str_replace(' ', '-', strtolower($data['title']));
            if ($data['status'] != 'published') {
                $Corcel->post_status = 'draft';
            }
            $Corcel->save();
            $Corcel->saveMeta('hr_id', $job['id']);
            $post = Corcel::hasMeta('hr_id', $job['id'])->first();
            $term = Term::select('term_id')->where(['name' => $data['domain']])->first();
            $relation = new TermRelationship();
            $relation->object_id = $post->ID;
            $relation->term_taxonomy_id = $term->term_id;
            $relation->save();
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
        if (env('WORDPRESS_ENABLED') == true) {
            $data = request()->all();
            $post = Corcel::hasMeta('hr_id', $job['id'])->first();
            $Corcel = Corcel::find($post->ID);
            $Corcel->post_title = $data['title'];
            $Corcel->post_content = $data['description'];
            $Corcel->post_type = config('hr.post-type.career');
            $Corcel->post_status = $data['status'] == 'published' ? 'publish' : 'draft';
            $Corcel->post_name = str_replace(' ', '-', strtolower($data['title']));
            $Corcel->update();
            $term = Term::select('term_id')->where(['name' => $data['domain']])->first();
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
        if (env('WORDPRESS_ENABLED') == true) {
            Corcel::where(['post_type' => 'career', 'post_title' => $job['title']])->delete();
        }
    }
}
