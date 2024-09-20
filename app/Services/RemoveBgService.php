<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class RemoveBgService
{
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = config('services.removebg.api_key');
    }

    public function removeBackground($imagePath)
    {
        $response = Http::timeout(30)->withHeaders([
            'X-Api-Key' => $this->apiKey,
        ])->attach('image_file', file_get_contents($imagePath), basename($imagePath))
            ->post('https://api.remove.bg/v1.0/removebg');

        if ($response->successful()) {
            // Save the returned image to storage
            $imageName = 'bg-removed-' . time() . '.png';
            Storage::disk('public')->put($imageName, $response->body());

            // Return the URL of the stored image
            return Storage::url($imageName);
        }

        throw new Exception('Error: ' . $response->body());
    }
}
