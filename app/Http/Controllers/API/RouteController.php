<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;

class RouteController extends Controller
{
    //get product list
    public function productList() {
        $product = Product::get();
        $user =User::get();

        $data = [
            'user' => $user,
            'product' => $product
        ];

        return response()->json($data, 200);
    }

    // get category list
    public function categoryList() {
        $data = Category::get();

        return response()->json($data,200);
    }

    // create category
    public function createCategory(Request $request) {
        Category::create([
            'name' => $request->name
        ]);
        $data = Category::get();
        return response()->json($data,200);
    }

    // delete category
    public function deleteCategory($id) {
        $delCat = Category::where('id',$id)->first();
        if(isset($delCat)) {
            Category::where('id',$id)->delete();
            return response()->json([
                'message' => 'deleted!'
            ],200);
        }
        return response()->json([
            'message' => 'that category does not exist'
        ], 200);
    }

    // detail category
    public function categoryDetail($id) {
        $data = Category::where('id',$id)->first();

        if (isset($data)) {
            return response()->json($data, 200);
        }
        return response()->json([
            'message' => 'that category does not exist'
        ], 500);
    }

    // update category
    public function updateCategory(Request $request) {
        $data = Category::where('id',$request->categoryId)->first();

        if (isset($data)) {
            $updateCat = Category::where('id',$request->categoryId)->update([
                'name' => $request->name
            ]);
            return response()->json($data, 200);
        }
        return response()->json([
            'message' => 'that category does not exist'
        ], 500);
    }
}
