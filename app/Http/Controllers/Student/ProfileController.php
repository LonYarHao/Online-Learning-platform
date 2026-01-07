<?php

namespace App\Http\Controllers\Student;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class ProfileController extends Controller
{
    // to change password page
    public function changePasswordPage(){
        return view('Student.profile.changePassword');
    }
    // change password
    public function changePassword(Request $request)
    {
            $user = User::find(Auth::user()->id);
            $userOldPassword = $user->password;

            // 1. Validation Logic
            // We only require 'oldPassword' if the user actually has one in the DB
            $rules = [
                'newPassword' => 'required|min:8',
                'confirmPassword' => 'required|same:newPassword',
            ];

            if ($userOldPassword != null) {
                $rules['oldPassword'] = 'required';
            }

            $request->validate($rules);

            // 2. Password Update Logic
            // IF user has a password, we MUST check it.
            // IF user has NO password (Social Login), we let them set it directly.
            if ($userOldPassword == null || Hash::check($request->oldPassword, $userOldPassword)) {

                $user->update([
                    'password' => Hash::make($request->newPassword)
                ]);

                Alert::success('Success', 'Password updated successfully!');
                return back();

            } else {
                Alert::error('Error', 'Current password does not match!');
                return back();
            }
        }

    // to profile detail page
    public function detail(){
        return view('Student.profile.detail');
    }

    // update profile
    public function update(Request $request){
        $this->profileValidation($request);

       $data = $this->getProfileData($request);

         if ( $request ->hasFile('image')){
            if(Auth::user()->profile != null){
               if(file_exists( public_path('/profile/' . Auth::user()->profile ) ) ){
                   unlink(public_path('/profile/' . Auth::user()->profile));
               }
            }
            $fileName = uniqid() . $request->file("image")->getClientOriginalName();
            $request->file("image")-> move ( public_path() . "/profile/" , $fileName);
            $data['profile'] = $fileName;
         }
         else{
            $data['profile'] = Auth::user()->profile;
         }

         User::where('id',Auth::user()->id)->update($data);

         Alert::success('Success Title', 'Profile updated successully');

         return to_route('student#dashboard');
    }

    //get profile data
        private function getProfileData($request){
        return [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ];
        }

      // profile validation
    private function profileValidation($request){
       // dd(Auth::user()->id, $request->id);

       $request->validate([
         'name' => 'required|min:2|max:30',
         'email' => 'required|unique:users,email,' . Auth::user()->id . ',id',

         'phone' => 'required|max:11',
         'address' => 'max:100',
         'profile' => 'file|mimes:png,jpg,svg,gif,jpeg'
       ]);
    }



      // password validation
    private function checkPasswordValidation($request){
        $request->validate([
         'oldPassword' => 'required',
         'newPassword' => 'required|min:6|max:12',
         'confirmPassword' => 'required|min:6|max:12|same:newPassword'
        ]);
    }
}
