<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    //direct category list page
    public function list() {
        $categories = Category::when(request('key'),function($query){
            $query->where('name','like','%'.request('key').'%');

        })->orderBy('id', 'desc')->paginate(5);
        // dd($categories);
        return view('admin.category.list',compact('categories'));
    }

    // direct category create page
    public function createPage() {
        return view('admin.category.create');
    }

    // create category
    public function create(Request $request) {
        $this->categoryVelidateCheck($request);
        $data = $this->requestCategoryData($request);

        Category::create($data);
        return redirect()->route('category#list')->with(['process' => 'Created']);
    }

    // delete
    public function delete($id) {
        Category::where('id',$id)->delete();
        return redirect()->route('category#list')->with(['process' => 'Deleted']);
    }

    // edit
    public function edit($id) {
        $category = Category::where('id',$id)->first();
        return view('admin.category.edit',compact('category'));
    }

    // update
    public function update(Request $request) {

        $id = $request->categoryId;

        $this->categoryVelidateCheck($request);
        $data = $this->requestCategoryData($request);

        Category::where('id',$id)->update($data);
        return redirect()->route('category#list');
    }

    // private function
    // check category velidation
    private function categoryVelidateCheck($request) {
        Validator::make($request->all(),[
            'categoryName' => 'required|unique:categories,name,'.$request->categoryId
        ],[
            'categoryName.required' => 'Item is required'
        ])->validate();
    }

    // request data to array
    private function requestCategoryData($request) {
        return [

            'name' => $request->categoryName
            // db_name  =>  inputName
        ];
    }
}
