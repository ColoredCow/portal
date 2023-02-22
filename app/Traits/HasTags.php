<?php

namespace App\Traits;

use App\Models\Tag;

trait HasTags
{
    /**
     * Get all of the tags for the model.
     */
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'model', 'model_has_tags')->withTimestamps();
    }

    public function scopeFilterByTags($query, $tags)
    {
        if (is_array($tags)) {
            return $query->whereHas('tags', function ($subQuery) use ($tags) {
                $subQuery->whereIn('tag_id', $tags);
            });
        }

        if (is_string($tags)) {
            return $query->whereHas('tags', function ($subQuery) use ($tags) {
                $subQuery->where('tag_id', $tags);
            });
        }
    }

    public function untag($slug)
    {
        $this->tag($slug, false);
    }

    public function tag($slug, $status = true)
    {
        $tag = Tag::slug($slug)->first();
        if (! $tag) {
            return;
        }
        if ($status) {
            $this->tags()->syncWithoutDetaching($tag);
           
            return;
        }
        $this->tags()->detach($tag);
    }

    public function hasTag(string $slug)
    {
        $tag = Tag::slug($slug)->first();
        if ($tag) {
            return $this->tags->contains($tag);
        }

        return false;
    }
}
