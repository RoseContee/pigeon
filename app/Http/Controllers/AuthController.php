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

    public function signup() {
        return view('user.auth.register');
    }
}
