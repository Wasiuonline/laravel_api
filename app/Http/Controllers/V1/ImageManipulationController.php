<?php

namespace App\Http\Controllers\V1;

use App\Models\Album;
use Illuminate\Support\Str;
use App\Models\ImageManipulation;
use Illuminate\Http\UploadedFile;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use App\Http\Requests\ResizeImageRequest;

class ImageManipulationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function byAlbum(Album $album, $by_album){

    }

    /**
     * Store a newly created resource in storage.
     */
    public function resize(ResizeImageRequest $request)
    {
        $all = $request->all();
        $image = $all["image"];
        unset($all["image"]);
        $data = [
            "type" => ImageManipulation::TYPE_RESIZE,
            "data" => json_encode($all),
            "user_id" => null
        ];
        if(isset($all["album_id"])){
        $data["album_id"] = $all["album_id"];
        }

        $dir = "images/" . Str::random() . "/";
        $absolutePath = public_path($dir);
        File::makeDirectory($absolutePath);

        if($image instanceof UploadedFile){
            $data["name"] = $image->getClientOriginalName();
            $filename = pathinfo($data["name"], PATHINFO_FILENAME);
            $extension = $image->getClientOriginalExtension();
            $originalPath = $absolutePath . $data["name"];

            $image->move($absolutePath, $data["name"]);
        }else{
            $data["name"] = pathinfo($image, PATHINFO_BASENAME);
            $filename = pathinfo($image, PATHINFO_FILENAME);
            $extension = pathinfo($image, PATHINFO_EXTENSION);
            $originalPath = $absolutePath . $data["name"];

            copy($image, $absolutePath . $data["name"]);
        }

        $data["path"] = $dir . $data["name"];
        $w = $all["w"];
        $h = $all["h"] ?? false;
        list($width, $height, $image) = $this->getImageWidthAndHeight($w, $h, $originalPath);
        $resizedFilename = $filename . "-resized." . $extension;
        $image->resize($width, $height)->save($absolutePath . $resizedFilename);
        $data["output_path"] = $dir . $resizedFilename;
        $imageManipulation = ImageManipulation::create($data);
        return $imageManipulation;
    }

    /**
     * Display the specified resource.
     */
    public function show(ImageManipulation $imageManipulation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ImageManipulation $imageManipulation)
    {
        //
    }

    protected function getImageWidthAndHeight($w, $h, $originalPath)
    {
        $image = Image::make($originalPath);
        $originalWidth = $image->width();
        $originalHeight = $image->height();
        if(str_ends_with($w, "%")){
            $ratioW = (float)str_replace("%", "", $w);
            $ratioH = $h ? (float)str_replace("%", "", $h) : $ratioW;
            $newWidth = $originalWidth * $ratioW/100;
            $newHeight = $originalHeight * $ratioH/100;
        }else{
            $newWidth = $w;
            $newHeight = $h ? (float)$h : $originalHeight * $newWidth/$originalWidth;
        }
        return [$newWidth, $newHeight, $image];
    }
}
