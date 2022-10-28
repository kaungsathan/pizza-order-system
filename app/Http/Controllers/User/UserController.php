<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //direct to user home page
    public function homePage() {
        $pizza = Product::orderBy('created_at','desc')->get();
        $category = Category::get();
        $cart = Cart::where('user_id',Auth::user()->id)->get();
        return view('user.main.home',compact('pizza','category','cart'));
    }

    // filter
    public function filter($id) {
        $pizza = Product::where('category_id',$id)->get();
        $category = Category::get();
        $cart = Cart::where('user_id', Auth::user()->id)->get();
        return view('user.main.home', compact('pizza', 'category','cart'));
    }

    // pizza detail
    public function pizzaDetail($id) {
        $product = Product::where('id',$id)->first();
        $productList = Product::get();
        return view('user.main.detail',compact('product','productList'));
    }

    // direct to cart list page
    public function cartList() {
        $cartList = Cart::select('carts.*','products.name as product_name','products.price as product_price')
                        ->leftJoin('products','carts.product_id','products.id')
                        ->where('carts.user_id',Auth::user()->id)->get();

        $totalPrice = 0;
        foreach ($cartList as $c) {
            $totalPrice += $c->product_price * $c->qty;
        }
        return view('user.main.cart',compact('cartList','totalPrice'));
    }

    // direct to order history page
    public function history() {
        $order = Order::where('user_id',Auth::user()->id)->paginate(6);
        return view('user.main.history',compact('order'));
    }

    // direct to password change page
    public function passwordChangePage() {
        return view('user.password.change');
    }

    // change password
    public function changePassword(Request $request)
    {
        $this->passwordValidationCheck($request);
        $userId = Auth::user()->id;
        $user = User::select('password')->where('id', $userId)->first();
        $dbPassword = $user->password;

        if (Hash::check($request->oldPassword, $dbPassword)) {
            User::where('id', $userId)->update([
                'password' => Hash::make($request->newPassword)
            ]);

            Auth::logout();
            return redirect()->route('auth#login');
        }
        return back()->with(['notMatch' => 'Old password is incorrect!']);
    }

    // direct to change account page
    public function changeAccountPage() {
        return view('user.profile.account');
    }

    // change account
    public function changeAccount($id,Request $request) {
        $this->accValidationCheck($request);
        $data = $this->getUserData($request);

        if ($request->hasFile('image')) {
            $dbImage = User::where('id', $id)->first();
            $dbImage = $dbImage->image;

            if ($dbImage != null) {
                Storage::delete('public/' . $dbImage);
            }

            $fileName = uniqid() . $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('public', $fileName);
            $data['image'] = $fileName;
        }

        User::where('id', $id)->update($data);
        return back()->with(['process' => 'User account updated!']);
    }

    // private function
    // password validation
    private function passwordValidationCheck($request)
    {
        // Validator::make($request->all(), [
        //     'oldPasswrod' => 'required|min:4',
        //     'newPasswrod' => 'required|min:4',
        //     'confirmPasswrod' => 'required|min:4|same:newPassword' //same:field
        // ])->validate();

        Validator::make($request->all(), [
            'oldPassword' => 'required|min:4',
            'newPassword' => 'required|min:4',
            'confirmPassword' => 'required|min:4|same:newPassword'
        ])->validate();
    }

    // user data validation
    private function accValidationCheck($request)
    {
        Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'image' => 'mimes:png,jpg,jpeg,webp|file',
            'gender' => 'required',
            'address' => 'required'
        ])->validate();
    }

    // get user data to array
    private function getUserData($request)
    {
        return [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'address' => $request->address
        ];
    }
}
