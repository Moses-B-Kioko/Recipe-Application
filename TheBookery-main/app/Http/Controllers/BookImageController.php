<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BookImage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\File;

class BookImageController extends Controller
{
    public function update(Request $request) {

        $image = $request->image;
        $ext = $image->getClientOriginalExtension();
        $sourcePath = $image->getPathName();

        //$imagePath = $image->store('small', 'public');

        //$book_id = $request->input('book_id'); // Ensure this is retrieved correctly
        $bookImage = new BookImage();
        $bookImage->book_id = $request->book_id; // Make sure book_id is not null
        $bookImage->image = 'NULL'; // Assuming $imagePath contains the image path
        $bookImage->save();
        
        $imageName = $request->book_id.'-'.$bookImage->id.'-'.time().'.'.$ext;
        $bookImage->image = $imageName;
        $bookImage->save();

                    //Generate Book Thumbnails

                    //Large Image
                    $destPath = public_path().'/uploads/book/large/'.$imageName;
                    $manager = new ImageManager(new Driver());
                    $image = $manager->read($sourcePath);
                    $image->scaleDown(1400);
                    $image->save($destPath);

                    //Small Image
                    $destPath = public_path().'/uploads/book/small/'.$imageName;
                    $manager = new ImageManager(new Driver());
                    $image = $manager->read($sourcePath);
                    $image->cover(300,300);
                    $image->save($destPath);


                    return response()->json([
                        'status' => true,
                        'image_id' => $bookImage->id,
                        'ImagePath' => asset('uploads/book/small/'.$bookImage->image),
                        'message' => 'Image saved successfully'
                    ]);

    }

    public function destroy(Request $request ) {
        $bookImage = BookImage::find($request->id);

        if (empty($bookImage)) {
            return response()->json([
                'status' => false,
                'message' => 'Image not found'
            ]);
          }
        

        //Delete images from folder
        File::delete(public_path('uploads/book/large/'.$bookImage->image));
        File::delete(public_path('uploads/book/small/'.$bookImage->image));


        $bookImage->delete();

        return response()->json([
            'status' => true,
            'message' => 'Image deleted successfully'
        ]);
    }

   
}
