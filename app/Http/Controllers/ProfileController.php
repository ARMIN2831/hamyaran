<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('admin.profile.profile-edit');
    }
    public function password()
    {
        return view('admin.profile.profile-password');
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        $user->name = $request->name;
        $user->email = $request->email;
        $image = $this->uploadFile($request,'image',$user,'user/image');
        if ($image) $user->image = $image;
        $user->save();
        return redirect()->route('profile.edit')->with('success','پروفایل با موفقیت اپدیت شد.');
    }
    public function changePassword(Request $request)
    {
        if (Auth::attempt(['password'=>$request->password])){
            if ($request->newPassword == $request->retypeNewPassword){
                $user = \auth()->user();
                $user->password = bcrypt($request->newPassword);
                $user->save();
                return redirect()->route('profile.password')->with('success','رمز عبور با موفقیت تغییر کرد.');
            }else{
                return redirect()->route('profile.password')->with('fail','رمزعبور با تکرار رمزعبور یکسان نیست!');
            }
        }else{
            return redirect()->route('profile.password')->with('fail','رمز قبلی اشتباه است.');
        }
    }
}
