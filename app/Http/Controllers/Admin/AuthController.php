<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\ForgotPassword;
use App\Mail\NotifyResetPassword;
use App\Models\Admin;
use App\Models\PasswordReset;
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
        return view('admin.auth.login');
    }

    public function postLogin(Request $request) {
        $rule = [
            'email' => ['required', 'email'],
            'password' => ['required'],
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('error_message', 'Make sure all validations');
        }
        if (Auth::guard('admin')->attempt($request->only(['email', 'password']))) {
            return redirect()->route('admin');
        }
        return back()->withInput()->with('error_message', 'Email or Password does not match.');
    }

    public function forgot() {
        return view('admin.auth.forgot-password');
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
            $password_reset = PasswordReset::type('admin')->where('email', $email)->first();
            if (empty($password_reset)) {
                PasswordReset::insert([
                    'type' => 'admin',
                    'email' => $email,
                    'token' => $password_reset['token'] = $token,
                    'created_at' => now(),
                ]);
            } else if (empty($password_reset['token']) || now()->diffInSeconds(new Carbon($password_reset['created_at'])) > 15 * 60) {
                PasswordReset::type('admin')->where('email', $email)->update([
                    'token' => $password_reset['token'] = $token,
                    'created_at' => now(),
                ]);
            }
            $data = [
                'name' => $email,
                'route' => 'admin.reset-password',
                'link' => $password_reset['token'],
            ];
            Mail::to($email)->send(new ForgotPassword($data));
        } catch(\Exception $exception) {
            return back()->withInput()->with('error_message', 'Sorry! Some went error. Please try again.');
        }
        return back()->with('info_message', 'We sent rest link to your email. If you did not receive, please try again.');
    }

    public function reset($link) {
        $password_reset = PasswordReset::type('admin')->where('token', $link)->first();
        if (empty($password_reset)) {
            return view('admin.auth.not-found', [
                'error_message' => 'Your reset request is invalid. Please check your inbox again.',
            ]);
        }
        if (now()->diffInSeconds(new Carbon($password_reset['created_at'])) > 15 * 60) {
            $password_reset['token'] = null;
            $password_reset->save();
            return view('admin.auth.not-found', [
                'error_message' => 'This reset link is already expired. Please try again.',
            ]);
        }
        $admin = Admin::where('email', $password_reset['email'])->first();
        if (empty($admin)) {
            $password_reset->delete();
            return view('admin.auth.not-found', [
                'error_message' => 'Your reset request is invalid. Your account does not exist anymore.',
            ]);
        }
        return view('admin.auth.reset-password');
    }

    public function postReset($link, Request $request) {
        $password_reset = PasswordReset::type('admin')->where('token', $link)->first();
        if (empty($password_reset)) {
            return view('admin.auth.not-found', [
                'error_message' => 'Your reset request is invalid. Please check your inbox again.',
            ]);
        }
        if (now()->diffInSeconds(new Carbon($password_reset['created_at'])) > 15 * 60) {
            $password_reset['token'] = null;
            $password_reset->save();
            return view('admin.auth.not-found', [
                'error_message' => 'This reset link is already expired. Please try again.',
            ]);
        }
        $admin = Admin::where('email', $password_reset['email'])->first();
        if (empty($admin)) {
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
        $admin['password'] = Hash::make($request['password']);
        $admin->save();
        try {
            $data = [
                'route' => 'admin.login',
                'name' => $admin['email'],
            ];
            Mail::to($admin['email'])->send(new NotifyResetPassword($data));
        } catch(\Exception $exception) {
        }
        return redirect()->route('admin.login')->with('info_message', 'Your password has been reset successfully.');
    }
}
