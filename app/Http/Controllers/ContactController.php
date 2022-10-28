<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    //direct to user contact page
    public function contactPage() {
        return view('user.contact.contact');
    }

    // user contact
    public function contact(Request $request) {

        Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required',
            'message' => 'required'
        ])->validate();

        $userName = Auth::user()->name;
        $userEmail = Auth::user()->email;
        if($request->name == $userName && $request->email == $userEmail) {
            Contact::create([
                'name' => $request->name,
                'email' => $request->email,
                'message' => $request->message
            ]);

            return redirect()->route('user#home');
        }
        return back()->with(['process' => 'user name or password is incorrect']);

    }

    // direct to admin contact list page
    public function contactList() {
        $contact = Contact::when(request('key'),function($query){
            $query->where('name','like','%'.request('key').'%');
        })
        ->orderBy('id','desc')->paginate(3);


        return view('admin.contact.contact',compact('contact'));
    }

    // direct to admin contact detail page
    public function contactDetail($id) {
        $contact = Contact::where('id',$id)->first();
        return view('admin.contact.detail',compact('contact'));
    }

    // delete admin contact list
    public function contactDelete(Request $request) {
        Contact::where('id',$request->contactId)->delete();
    }
}
