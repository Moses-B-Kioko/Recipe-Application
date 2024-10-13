<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubGenre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class SubGenreController extends Controller
{
    public function index(Request $request){
        $subGenre = SubGenre::select('sub_genres.*','categories.name as genreName')
        ->latest('sub_genres.id')
        ->leftJoin('categories', 'categories.id', 'sub_genres.category_id');

        if(!empty($request->get('keyword'))){
            $subGenre =   $subGenre->where('sub_genres.name','like','%'.$request->get('keyword').'%');

            $subGenre =   $subGenre->orWhere('categories.name','like','%'.$request->get('keyword').'%');
 
        }
        $subGenre = $subGenre->paginate(10);

        return view('admin.sub_genre.list', compact('subGenre'));
    }

    public function create() {
        $categories = Category::orderBy('name', 'ASC')->get();
        $data['categories'] = $categories;
        return view('admin.sub_genre.create', $data);
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'slug' => 'required|unique:sub_genres',
            'genre' => 'required',
            'status' => 'required'
        ]);
      
        if($validator->passes()) {

            $subGenre = new SubGenre();
            $subGenre->name = $request->name;
            $subGenre->slug = $request->slug;
            $subGenre->status = $request->status;
            $subGenre->showHome = $request->showHome;
            $subGenre->category_id = $request->genre;
            $subGenre->save();

            $request->session()->flash('success', 'Sub Genre created successfully.');

            return response([
                'status' => true,
                'message' => 'Sub Genre created successfully.'
            ]);

        } else {
            return response([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
    
    public function edit($id, Request $request) {

        $subGenre = SubGenre::find($id);
        if (empty($subGenre)) {
            $request->session()->flash('error', 'Record not found');
            return redirect()->route('sub-genre.index');
        }

        $categories = Category::orderBy('name', 'ASC')->get();
        $data['categories'] = $categories;
        $data['subGenre'] = $subGenre;
        return view('admin.sub_genre.edit', $data);
    }

    public function update($id, Request $request ) {
       
        $subGenre = SubGenre::find($id);
       
        if (empty($subGenre)) {
            $request->session()->flash('error', 'Record not found');
            return response([
                'status' => false,
                'notFound' => true
            ]);
            // return redirect()->route('sub-genre.index');
        }

        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'slug' => 'required|unique:sub_genres', // Ensure table name is correct
            'genre' => 'required',
            'status' => 'required'
        ]);
      
        if($validator->passes()) {

            $subGenre->name = $request->name;
            $subGenre->slug = $request->slug;
            $subGenre->status = $request->status;
            $subGenre->showHome = $request->showHome;
            $subGenre->category_id = $request->genre;
            $subGenre->save();

            $request->session()->flash('success', 'Sub Genre updated successfully.');

            return response([
                'status' => true,
                'message' => 'Sub Genre updated successfully.'
            ]);

        } else {
            return response([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function destroy($id, Request $request) {
        $subGenre = SubGenre::find($id);
       
        if (empty($subGenre)) {
            $request->session()->flash('error', 'Record not found');
            return response([
                'status' => false,
                'notFound' => true
            ]);
        }

        $subGenre->delete();

        
        $request->session()->flash('success', 'Sub Genre deleted successfully.');

        return response([
            'status' => true,
            'message' => 'Sub Genre deleted successfully.'
        ]);
    }
}
