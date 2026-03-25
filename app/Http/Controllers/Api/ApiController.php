<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\NewRegister;
use App\Models\ApiToken;
use App\Models\App;
use App\Models\Guest;
use App\Models\Meeting;
use App\Models\Membership;
use App\Models\User;
use App\Models\UserMeta;
use App\Models\Word;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ApiController extends Controller
{
    public function words() {
        $words = Word::pluck('word')->toArray();
        return response($words);
    }

    public function apps() {
        $apps = App::active()->get(['id', 'name']);
        return response($apps);
    }

    public function getToken() {
        $expiration = date('Y-m-d H:i:s', strtotime('-15 minutes'));
        ApiToken::where('created_at', '<', $expiration)->delete();
        $token = new ApiToken();
        $token['token'] = Str::random(80);
        $token->save();
        return response([
            'status' => 200,
            'result' => $token['token'],
        ]);
    }

    public function login(Request $request) {
        $token = null;
        $rule = [
            'email' => ['required', 'email'],
            'password' => 'required',
        ];
        $validator = Validator::make($request->all(), $rule);
        $message = [];
        if ($validator->fails()) {
            $errors = $validator->errors();
            if ($errors->has('email')) $message['email'] = $errors->first('email');
            if ($errors->has('password')) $message['password'] = $errors->first('password');
            $message['error'] = 'Make sure all validation';
            $status = 403;
        } else {
            if (Auth::check() && $request['email'] != Auth::user()->email) Auth::logout();
            if (!Auth::check()) {
                Auth::attempt([
                    'email' => $request['email'],
                    'password' => $request['password'],
                ]);
            }
            if (Auth::check()) {
                if (Auth::user()->active == 1) {
                    $user = User::find(Auth::id());
                    $user['api_token'] = Str::random(80);
                    $user->save();
                    $guests = Guest::where('user_id', $user['id'])->pluck('email')->toArray();
                    $message = [
                        'token' => $user['api_token'],
                        'user' => [
                            'name' => $user['name'],
                            'email' => $user['email'],
                            'guests' => $guests,
                            'app' => UserMeta::getSetting($user['id']),
                        ],
                        'current' => $user['limitation'],
                        'membership' => $user['membership']['name'],
                        'limitation' => $user['membership']['limitation'],
                    ];
                    $status = 200;
                } else {
                    $message['error'] = 'Your account has been deactivated now.';
                    $status = 403;
                }
            } else {
                $message['error'] = 'This credentials does not match!';
                $status = 403;
            }
        }
        return response([
            'status' => $status,
            'result' => $message,
        ]);
    }

    public function authGoogle(Request $request) {
        $expiration = date('Y-m-d H:i:s', strtotime('-15 minutes'));
        ApiToken::where('created_at', '<', $expiration)->delete();

        $rule = [
            'token' => ['required', 'exists:api_tokens'],
            'access_token' => ['required'],
            'email' => ['required', 'email'],
            'google_id' => ['required'],
        ];
        $validator = Validator::make($request->all(), $rule);
        $message = [];
        if ($validator->fails()) {
            $message['error'] = 'Forbidden';
            $status = 403;
        } else {
            $user = User::where('email', $request['email'])->first();
            if (empty($user)) {
                $member = Membership::where('price', 0)->first();
                if (empty($member)) {
                    ApiToken::where('token', $request['token'])->delete();

                    $message['error'] = 'Cannot use at this time';
                    $status = 403;
                    return response([
                        'status' => $status,
                        'result' => $message,
                    ]);
                }
                $user = new User();
                $user['name'] = $request['name'];
                $user['email'] = $request['email'];
                $user['password'] = Hash::make(Str::random(8));
                $user['membership_id'] = $member['id'];
                $user['limitation'] = $member['limitation'];
                $user['start_date'] = now();
                if ($member['membership_package']['unit'] == 'month') {
                    $user['end_date'] = now()->addMonths($member['membership_package']['period']);
                } else {
                    $user['end_date'] = now()->addYears($member['membership_package']['period']);
                }
                $user['google_id'] = $request['google_id'];
                $user['avatar'] = $request['avatar'];
                $user->save();
                try {
                    $data = [
                        'name' => $user['name'],
                    ];
                    Mail::to($user['email'])->send(new NewRegister($data));
                } catch (\Exception $exception) {
                }
            } else {
                if (empty($user['google_id'])) {
                    $user['google_id'] = $request['google_id'];
                    $user->save();
                }
            }
            $user['api_token'] = $request['access_token'];
            $user->save();

            if ($user['active'] == 1) {
                $guests = Guest::where('user_id', $user['id'])->pluck('email')->toArray();
                $message = [
                    'user' => [
                        'name' => $user['name'],
                        'email' => $user['email'],
                        'guests' => $guests,
                        'app' => UserMeta::getSetting($user['id']),
                    ],
                    'current' => $user['limitation'],
                    'membership' => $user['membership']['name'],
                    'limitation' => $user['membership']['limitation'],
                ];
                $status = 200;
            } else {
                $message['error'] = 'Your account has been deactivated now.';
                $status = 403;
            }
        }
        ApiToken::where('token', $request['token'])->delete();
        return response([
            'status' => $status,
            'result' => $message,
        ]);
    }

    public function getUserInfo(Request $request) {
        $email = $request['email'];
        $user = User::where('email', $email)->first();
        if (empty($user)) {
            return response([
                'status' => 404,
            ]);
        }
        $user['api_token'] = $request['access_token'];
        $user->save();
        
        $guests = Guest::where('user_id', $user['id'])->pluck('email')->toArray();
        return response([
            'status' => 200,
            'result' => [
                'user' => [
                    'name' => $user['name'],
                    'email' => $user['email'],
                    'guests' => $guests,
                    'app' => UserMeta::getSetting($user['id']),
                ],
                'current' => $user['limitation'],
                'membership' => $user['membership']['name'],
                'limitation' => $user['membership']['limitation'],
            ],
        ]);
    }

    public function addGuest(Request $request) {
        $token = $request['token'];
        $user = User::where('api_token', $token)->first();
        if (empty($user)) {
            return response([
                'status' => 401,
            ]);
        }
        $rule = [
            'email' => ['required', 'email'],
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return response([
                'status' => 403,
            ]);
        }
        if (strcasecmp($user['email'], $request['email']) != 0) {
            Guest::updateOrCreate([
                'user_id' => $user['id'],
                'name' => '',
                'email' => $request['email'],
            ]);
        }
        return response([
            'status' => 200,
        ]);
    }

    public function createEvent(Request $request) {
        $token = $request['token'];
        $user = User::where('api_token', $token)->first();
        if (empty($user)) {
            return response([
                'status' => 401,
            ]);
        }
        $rule = [
            'app' => ['required', 'exists:apps,id'],
            'event_name' => ['required'],
            'host_name' => ['required'],
            'guests' => ['required', 'array'],
            'event_date' => ['required'],
            'timezone' => ['required'],
        ];
        $validator = Validator::make($request->all(), $rule);
        $message = [];
        $status = 200;
        if ($validator->fails()) {
            $errors = $validator->errors();
            if ($errors->has('app')) $message['app'] = $errors->first('app');
            if ($errors->has('event_name')) $message['event-name'] = $errors->first('event_name');
            if ($errors->has('guests')) $message['guests'] = $errors->first('guests');
            if ($errors->has('event_date')) $message['event-date'] = $errors->first('event_date');
            $message['main'] = 'Make sure all validation';
            $status = 403;
        }
        if ($user['limitation'] == 0) {
            $status = 406;
        } else {
            UserMeta::saveSetting($user['id'], $request['attr']);
            $meeting = new Meeting();
            $meeting['user_id'] = $user['id'];
            $meeting['app_id'] = $request['app'];
            $meeting['event_name'] = $request['event_name'];
            $meeting['host_name'] = $request['host_name'];
            $meeting['guests'] = implode(',', $request['guests']);
            $meeting['booking_time'] = date('Y-m-d H:i:00', strtotime($request['event_date']));
            $meeting['timezone'] = $request['timezone'];
            $meeting->save();

            $user['limitation'] = $user['limitation'] - 1;
            $user->save();
        }
        return response([
            'status' => $status,
            'message' => $message,
        ]);
    }
}
