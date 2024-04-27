<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;


class PhotoController extends Controller
{
    public static function obtainMyPhotos(){
        return Photo::obtainMyCurrentProfilePhoto();
    }

    public static function storeImage(Request $request){
        $request->validate(['file_upload' => 'required|mimes:pdf,jpg,avif,png|max:2048',]);
        $imageName = time().'.'.$request->file("file_upload")->extension();
        $request->file("file_upload")->move(public_path('images/uploads'), $imageName);
        // $imageName?null:$imageName="logo.png";
        if($imageName == null){
            return;
        }

        $photo = new Photo;
        $photo->creator_id = $request->user()->id;
        $photo->imagePath = $imageName;
        $photo->save();
    }

    // image handler
    public static function ObtainImage(Request $request){
        $photo = Photo::find($request->id);
        if(isset($photo->imagePath)){
            $imagePath  = "images/uploads/" . $photo->imagePath;
        }else{
            $imagePath  = "images/uploads/logo.png";
        }
        return response()->file($imagePath);
    }

    public static function deleteImage(Request $request){
        debugbar()->info($request);
        $photo = Photo::find($request->id);
        $imagePath  = "images/uploads/" . $photo->imagePath;
        File::delete($imagePath);
        $photo->delete();
        return;
    }
}
