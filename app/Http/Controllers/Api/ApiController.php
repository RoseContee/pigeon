<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\Template;
use App\Models\ApiToken;
use App\Models\App;
use App\Models\Guest;
use App\Models\MailTemplate;
use App\Models\Meeting;
use App\Models\Membership;
use App\Models\User;
use App\Models\UserMeta;
use App\Models\Word;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
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
        $apps = App::active()->get(['id', 'name', 'image']);
        foreach($apps as $app) {
            $app['image'] = asset('public/uploads/'.$app['image']);
        }
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
                $user['email_verified_at'] = date('Y-m-d H:i:s');
                $user['password'] = Hash::make(Str::random(8));
                $user['membership_id'] = $member['id'];
                $user['limitation'] = $member['limitation'];
                $user['event'] = $member['event'];
                $user['schedule'] = $member['schedule'];
                $user['start_date'] = now();
                if ($member['membership_package']['unit'] == 'month') {
                    $user['end_date'] = now()->addMonths($member['membership_package']['period']);
                } else {
                    $user['end_date'] = now()->addYears($member['membership_package']['period']);
                }
                $user['booking_number'] = 0;
                $user['active'] = 1;
                $user['google_id'] = $request['google_id'];
                $user['avatar'] = $request['avatar'];
                $user->save();
                try {
                    $mail = MailTemplate::ofCategory('signup')->first();
                    $subject = str_replace('{Name}', $user['name'], $mail['subject']);
                    $mail_body = str_replace('{Name}', $user['name'], $mail['body']);
                    $data = [
                        'subject' => $subject,
                        'mail_body' => $mail_body,
                    ];
                    Mail::to($user['email'])->send(new Template($data));
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
                        'apps' => UserMeta::getSetting($user['id']),
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
                    'apps' => UserMeta::getSetting($user['id']),
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

    public function createZoomLink(Request $request) {
        $rule = [
            'access_token' => ['required'],
            'topic' => ['required'],
            'start_time' => ['required'],
            'password' => ['required'],
        ];
        $validator = Validator::make($request->all(), $rule);
        $message = [];
        if ($validator->fails()) {
            $status = 403;
        } else {
            $client = new Client();
            try {
                $response = $client->request('POST', "https://api.zoom.us/v2/users/me/meetings", [
                    'headers' => [
                        'Authorization' => "Bearer $request[access_token]",
                        'Content-Type' => 'application/json'
                    ],
                    'body' => json_encode([
                         "topic" => $request['topic'],
                         "type" => 2,
                         "start_time" => $request['start_time'],
                         "password" => $request['password'],
                    ])
                ]);
                $status = $response->getStatusCode();
                $result = json_decode($response->getBody()->getContents(), true);
                if (!empty($result['join_url'])) {
                    $message['zoom_link'] = $result['join_url'];
                }
            } catch(\Exception $exception) {
                $status = 403;
            }
        }
        return response($message, $status);
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
            $meeting = new Meeting();
            $meeting['user_id'] = $user['id'];
            $meeting['app_id'] = $request['app'];
            $meeting['event_name'] = $request['event_name'];
            $meeting['host_name'] = $request['host_name'];
            $meeting['guests'] = implode(',', $request['guests']);
            $meeting['booking_time'] = date('Y-m-d H:i:00', strtotime($request['event_date']));
            $meeting['timezone'] = $request['timezone'];

            $timezone = date_default_timezone_get();
            $meeting_time = date_create($meeting['booking_time'], timezone_open($meeting['timezone']));
            date_timezone_set($meeting_time, timezone_open($timezone));
            $meeting['server_time'] = $meeting_time->format('Y-m-d H:i:s');

            $meeting->save();

            $user['limitation'] = $user['limitation'] - 1;
            $user['booking_number'] = $user['booking_number'] + 1;
            $user->save();

            if ($user['booking_number'] == 10) {
                try {
                    $mail = MailTemplate::ofCategory('rate-review')->first();
                    $subject = str_replace('{Name}', $user['name'], $mail['subject']);
                    $mail_body = str_replace('{Name}', $user['name'], $mail['body']);
                    $data = [
                        'subject' => $subject,
                        'mail_body' => $mail_body,
                    ];
                    Mail::to($user['email'])->send(new Template($data));
                } catch (\Exception $exception) {
                }
            }
        }
        return response([
            'status' => $status,
            'message' => $message,
        ]);
    }
}
