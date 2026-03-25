<?php

namespace App\Http\Controllers;

use App\Mail\Template;
use App\Models\MailTemplate;
use App\Models\Membership;
use App\Models\User;
use App\Models\UserMeta;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
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
                $user['google_id'] = $googleUser['id'];
                $user['avatar'] = $googleUser['avatar'];
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
                $message = 'Welcome to you!';
            }
            if ($user['active'] != 1) {
                return redirect()->route('login')
                    ->with('error_message', 'Your account has been deactivated now.');
            }
            Auth::loginUsingId($user['id']);
            $redirect_url = session('redirect_url', null);
            if (empty($redirect_url)) {
                return redirect()->route('home')->with('info_message', $message);
            } else {
                return redirect($redirect_url);
            }
        } catch (\Exception $exception) {
            $message = 'Cannot use google function at this time';
            if (!empty($request['error_description'])) $message = $request['error_description'];
            return view('user.auth.not-found', [
                'error_message' => $message,
            ]);
        }
    }

    public function authZoom() {
        if (Auth::check()) {
            $client_id = env('ZOOM_CLIENT_ID');
            $redirect_url = env('ZOOM_CALLBACK_URL');
            return redirect("https://zoom.us/oauth/authorize?response_type=code&client_id=$client_id&redirect_uri=$redirect_url");
        } else {
            session([
                'redirect_url' => url()->full(),
            ]);
            return redirect()->route('login');
        }
    }

    public function authZoomCallback(Request $request) {
        if (Auth::check()) {
            if ($request['code']) {
                $client_id = env('ZOOM_CLIENT_ID');
                $client_secret = env('ZOOM_CLIENT_SECRET');
                $redirect_url = env('ZOOM_CALLBACK_URL');
                $client = new Client();
                try {
                    $response = $client->request('POST', 'https://zoom.us/oauth/token', [
                        'headers' => [
                            'Authorization' => 'Basic ' . base64_encode($client_id . ':' . $client_secret),
                        ],
                        'form_params' => [
                            'grant_type' => 'authorization_code',
                            'code' => $request['code'],
                            'redirect_uri' => $redirect_url,
                        ]
                    ]);
                    $token = json_decode($response->getBody()->getContents(), true);
                    $access_token = $token['access_token'];
                    $refresh_token = $token['refresh_token'];

                    $response = $client->request('GET', 'https://api.zoom.us/v2/users/me', [
                        'headers' => [
                            'Authorization' => "Bearer $access_token",
                        ],
                    ]);
                    $result = json_decode($response->getBody()->getContents(), true);
                    $zoom_id = $result['id'];
                    UserMeta::saveSetting(Auth::id(), [
                        'zoom_id' => $zoom_id,
                        'zoom_refresh_token' => $refresh_token,
                    ]);
                    return redirect()->route('apps')->with('info_message', 'Successfully connected zoom.');
                } catch (\Exception $exception) {
                }
            }
            return redirect()->route('apps')->with('error_message', 'Some went wrong. Please try again.');
        } else {
            session([
                'redirect_url' => url()->full(),
            ]);
            return redirect()->route('login');
        }
    }

    public function authZoomCallbackDev(Request $request) {
        if (Auth::check()) {
            if ($request['code']) {
                $client_id = env('ZOOM_CLIENT_ID');
                $client_secret = env('ZOOM_CLIENT_SECRET');
                $redirect_url = env('ZOOM_CALLBACK_URL');
                $client = new Client();
                try {
                    $response = $client->request('POST', 'https://zoom.us/oauth/token', [
                        'headers' => [
                            'Authorization' => 'Basic ' . base64_encode($client_id . ':' . $client_secret),
                        ],
                        'form_params' => [
                            'grant_type' => 'authorization_code',
                            'code' => $request['code'],
                            'redirect_uri' => $redirect_url,
                        ]
                    ]);
                    $token = json_decode($response->getBody()->getContents(), true);
                    $access_token = $token['access_token'];
                    $refresh_token = $token['refresh_token'];

                    $response = $client->request('GET', 'https://api.zoom.us/v2/users/me', [
                        'headers' => [
                            'Authorization' => "Bearer $access_token",
                        ],
                    ]);
                    $result = json_decode($response->getBody()->getContents(), true);
                    $zoom_id = $result['id'];
                    UserMeta::saveSetting(Auth::id(), [
                        'zoom_id' => $zoom_id,
                        'zoom_refresh_token' => $refresh_token,
                    ]);
                    return redirect()->route('apps')->with('info_message', 'Successfully connected zoom.');
                } catch (\Exception $exception) {
                }
            }
            return redirect()->route('apps')->with('error_message', 'Some went wrong. Please try again.');
        } else {
            session([
                'redirect_url' => url()->full(),
            ]);
            return redirect()->route('login');
        }
    }

    public function deauthZoom(Request $request) {
        $rule = [
            'event' => ['required'],
            'payload' => ['required', 'array'],
            'payload.user_data_retention' => ['required'],
            'payload.account_id' => ['required'],
            'payload.user_id' => ['required'],
            'payload.signature' => ['required'],
            'payload.deauthorization_time' => ['required'],
            'payload.client_id' => ['required'],
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            if ($request->ajax()) return response([], 400);
            else return abort(400);
        }
        $payload = $request['payload'];
        if (!$payload['user_data_retention']) {
            $client_id = env('ZOOM_CLIENT_ID');
            $client_secret = env('ZOOM_CLIENT_SECRET');
            $client = new Client();
            try {
                $response = $client->request('POST', 'https://api.zoom.us/oauth/data/compliance', [
                    'headers' => [
                        'Authorization' => 'Basic ' . base64_encode($client_id . ':' . $client_secret),
                        'headers' => [
                            'Content-Type' => 'application/json'
                        ],
                    ],
                    'body' => json_encode([
                        "client_id" => $payload['client_id'],
                        "user_id" => $payload['user_id'],
                        "account_id" => $payload['account_id'],
                        "deauthorization_event_received" => $payload,
                        "compliance_completed" => true
                    ]),
                ]);
                //$token = json_decode($response->getBody()->getContents(), true);
                $httpcode = $response->getStatusCode();
                if ($request->ajax()) return response([], $httpcode);
                else return abort($httpcode);
            } catch (\Exception $exception) {
                if ($request->ajax()) return response([], 500);
                else return abort(500);
            }
        }
        if ($request->ajax()) return response([], 200);
        else return abort(200);
    }
}
