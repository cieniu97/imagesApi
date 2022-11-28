<?php
namespace App\Services;
use App\Models\Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
class GetImages{

    public $amountOfNewImages;
    public function fetch(){
        return file_get_contents('https://random.imagecdn.app/600/400');
    }
    public function store(){
        if($image = $this->fetch()){
            $newName = Str::random(32).".jpg";
            Storage::putFileAs('public/images/', $image, $newName);
            $newImage = new Image();
            $newImage->path=$newName;
            $newImage->save();
            return 1;
        }
        else{
            return 0;
        }
    }
    public function __construct($amount){
        for ($i=0; $i <$amount ; $i++) { 
            $this->$amountOfNewImages += $this->store();
        }
    }

}