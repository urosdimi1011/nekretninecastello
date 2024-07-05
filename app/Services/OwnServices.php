<?php

namespace App\Services;
use Illuminate\Database\Eloquent\Builder;
use App\Repositories\Repository;
use App\Repositories\RepositoryInterface;

abstract class OwnServices
{
    protected $model;

    public function __construct(Repository $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model->all();
    }

    public function getAllWithRelation(array | string $relation)
    {
        return $this->model->getAllWithRelation($relation);
    }


    public function getById($id)
    {
        return $this->model->find($id);
    }

    public function create($data)
    {
        return $this->model->create($data);
    }

    public function createMoreData(array $data)
    {
        return $this->model->createMoreData($data);

    }

    public function createOrUpdate(array ...$data){
        return $this->model->createOrUpdate(...$data);
    }

    public function update($id, $data)
    {
        $model = $this->model->find($id);

        if (!$model) {
            return null;
        }
        $model->fill($data);
        $model->save();

        return $model;
    }

    public function delete($id)
    {
        $model = $this->model->find($id);

        if (!$model) {
            return null;
        }

        $model->delete();

        return $model;
    }
    public function getAllWithPaginate(array | string $relation,$perPage = 10){
        return $this->model->getAllWithPaginateAndRelation($relation,$perPage);
    }


    public function scopeSortByColumns($columns)
    {
        foreach ($columns as $column => $direction) {
            if ($column && $direction) {
                $this->model= $this->model->sort($column, $direction);
            }
        }
        return $this;
    }
    public function filterByColumns($filters, $operator)
    {
        return $this->model->filterByColumns($filters, $operator);
    }

    public function dohvatiObrisane(){
        $this->model =  $this->model->dohvatiObrisane();
        return $this;
    }
    public function dohvatiSve(){
        $this->model =  $this->model->dohvatiSve();
        return $this;
    }
}
