<?php

namespace App\Jobs;

use App\Models\Nekretnine;
use App\Services\NekretnineServices;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class UploadVideoJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $nekretninaId;
    protected $tempFilePath;

    public function __construct($nekretninaId, $tempFilePath)
    {
        $this->nekretninaId = $nekretninaId;
        $this->tempFilePath = $tempFilePath;
    }

    public function handle(NekretnineServices $nekretnineServices)
    {
        $nekretnina = Nekretnine::find($this->nekretninaId);
        if (!$nekretnina) return;

        $fullPath = storage_path('app/' . $this->tempFilePath);

        if (!file_exists($fullPath)) {
            Log::error('Video fajl nije pronađen: ' . $this->tempFilePath);
            return;
        }

        // Rekreiraj UploadedFile
        $uploadedFile = new \Illuminate\Http\UploadedFile(
            $fullPath,
            basename($this->tempFilePath),
            mime_content_type($fullPath),
            null,
            true
        );

        // Fake request
        $fakeRequest = new \Illuminate\Http\Request();
        $fakeRequest->files->set('video_fajl', $uploadedFile);

        // Upload
        $nekretnineServices->procesuirajISacuvajVideo($fakeRequest, $nekretnina);

        // Obriši privremeni fajl
        unlink($fullPath);

        Log::info("Video upload završen za nekretninu ID: {$this->nekretninaId}");
    }
}
