<?php

$response = Http::get('https://api.externa.com/photos');
$photos = collect($response->json())->map(function ($photo) {
    return [
        'title' => $photo['name'],
        'price' => $photo['cost']['value'],
        'url' => $photo['media']['url'],
    ];
});