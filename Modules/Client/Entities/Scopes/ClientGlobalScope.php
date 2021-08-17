<?php

namespace Modules\Client\Entities\Scopes;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Builder;

class ClientGlobalScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     */
    public function apply(Builder $builder, Model $model)
    {
        $relationships = collect([
                'keyAccountManager',
                'channelPartner',
                'parentOrganisation'
            ])
            ->filter(function ($item) use ($model) {
                return method_exists($model, $item);
            });

        $builder->with($relationships->toArray());

        // Skip the authentication if running in the console command.
        if (app()->runningInConsole()) {
            return $builder;
        }

        if (auth()->user()->isSuperAdmin() || auth()->user()->hasRole('client-manager')) {
            return $builder;
        }

        return $builder->where('key_account_manager_id', auth()->user()->id);
    }
}
