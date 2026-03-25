<?php

namespace App\Http\Controllers;

use App\Mail\ForgotPassword;
use App\Mail\NewRegister;
use App\Mail\NotifyResetPassword;
use App\Mail\VerifyEmail;
use App\Models\Membership;
use App\Models\PasswordReset;
use App\Models\User;
use App\Models\UserMeta;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login() {
        return view('user.auth.login');
    }

    public function postLogin(Request $request) {
        $rule = [
            'email' => ['required', 'email'],
            'password' => ['required'],
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        if (Auth::attempt($request->only(['email', 'password']))) {
            if (Auth::user()->active == 1) {
                $user_app = UserMeta::getSetting(Auth::id(), ['app_link_1', 'app_link_2']);
                if (empty($user_app['app_link_1']) || empty($user_app['app_link_2'])) {
                    return redirect()->route('apps')->with('info_message', 'Welcome '.Auth::user()->name.'. Please connect meeting platform.');
                }
                return redirect()->route('home')->with('info_message', 'Welcome '.Auth::user()->name.'!');
            }
            return back()->withInput()->with('error_message', 'Your account has been deactivated now.');
        }
        return back()->withInput()->with('error_message', 'Invalid credentials');
    }

    public function forgot() {
        return view('user.auth.forgot-password');
    }

    public function postForgot(Request $request) {
        $rule = [
            'email' => ['required', 'email', 'exists:users'],
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('error_message', 'Cannot find your account.');
        }
        try {
            $email = $request['email'];
            $token = Str::random(32);
            $password_reset = PasswordReset::type('user')->where('email', $email)->first();
            if (empty($password_reset)) {
                PasswordReset::insert([
                    //'type' => 'user',
                    'email' => $email,
                    'token' => $password_reset['token'] = $token,
                    'created_at' => now(),
                ]);
            } else if (empty($password_reset['token']) || now()->diffInSeconds(new Carbon($password_reset['created_at'])) > 15 * 60) {
                PasswordReset::type('user')->where('email', $email)->update([
                    'token' => $password_reset['token'] = $token,
                    'created_at' => now(),
                ]);
            }
            $data = [
                'name' => $email,
                'route' => 'reset-password',
                'link' => $password_reset['token'],
            ];
            Mail::to($email)->send(new ForgotPassword($data));
        } catch(\Exception $exception) {
            return back()->withInput()->with('error_message', 'Sorry! Some went error. Please try again.');
        }
        return back()->with('info_message', 'We sent rest link to your email. If you did not receive, please try again.');
    }

    public function reset($link) {
        $password_reset = PasswordReset::type('user')->where('token', $link)->first();
        if (empty($password_reset)) {
            return view('user.auth.not-found', [
                'error_message' => 'Your reset request is invalid. Please check your inbox again.',
            ]);
        }
        if (now()->diffInSeconds(new Carbon($password_reset['created_at'])) > 15 * 60) {
            $password_reset['token'] = null;
            $password_reset->save();
            return view('user.auth.not-found', [
                'error_message' => 'This reset link is already expired. Please try again.',
            ]);
        }
        $user = User::where('email', $password_reset['email'])->first();
        if (empty($user)) {
            $password_reset->delete();
            return view('user.auth.not-found', [
                'error_message' => 'Your reset request is invalid. Your account does not exist anymore.',
            ]);
        }
        return view('user.auth.reset-password');
    }

    public function postReset($link, Request $request) {
        $password_reset = PasswordReset::type('user')->where('token', $link)->first();
        if (empty($password_reset)) {
            return view('user.auth.not-found', [
                'error_message' => 'Your reset request is invalid. Please check your inbox again.',
            ]);
        }
        if (now()->diffInSeconds(new Carbon($password_reset['created_at'])) > 15 * 60) {
            $password_reset['token'] = null;
            $password_reset->save();
            return view('user.auth.not-found', [
                'error_message' => 'This reset link is already expired. Please try again.',
            ]);
        }
        $user = User::where('email', $password_reset['email'])->first();
        if (empty($user)) {
            $password_reset->delete();
            return view('user.auth.not-found', [
                'error_message' => 'Your reset request is invalid. Your account does not exist anymore.',
            ]);
        }
        $rule = [
            'password' => ['required', 'confirmed'],
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return back()->withErrors($validator)->with('error_message', 'Password does not match.');
        }
        $user['password'] = Hash::make($request['password']);
        $user->save();
        try {
            $data = [
                'route' => 'login',
                'name' => $user['name'],
            ];
            Mail::to($user['email'])->send(new NotifyResetPassword($data));
        } catch(\Exception $exception) {
        }
        return redirect()->route('login')->with('info_message', 'Your password has been reset successfully.');
    }

    public function signup() {
        return view('user.auth.register');
    }

    public function postSignup(Request $request) {
        $rule = [
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'confirmed'],
            'terms' => ['required'],
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('error_message', 'Make sure all validation rules');
        }
        $member = Membership::where('price', 0)->first();
        if (empty($member)) {
            return back()->withInput()->with('error_message', 'Cannot use at this time.');
        }
        $user = new User();
        $user['name'] = $request['name'];
        $user['email'] = $request['email'];
        $user['password'] = Hash::make($request['password']);
        $user['membership_id'] = $member['id'];
        $user['limitation'] = $member['limitation'];
        $user['start_date'] = now();
        $user['end_date'] = now()->addDays($member['period']);
        $user->save();
        try {
            $data = [
                'name' => $user['name'],
                'link' => encrypt($user['email']),
            ];
            Mail::to($user['email'])->send(new VerifyEmail($data));
        } catch (\Exception $exception) {
        }
        Auth::loginUsingId($user['id']);
        return redirect()->route('home')->with('info_message', 'Welcome! Please verify your email.');
    }

    public function verifyEmail($link) {
        try {
            $email = decrypt($link);
        } catch (\Exception $exception) {
            return view('user.auth.not-found', [
                'error_message' => 'Your verification request is invalid. Please check your inbox again.',
            ]);
        }
        $user = User::where('email', $email)->first();
        if (empty($user)) {
            return view('user.auth.not-found', [
                'error_message' => 'Your verification request is invalid. Please check your inbox again.',
            ]);
        }
        if (!Auth::check()) Auth::loginUsingId($user['id']);
        if (!empty($user['email_verified_at'])) {
            return redirect()->route('home')->with('info_message', $user['email'].' is already verified.');
        }
        $user['email_verified_at'] = date('Y-m-d H:i:s');
        $user->save();
        try {
            $data = [
                'name' => $user['name'],
            ];
            Mail::to($user['email'])->send(new NewRegister($data));
        } catch (\Exception $exception) {}
        return redirect()->route('home')->with('info_message', $user['email'].' is verified successfully.');
    }
}
