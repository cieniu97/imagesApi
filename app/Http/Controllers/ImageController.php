<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreImageRequest;
use App\Http\Requests\UpdateImageRequest;
use Illuminate\Validation\Rules\File;

use App\Models\Image;
use Illuminate\Support\Facades\Storage;
use App\Serivces\GetImages;
use Illuminate\Support\Str;

class ImageController extends Controller
{


    public function index()
    {
        return Image::all();
    }


    public function store(StoreImageRequest $request)
    {
        $validated = $request->validated();
        $image = new Image();
        $path = Str::random(32).".jpg";
        $image->path=$path;
        if(Storage::putFileAs('images', $validated["image"], $path)){
            $image->save();
        }
    }


    public function show(Image $image)
    {
        return $image;
    }


    public function update(UpdateImageRequest $request, Image $image)
    {
        
        $validated = $request->validated();

        //Creating new name so that old image can be deleted only after the new one is added
        $path = Str::random(32).".jpg";
        if(Storage::putFileAs('images', $validated["image"], $path)){
            Storage::delete($image->path);
            $image->path=$path;
            $image->save();
            return $image;
        }
        else{
            return false;
        }
    }

    public function destroy(Image $image)
    {
        if(Storage::delete($image->path)){
            $image->delete();
        }
        return true;
        
    }

    // Retruns amount of succesfully stored images 
    private function dowlnoadImages($amount){
        $newImages = new GetImages($amount);
        return $newImages->amountOfNewImages();
    }
}
