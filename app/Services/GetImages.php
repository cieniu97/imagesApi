<?php
namespace App\Services;
use App\Models\Image;
use Illuminate\Support\Facades\Http;
class GetImages{
    public function fetch($amount){
        $response = Http::get('https://random.imagecdn.app/600/400');
        return $response;
    }
}