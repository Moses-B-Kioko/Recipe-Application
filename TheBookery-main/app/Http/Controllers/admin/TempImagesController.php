<?php

namespace App\Http\Controllers\admin;



use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TempImage;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;



class TempImagesController extends Controller
{
    public function create(Request $request) {
        $image = $request->image;

        if (!empty($image)) {
            $ext = $image->getClientOriginalExtension();
            $tempImage = new TempImage();
            $tempImage->name = 'TEST';
            $tempImage->save();


            $newName =$tempImage->id.'.'.time().'.'.$ext;
            $tempImage->name = $newName;
            $tempImage->save();

            $image->move(public_path().'/temp',$newName);

            // Generate thumbnail
            // Create image manager with desired driver
            $manager = new ImageManager(new Driver());
            $sourcePath = public_path().'/temp/'.$newName;
            $destPath = public_path().'/temp/thumb/'.$newName;
            // Read image from file system
            $image = $manager->read($sourcePath);
            // Image Crop
            $image->cover(300, 275);
            // Save the file
            $image->save($destPath);


            return response()->json([
                'status' => true,
                'image_id' => $tempImage->id,
                'ImagePath' => asset('/temp/thumb/'.$newName),
                'message' => 'Image uploaded successfully'
            ]);
        }
    }
}
