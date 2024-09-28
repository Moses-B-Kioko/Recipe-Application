<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;
use App\Models\TempImage;
use Illuminate\Support\Facades\File;
use Intervention\Image\Laravel\Facades\Image;



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
        'slug' => 'required|unique:categories',
    ]);

    if ($validator->passes()) {
        $category = new Category();
        $category->name = $request->name;
        $category->slug = $request->slug;
        $category->status = $request->status;
        $category->showHome = $request->showHome;
        $category->save();

        // Save Image Here
        if (!empty($request->image_id)) {
            $tempImage = TempImage::find($request->image_id);
            $extArray = explode('.', $tempImage->name);
            $ext = end($extArray); // Use end() instead of last()

            $newImageName = $category->id . '.' . $ext;
            $sPath = public_path('temp/' . $tempImage->name);
            $dPath = public_path('uploads/category/' . $newImageName);

            // Copy original image
            File::copy($sPath, $dPath);

            // Generate Image Thumbnail
            $thumbPath = public_path('uploads/category/thumb/'. $newImageName);
            $img = Image::make($dPath)->fit(450, 600, function ($constraint) {
                $constraint->upsize();
            });
            $img->save($thumbPath);

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

    public function update($categoryId, Request $request){

        $category = Category::find($categoryId);

        if(empty($category)) {
            $request->session()->flash('error', 'Genre not found');

            return response()->json([
                'status' => false,
                'notFound' => true,
                'message' => 'Genre not found'
            ]);
        }

        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'slug' => 'required|unique:categories,slug,'.$category->id.',id',
        ]);

        if($validator->passes()) {

            $category->name = $request->name;
            $category->slug = $request->slug;
            $category->status = $request->status;
            $category->showHome = $request->showHome;
            $category->save();

            $oldImage = $category->image;

            //Save Image Here
            if(!empty($request->image_id)){
                $tempImage = TempImage::find($request->image_id);
                $extArray = explode('.', $tempImage->name);
                $ext = end($extArray);

                $newImageName = $category->id . '-' . time() . '.' . $ext;
                $sPath = public_path().'/temp/'.$tempImage->name;
                $dPath = public_path().'/uploads/category/'.$newImageName;
                File::copy($sPath,$dPath);

                //Generate Image Thumbnail
                $dPath1 = public_path().'/uploads/category/thumb/'.$newImageName;
                $img = Image::make($sPath1);
                //$img->resize(450, 600);
                $img = $img->fit(450, 600, function ($constraint) {
                    $constraint->upsize();
                });
                $img->save($dPath1);

                $category->image = $newImageName;
                $category->save();

                //Delete Old Images Here
                File::delete(public_path().'/uploads/category/thumb/'.$oldImage);
                File::delete(public_path().'/uploads/category/'.$oldImage);


            }


            $request->session()->flash('success', 'Genre updated successfully');


            return response()->json([
                'status' => true,
                'message' => 'Genre updated successfully',
                'category' => $category // Send the category object with name property
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