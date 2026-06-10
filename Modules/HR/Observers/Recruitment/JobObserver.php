<?php

namespace Modules\HR\Observers\Recruitment;

use App\Models\WordPress\WpOption;
use App\Models\WordPress\WpPost;
use App\Models\WordPress\WpTerm;
use App\Models\WordPress\WpTermRelationship;
use Modules\HR\Entities\Job;
use Modules\HR\Entities\Round;

class JobObserver
{
    public function created(Job $job)
    {
        if (! config('database.connections.wordpress.enabled')) {
            return;
        }
        $job->rounds()->attach(Round::pluck('id')->toArray());
        $post = new WpPost();
        $post->post_title = $job->title;
        $post->post_content = $job->description;
        $post->post_type = config('hr.post-type.career');
        $post->post_name = str_replace(' ', '-', strtolower($job->title));
        $post->post_status = config('hr.opportunities-status-wp-mapping')[$job->status];
        $post->save();
        $post->saveMeta('hr_id', $job->id);
        $post->saveMeta(config('hr.slugs.job-form.key'), config('hr.slugs.job-form.value'));
        $savedPost = WpPost::hasMeta('hr_id', $job->id)->first();
        $term = WpTerm::select('term_id')->where('name', $job->domain)->first();
        if ($term && $savedPost) {
            $relation = new WpTermRelationship();
            $relation->object_id = $savedPost->ID;
            $relation->term_taxonomy_id = $term->term_id;
            $relation->save();
        }
        $job->opportunity_id = $savedPost->ID;
        $job->link = WpOption::get('siteurl') . $savedPost->post_type . '/' . $savedPost->post_name . '/';
        $job->save();
    }

    public function updated(Job $job)
    {
        if (! config('database.connections.wordpress.enabled')) {
            return;
        }
        $savedPost = WpPost::hasMeta('hr_id', $job->id)->first();
        if ($savedPost) {
            $savedPost->post_title = $job->title;
            $savedPost->post_content = $job->description;
            $savedPost->post_type = config('hr.post-type.career');
            $savedPost->post_status = $job->status ? config('hr.opportunities-status-wp-mapping')[$job->status] : 'draft';
            $savedPost->post_name = str_replace(' ', '-', strtolower($job->title));
            $savedPost->save();
            $term = WpTerm::select('term_id')->where('name', $job->domain)->first();
            if ($term) {
                WpTermRelationship::where('object_id', $savedPost->ID)
                    ->update(['term_taxonomy_id' => $term->term_id]);
            }
        }
    }

    public function deleted(Job $job)
    {
        if (! config('database.connections.wordpress.enabled')) {
            return;
        }
        WpPost::where('post_type', 'career')->where('post_title', $job->title)->delete();
    }
}
