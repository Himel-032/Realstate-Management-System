<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WeatherService
{
    public function getWeather($city)
    {
        $apiKey = config('services.openweather.key');
        $url = "https://api.openweathermap.org/data/2.5/weather";

        $response = Http::get($url, [
            'q' => "{$city},US",
            'appid' => $apiKey,
            'units' => 'metric', // Celsius
        ]);

        if ($response->failed()) {
            return null;
        }

        return $response->json();
    }
}
