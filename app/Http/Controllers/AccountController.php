<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    // direct page to user account
    public function userListPage()
    {
        $users = User::where('role','user')->paginate(3);

        $users->appends(request()->all());
        return view('admin.account.userList',compact('users'));
    }

    // change user acc role
    public function changeUserRole(Request $request) {
        User::where('id',$request->userId)->update([
            'role' => $request->role
        ]);
    }

    // delete user account
    public function userAccDel(Request $request) {
        User::where('id',$request->userId)->delete();
    }
}
