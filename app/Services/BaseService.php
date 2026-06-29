<?php

namespace App\Services;

use App\Repositories\BaseRepositoryInterface;
use Dotenv\Repository\RepositoryInterface;

abstract class BaseService implements BaseServiceInterface
{

    public function __construct(
        protected BaseRepositoryInterface $repository
    )
    {
    }

    public function create(array $attributes)
    {
        return $this->repository->create($attributes);
    }

    public function update(int $id, array $attributes)
    {
        return $this->repository->update($id, $attributes);
    }


    public function find(int $id)
    {
        return $this->repository->find($id);
    }

    public function findBySlug(string $slug)
    {
        return $this->repository->findBySlug($slug);

    }

    public function delete(int $id)
    {
        return $this->repository->delete($id);
    }

    public function paginate(int $page, int $perPage = 15)
    {
        return $this->repository->paginate($page, $perPage);
    }

    public function list()
    {
        return $this->repository->list();
    }

    public function filter(array $filters): static
    {
        $this->repository->filter($filters);

        return $this;
    }

    public function sorts(?array $sorts = []): static
    {
        if (!is_null($sorts)){
            $this->repository->sorts($sorts);
        }

        return $this;
    }

    public function batchUpdate(array $ids, array $attributes)
    {
        return $this->repository->batchUpdate($ids, $attributes);
    }

    public function getRepository(): BaseRepositoryInterface
    {
        return $this->repository;
    }

    public function batchDelete(array $ids): void
    {
        $this->repository->batchDelete($ids);
    }

    public function with(array $relations): static
    {
        $this->repository->with($relations);

        return $this;
    }

    public function first()
    {
        return $this->repository->first();
    }


}
