<?php

namespace App\Services;

use App\Models\Nekretnine;
use App\Repositories\NekretnineRepository;

class NekretnineServices extends OwnServices
{
    public function __construct(NekretnineRepository $atributi)
    {
        parent::__construct($atributi);
    }

    public function dohvatiSveNekeretnineINjegovePodSlike($svi)
    {
        return $svi->load("slike");
    }

    public function pridruziSlikeNekretninama($tip, $ids)
    {
        $tip->slike()->sync($ids);
    }
    public function findByIdOrSlug($identifier, array $relations = [])
    {
        return $this->model->query()
            ->with($relations)
            ->where('id', $identifier)
            ->orWhere('slug', $identifier)
            ->first();
    }

    public function getFiltered($tip_id, $column, $direction, $relations = [])
    {
        $query = $this->model->query()->with($relations);
        if ($tip_id) {
            $query->whereHas('tip', function ($q) use ($tip_id) {
                if (is_numeric($tip_id)) {
                    $q->where('id_tip_nekretnine', $tip_id);
                } else {
                    $q->where('tip', $tip_id);
                }
            });
        }

        $allowedSort = ['created_at', 'cena', 'povrsina'];
        $column = in_array($column, $allowedSort) ? $column : 'created_at';
        $direction = in_array($direction, ['asc', 'desc']) ? $direction : 'desc';

        return $query->orderBy($column, $direction);
    }
}
