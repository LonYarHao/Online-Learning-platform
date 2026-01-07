<?php

namespace App\Http\Controllers\Teacher;

use App\Models\c;
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
        return view('Teacher.Profile.changePassword');
    }

    // change password
    public function changePassword(Request $request){
        $userOldPassword = Auth::user()->password;

       if(Hash::check($request->oldPassword, $userOldPassword)){
        $this->checkPasswordValidation($request);

        User::where('id',Auth::user()->id)->update([
          'password' => Hash::make($request->newPassword)

        ]);
          Alert::success('Success Title', 'password change successfully');

          return back();

       }else{
        Alert::error('Error Title', 'old passwords do not match! try again...');
        return back();
       }
    }

    // to profile detail page
    public function detail(){
        return view('Teacher.Profile.detail');
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

         return to_route('teacher#dashboard');
    }


    // password validation
    private function checkPasswordValidation($request){
        $request->validate([
         'oldPassword' => 'required',
         'newPassword' => 'required|min:6|max:12',
         'confirmPassword' => 'required|min:6|max:12|same:newPassword'
        ]);
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
       $request->validate([
         'name' => 'required|min:2|max:30',
         'email' => 'required|unique:users,email,'.Auth::user()->id,
         'phone' => 'required|max:11',
         'address' => 'max:100',
         'profile' => 'file|mimes:png,jpg,svg,gif,jpeg'
       ]);
    }
}
