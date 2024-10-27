<?php
namespace Modules\Client\Entities\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class ClientGlobalScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  Builder  $builder
     * @param  Model  $model
     *
     * @return Builder
     */
    public function apply(Builder $builder, Model $model)
    {
        $relationships = collect([
                'keyAccountManager',
                'channelPartner',
                'parentOrganisation',
            ])
            ->filter(function ($item) use ($model) {
                return method_exists($model, $item);
            });

        return $builder->with($relationships->toArray());
    }
}
