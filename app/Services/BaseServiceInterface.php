<?php

namespace App\Services;

use App\Repositories\BaseRepositoryInterface;

interface BaseServiceInterface
{

    public function create(array $attributes);

    public function update(int $id, array $attributes);

    public function delete(int $id);

    public function find(int $id);

    public function findBySlug(string $slug);

    public function paginate(int $page, int $perPage = 15);

    public function list();

    public function filter(array $filters): static;

    public function sorts(?array $sorts = []): static;

    public function batchUpdate(array $ids, array $attributes);

    public function batchDelete(array $ids): void;

    public function getRepository(): BaseRepositoryInterface;

    public function with(array $relations): static;

    public function first();

}
