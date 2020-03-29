<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class SessionsController extends Controller
{
    //
    public function create()
    {
        return view('sessions.create');
    }
    public function store(Request $request)
    {
        $credentials = $this->validate($request,[
            'email'=>'required|email|max:25',
            'password'=>'required'
        ]);

        if (Auth::attempt($credentials)) {
            session()->flash('success','Welcome back!');
            return redirect()->route('users.show',[Auth::user()]);
        }
        else
        {
            session()->flash('danger','Sorry,your email not mathc your secret');
            return redirect()->back()->withInput();
        }

        return;
    }
}
