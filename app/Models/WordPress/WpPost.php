<?php

namespace App\Models\WordPress;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class WpPost extends Model
{
    public $timestamps = false;
    protected $connection = 'wordpress';

    protected $table = 'posts';

    protected $primaryKey = 'ID';

    public function meta()
    {
        return $this->hasMany(WpPostMeta::class, 'post_id', 'ID');
    }

    public function scopeHasMeta(Builder $query, string $key, $value = null): Builder
    {
        return $query->whereHas('meta', function (Builder $q) use ($key, $value) {
            $q->where('meta_key', $key);
            if ($value !== null) {
                $q->where('meta_value', $value);
            }
        });
    }

    public function saveMeta(string $key, $value): void
    {
        $this->meta()->updateOrCreate(
            ['meta_key' => $key],
            ['meta_value' => $value]
        );
    }

    protected static function booted(): void
    {
        static::creating(function (WpPost $post) {
            $now = now()->format('Y-m-d H:i:s');
            $post->post_date = $post->post_date ?? $now;
            $post->post_date_gmt = $post->post_date_gmt ?? $now;
            $post->post_modified = $post->post_modified ?? $now;
            $post->post_modified_gmt = $post->post_modified_gmt ?? $now;
            $post->post_excerpt = $post->post_excerpt ?? '';
            $post->to_ping = $post->to_ping ?? '';
            $post->pinged = $post->pinged ?? '';
            $post->post_content_filtered = $post->post_content_filtered ?? '';
        });
    }
}
