<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class AuthUserScope implements Scope {
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply( Builder $builder, Model $model ): void {
        if ( Auth::check() ) {
            $builder->where( $model->getTable() . '.user_id', Auth::id() );
        }
    }
}
