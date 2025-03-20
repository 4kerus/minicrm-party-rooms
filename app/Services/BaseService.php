<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

abstract class BaseService
{
    protected Model $model;

    public function getAll(): Collection
    {
        return $this->model::all();
    }

    public function findById(int $id): ?Model
    {
        return $this->model::query()->find($id);
    }

    public function create(array $data): Model
    {
        return $this->model::query()->create($data);
    }

    public function update(Model $model, array $data): bool
    {
        return $model->update($data);
    }

    public function delete(Model $model): void
    {
        $model->delete();
    }
}
