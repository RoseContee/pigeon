<?php

namespace App\Http\Controllers;

use App\Mail\NewRegister;
use App\Models\Membership;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    public function authGoogle() {
        return Socialite::driver('google')->redirect();
    }

    public function authGoogleCallback(Request $request) {
        try {
            $googleUser = Socialite::driver('google')->user();
            $googleUser = json_decode(json_encode($googleUser), true);
            $user = User::where('email', $googleUser['email'])->first();
            if($user) {
                $message = 'Welcome to back';
                if (empty($user['google_id'])) {
                    $user['google_id'] = $googleUser['id'];
                    $user->save();
                }
            } else {
                $member = Membership::where('price', 0)->first();
                if (empty($member)) {
                    return back()->withInput()->with('error_message', 'Cannot use at this time.');
                }
                $user = new User();
                $user['name'] = $googleUser['name'];
                $user['email'] = $googleUser['email'];
                $user['password'] = Hash::make(Str::random(8));
                $user['membership_id'] = $member['id'];
                $user['limitation'] = $member['limitation'];
                $user['start_date'] = now();
                if ($member['membership_package']['unit'] == 'month') {
                    $user['end_date'] = now()->addMonths($member['membership_package']['period']);
                } else {
                    $user['end_date'] = now()->addYears($member['membership_package']['period']);
                }
                $user['google_id'] = $googleUser['id'];
                $user['avatar'] = $googleUser['avatar'];
                $user->save();
                try {
                    $data = [
                        'name' => $user['name'],
                    ];
                    Mail::to($user['email'])->send(new NewRegister($data));
                } catch (\Exception $exception) {
                }
                $message = 'Welcome to you!';
            }
            Auth::loginUsingId($user['id']);
            return redirect()->route('home')->with('info_message', $message);
        } catch (\Exception $exception) {
            $message = 'Cannot use google function at this time';
            if (!empty($request['error_description'])) $message = $request['error_description'];
            return view('user.auth.not-found', [
                'error_message' => $message,
            ]);
        }
    }

    public function authLinkedIn() {
        return Socialite::driver('linkedin')->redirect();
    }

    public function authLinkedInCallback(Request $request) {
        try {
            $linkdinUser = Socialite::driver('linkedin')->user();
            $linkdinUser = json_decode(json_encode($linkdinUser), true);
            $user = User::where('email', $linkdinUser['email'])->first();
            if($user) {
                $message = 'Welcome to back';
            } else {
                $member = Membership::where('price', 0)->first();
                if (empty($member)) {
                    return back()->withInput()->with('error_message', 'Cannot use at this time.');
                }
                $user = new User();
                $user['name'] = $linkdinUser['name'];
                $user['email'] = $linkdinUser['email'];
                $user['password'] = Hash::make(Str::random(8));
                $user['membership_id'] = $member['id'];
                $user['limitation'] = $member['limitation'];
                $user['start_date'] = now();
                if ($member['membership_package']['unit'] == 'month') {
                    $user['end_date'] = now()->addMonths($member['membership_package']['period']);
                } else {
                    $user['end_date'] = now()->addYears($member['membership_package']['period']);
                }
                $user['linkedin_id'] = $linkdinUser['id'];
                $user['avatar'] = $linkdinUser['avatar'];
                $user->save();
                try {
                    $data = [
                        'name' => $user['name'],
                    ];
                    Mail::to($user['email'])->send(new NewRegister($data));
                } catch (\Exception $exception) {
                }
                $message = 'Welcome to you!';
            }
            Auth::loginUsingId($user['id']);
            return redirect()->route('home')->with('info_message', $message);
        } catch (\Exception $e) {
            $message = 'Cannot use linked function at this time';
            if (!empty($request['error_description'])) $message = $request['error_description'];
            return view('user.auth.not-found', [
                'error_message' => $message,
            ]);
        }
    }
}
