<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class AdminController extends Controller
{
    // change password page
    public function changePasswordPage()
    {
        return view('admin.account.changePassword');
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

    // direct detail profile page
    public function detail() {
        return view('admin.account.detail');
    }

    // direct edit page
    public function edit() {
        return view('admin.account.edit');
    }

    // update acc info
    public function update(Request $request,$id) {
        $this->accValidationCheck($request);
        $data = $this->getUserData($request);

        if($request->hasFile('image')) {
            $dbImage = User::where('id', $id)->first();
            $dbImage = $dbImage->image;

            if($dbImage != null) {
                Storage::delete('public/'.$dbImage);
            }

            $fileName = uniqid() . $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('public',$fileName);
            $data['image'] = $fileName;

        }

        User::where('id',$id)->update($data);
        return redirect()->route('admin#detail');
    }

    // direct to list page
    public function listPage() {
        $admin = User::when(request('key'),function($query){
                $query->orWhere('name','like','%'. request('key') .'%')
                    ->orWhere('email', 'like', '%' . request('key') . '%')
                    ->orWhere('address', 'like', '%' . request('key') . '%')
                    ->orWhere('gender', 'like', '%' . request('key') . '%')
                    ->orWhere('phone', 'like', '%' . request('key') . '%');
            })
            ->where('role','admin')->paginate(5);
        $admin->append(request()->all());

        return view('admin.account.list',compact('admin'));
    }

    // delete admin acc
    public function delete($id) {
        User::where('id',$id)->delete();
        return back()->with(['process' => 'Account deleted!']);
    }

    // change role admin to user
    public function changeRole(Request $request) {
        User::where('id',$request->adminId)->update([
            'role' => 'user'
        ]);
    }

    // private function
    // password validation
    private function passwordValidationCheck($request)
    {
        Validator::make($request->all(),[
            'oldPassword' => 'required|min:4',
            'newPassword' => 'required|min:4',
            'confirmPassword' => 'required|min:4|same:newPassword'
        ])->validate();
    }

    // user data validation
    private function accValidationCheck($request) {
        Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'image' => 'mimes:png,jpg,jpeg,webp|file',
            'gender' => 'required',
            'address' => 'required'
        ])->validate();
    }

    // get user data to array
    private function getUserData($request) {
        return [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'address' => $request->address
        ];
    }
}
