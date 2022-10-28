<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    //direct product list page
    public function list() {
        $pizzas = Product::select('products.*','categories.name as category_name')
            ->when(request('key'),function($query){
                $query->where('products.name','like','%'. request('key') .'%');

            })
            ->leftJoin('categories','products.category_id','categories.id')
            // database relation
            ->orderBy('products.id', 'desc')->paginate(5);

        $pizzas->append(request()->all());

        return view('admin.product.pizzaList',compact('pizzas'));
    }

    // direct create product page
    public function createPage() {
        $categories = Category::select('id','name')->get();
        return view('admin.product.create',compact('categories'));
    }

    // create product
    public function create(Request $request) {
        $this->productValidationCheck($request,'create');
        $data = $this->requestProduct($request);

        if($request->hasFile('image')) {
            // to stroe image in project
            $fileName = uniqid() . $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('public',$fileName);
            // to stroe image in db
            $data['image'] = $fileName;
        }
        Product::create($data);
        return redirect()->route('product#list');
    }

    // delete product
    public function delete($id) {
        Product::where('id',$id)->delete();
        return redirect()->route('product#list')->with(['process' => 'Product deleted!']);
    }

    // direct to view page
    public function viewPage($id) {
        $pizza = Product::select('products.*','categories.name as category_name')
            ->leftJoin('categories','products.category_id','categories.id')
            ->where('products.id',$id)->first();
        return view('admin.product.detail',compact('pizza'));
    }

    // direct to update page
    public function updatePage($id) {
        $pizza = Product::where('id',$id)->first();
        $category = Category::get();
        return view('admin.product.update',compact('pizza','category'));
    }

    // pizza product update
    public function update(Request $request) {
        $this->productValidationCheck($request,'update');
        $data = $this->requestProduct($request);

        if($request->hasFile('image')) {
            $oldImgName = Product::where('id',$request->id)->first();
            $oldImgName = $oldImgName->image;

            if($oldImgName != null) {
                Storage::delete('public/'.$oldImgName);
            }

            $fileName = uniqid() . $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('public',$fileName);
            $data['image'] = $fileName;
        }

        Product::where('id',$request->id)->update($data);
        return redirect()->route('product#list');
    }

    // private function
    // product validation check
    private function productValidationCheck($request,$status) {
        $validationRules = [
            'name' => 'required|unique:products,name,' . $request->id,
            'category_id' => 'required',
            'description' => 'required',
            'price' => 'required'
        ];
        $validationRules['image'] = $status == 'create' ? 'required|mimes:png,jpg,jpeg,webp|file' : 'mimes:png,jpg,jpeg,webp|file';
        Validator::make($request->all(),$validationRules)->validate();
    }

    // format array product request data
    private function requestProduct($request) {
        return [
            'category_id' => $request->category_id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price
        ];
    }
}
