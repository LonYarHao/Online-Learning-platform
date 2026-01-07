<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SocialLoginController extends Controller
{
     public function redirect($provider){
         return Socialite::driver($provider)->redirect();
    }

    public function callback($provider){
        $socialLoginData = Socialite::driver($provider)->user();

        $user = User::updateOrCreate([
            'provider_id' => $socialLoginData->id,
        ], [
            'name' => $socialLoginData->name,
            'email' => $socialLoginData->email,
            'user_name' => $socialLoginData->nickname,
            'profile' => $socialLoginData->avatar,
            'provider' => $provider,
            'provider_id' => $socialLoginData->id,
            'provider_token' => $socialLoginData->token,
            'role' => 'student',
        ]);

        Auth::login($user);


        return to_route('student#dashboard');
    }

    }
