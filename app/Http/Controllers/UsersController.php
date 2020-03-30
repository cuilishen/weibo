<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class UsersController extends Controller
{
    //
    public function create()
    {
        return view('users.create');
    }
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }
    public function store(Request $request)
    {
        $this->validate(
            $request,[
                'name'=>'required|unique:users|max:50',
                'email'=>'required|email|unique:users|max:255',
                'password'=>'required|confirmed|max:6'
            ]);

        $user = User::create([
            'name'=>$request->name,
            'email'=> $request->email,
            'password'=> bcrypt($request->password),
        ]);

        Auth::login($user);
        session()->flash('success','欢迎，开始自己的laravel旅程');
        return redirect()->route('users.show',[$user]);
    }

    public function edit(User $user)
    {
        return view('users.edit',compact('user'));
    }

    public function update(User $user,Request $request)
    {
        $this->validate($request,[
            'name' => 'required|max:50',
            'password' => 'required|confirmed|min:6'
        ]);

        $data = [];
        $data['name'] = $request->name;
        if ($request->password) {
                $data['password']=bcrypt($request->password);
        }
        $user->update($data);

        session()->flash('success','Person data was updated!');

        return redirect()->route('users.show',$user->id);
    }


}
