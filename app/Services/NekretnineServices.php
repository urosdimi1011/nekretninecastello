<?php

namespace App\Services;

use App\Models\Nekretnine;
use App\Repositories\NekretnineRepository;
use Illuminate\Support\Facades\Storage;

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

    public function procesuirajISacuvajVideo($request, $nekretnina)
    {
        set_time_limit(120);
        $videoUrl = null;
        if ($request->hasFile('video_fajl')) {
            $file = $request->file('video_fajl');
            
            // Upload na Cloudflare R2 (folder 'videa')
            /** @var \Illuminate\Filesystem\FilesystemAdapter $disk */
            $disk = Storage::disk('r2');
            $path = $file->store('videa', 'r2');

            $videoUrl = $disk->url($path);
        }
        if ($videoUrl) {
            return $nekretnina->video()->create([
                'url' => $videoUrl
            ]);
        }

        return null;
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

    public function obrisiVideo($nekretnina)
    {
        $video = $nekretnina->video;
        if (!$video) return false;

        $url = $video->url;
        $path = parse_url($url, PHP_URL_PATH);
        $path = ltrim($path, '/');

        $disk = Storage::disk('r2');
        if ($disk->exists($path)) {
            $disk->delete($path);
        }

        $video->delete();
        return true;
    }
}
