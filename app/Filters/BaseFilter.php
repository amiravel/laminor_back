<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;

abstract class BaseFilter implements BaseFilterInterface
{
    protected Builder $query;

    protected array $filters = [];

    public function apply(Builder $query, $filters): Builder
    {
        $this->query = $query;

        foreach ($this->get($filters) as $name => $value){

            if (method_exists($this, $name) && !empty($value)){
                $this->{$name}($value);
            }

            continue;
        }

        return $this->query;
    }

    public function get(array $filters): array
    {
        return Arr::only($filters, $this->filters);
    }

}
