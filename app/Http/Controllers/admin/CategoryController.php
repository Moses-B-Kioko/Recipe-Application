<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;
use App\Models\TempImage;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;


class CategoryController extends Controller
{
    public function index(Request $request){
        $categories = Category::latest();

        if(!empty($request->get('keyword'))){
            $categories = $categories->where('name','like','%'.$request->get('keyword').'%');
        }
        $categories = $categories->paginate(10);

        return view('admin.category.list', compact('categories'));
    }

    public function create(){
        return view('admin.category.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
    
        if ($validator->passes()) {
            $category = new Category();
            $category->name = $request->name;
            $category->status = $request->status;
            $category->showHome = $request->showHome;
            $category->save();
    
            // Save Image Here
            if (!empty($request->image_id)) {
                $tempImage = TempImage::find($request->image_id);
                $extArray = explode('.', $tempImage->name);
                $ext = end($extArray);
    
                $newImageName = $category->id . '.' . $ext;
                $sPath = public_path('/temp/' . $tempImage->name);
                $dPath = public_path('/uploads/category/' . $newImageName);
    
                // Ensure the uploads/category directory exists
                if (!File::exists(public_path('/uploads/category'))) {
                    File::makeDirectory(public_path('/uploads/category'), 0755, true);
                }
    
                // Copy original image
                File::copy($sPath, $dPath);
    
                // Generate Image Thumbnail
                $dPath = public_path('/uploads/category/thumb/' . $tempImage->name);
    
                // Create image manager with desired driver
                $manager = new ImageManager(new Driver());
                // Read image from file system
                $image = $manager->read($sPath);
                // Image Crop
                $image->cover(450, 600);
                // Save the file
                $image->save($dPath);

                $category->image = $newImageName;
                $category->save();
            }
    
            $request->session()->flash('success', 'Genre added successfully');
    
            return response()->json([
                'status' => true,
                'message' => 'Genre added successfully'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }    


    public function edit($categoryId, Request $request){
        $category = Category::find($categoryId);
        if(empty($category)) {
            return redirect()->route('categories.index');
        }

        
        return view('admin.category.edit', compact('category'));
    }

    public function update($categoryId, Request $request)
{

    $category = Category::find($categoryId);
    if(empty($category)) {
        return response()->json([
            'status' => false,
            'notFound' => true,
            'message' => 'Category not found'
        ]);
    }

    $validator = Validator::make($request->all(), [
        'name' => 'required',
    ]);

    if ($validator->passes()) {

        $category->name = $request->name;
        $category->status = $request->status;
        $category->showHome = $request->showHome;
        $category->save();

        $oldImage = $category->image;

        // Save Image Here
        if (!empty($request->image_id)) {
            $tempImage = TempImage::find($request->image_id);
            $extArray = explode('.', $tempImage->name);
            $ext = end($extArray);

            $newImageName = $category->id.'-'.time(). '.' . $ext;
            $sPath = public_path('/temp/' . $tempImage->name);
            $dPath = public_path('/uploads/category/' . $newImageName);

            
         
 

            // Ensure the uploads/category directory exists
            //if (!File::exists(public_path('/uploads/category'))) {
              //  File::makeDirectory(public_path('/uploads/category'), 0755, true);
            //}

            // Copy original image
            File::copy($sPath, $dPath);

            // Generate Image Thumbnail
            $dPath = public_path('/uploads/category/thumb/' . $tempImage->name);

            // Create image manager with desired driver
            $manager = new ImageManager(new Driver());
            // Read image from file system
            $image = $manager->read($sPath);
            $image->cover(450, 600);
            $image->save($dPath);

            $category->image = $newImageName;
            $category->save();

             // Delete Old Images Here
             File::delete(public_path() . '/uploads/category/thumb/' .$oldImage);
             File::delete(public_path() . '/uploads/category/' .$oldImage);
        }

        $request->session()->flash('success', 'Genre updated successfully');

        return response()->json([
            'status' => true,
            'message' => 'Genre updated successfully'
        ]);
    } else {
        return response()->json([
            'status' => false,
            'errors' => $validator->errors()
        ]);
    }
}


    public function destroy($categoryId, Request $request ){
        $category = Category::find($categoryId);

        if(empty($category)){
            $request->session()->flash('error', 'Genre not found');
            return response()->json([
                'status' => false,
                'message' => 'Genre not found'
            ]);
        }
       
        //File::delete(public_path().'/uploads/category/thumb/'.$ $category->image);
        File::delete(public_path().'/uploads/category/'. $category->image);

          $category ->delete();
          
          $request->session()->flash('success','Genre deleted successfully');

          return response()->json([
            'status' => true,
            'message' => 'Genre deleted successfully'
        ]);
    }

}