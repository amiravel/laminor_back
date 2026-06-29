<?php

namespace App\Repositories;

use App\Filters\BaseFilterInterface;
use App\Sorters\BaseSorterInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Modules\Cinema\App\Models\EpisodeFile;
use Modules\Cinema\App\Models\Series;

abstract class BaseRepository implements BaseRepositoryInterface
{

    protected Builder $query;

    protected ?BaseFilterInterface $filter;
    protected ?BaseSorterInterface $sorter;

    public function __construct(
        protected Model $model,
        ?BaseFilterInterface $filter = null,
        ?BaseSorterInterface $sorter = null,
    )
    {
        $this->resetQuery();
        $this->filter = $filter;
        $this->sorter = $sorter;
    }

    public function resetQuery(): void
    {
        $this->query = $this->model->newQuery();
    }

    public function create(array $attributes)
    {
        return $this->query->create($attributes);
    }

    public function update(int $id, array $attributes): int
    {
        $this->deleteCached($id);
        return $this->query->where('id', $id)->update($attributes);
    }

    public function find(int $id)
    {
        return Cache::remember(get_class($this->model) . "_" .  $id, 60*60, function () use ($id) {
            return $this->query->findOrFail($id);
        });
    }

    public function findBySlug(string $slug)
    {
        return $this->query->where('slug', $slug)->firstOrFail();
    }

    public function delete(int $id)
    {
        $this->deleteCached($id);
        return $this->query->where('id', $id)->delete();
    }

    public function paginate(int $page, int $perPage = 15): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return $this->query->paginate(perPage: $perPage, page: $page);
    }

    public function list(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->query->get();
    }

    public function filter(array $filters): static
    {
        $this->query = $this->filter->apply($this->query, $filters);

        return $this;
    }

    public function sorts(?array $sorts = []): static
    {
        if (!is_null($this->sorter)){
            $this->query = $this->sorter->apply($this->query, $sorts);
        }

        return $this;
    }

    public function batchUpdate(array $ids, array $attributes): int
    {
        return $this->query->whereIn('id', $ids)->update($attributes);
    }

    public function count(): int
    {
        return $this->query->count();
    }


    public function batchDelete(array $ids): void
    {
        $this->query->whereIn('id', $ids)->delete();
    }

    public function getQuery(): Builder
    {
        return $this->query;
    }

    public function with(array $relations): static
    {
        $this->query->with($relations);

        return $this;
    }

    public function first()
    {
        return $this->query->first();
    }

    public function deleteCached(int $id): void
    {
        Cache::forget(get_class($this->model) . "_" . $id);
    }

    public function firstOrCreate(array $attributes): Model
    {
        if ($this->query->where($attributes)->exists()) {
            return $this->query->where($attributes)->first();
        }

        return $this->query->create($attributes);
    }

}
