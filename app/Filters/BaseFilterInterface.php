<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

interface BaseFilterInterface
{
    public function apply(Builder $query, $filters): Builder;
}
