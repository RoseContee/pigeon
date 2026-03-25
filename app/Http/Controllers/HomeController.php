<?php

namespace App\Http\Controllers;

use App\Mail\EmailChagned;
use App\Models\App;
use App\Models\Guest;
use App\Models\Meeting;
use App\Models\Membership;
use App\Models\MembershipPackage;
use App\Models\User;
use App\Models\UserMeta;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    public function __construct(Guard $auth) {
        //$this->middleware('auth');
    }

    public function dashboard() {
        $now = date('Y-m-d H:i:s', strtotime('-1 days'));
        $timezone = getTimezone();
        if ($timezone != 'Unknown') {
            date_default_timezone_set($timezone);
            $now = date('Y-m-d H:i:s', strtotime('-1 days'));
        }
        $meetings = Meeting::where('user_id', Auth::id())
            ->where('booking_time', '>=', $now)
            ->orderBy('booking_time', 'asc')
            ->get();
        $now = date('Y-m-d');
        $today_meetings = $upcomings = [];
        foreach ($meetings as $meeting) {
            $meeting_time = date_create($meeting['booking_time'], timezone_open($meeting['timezone']));
            if ($timezone != 'Unknown') {
                date_timezone_set($meeting_time, timezone_open($timezone));
            }
            $meeting['booking_time'] = $meeting_time->format('Y-m-d H:i:s');
            if (stripos($meeting['booking_time'], $now) !== false) {
                $today_meetings[] = $meeting;
            } else if ($meeting['booking_time'] >= $now.' 00:00:00') {
                $upcomings[] = $meeting;
            }
        }

        return view('user.dashboard', [
            'menu' => 'Dashboard',
            'meetings' => $today_meetings,
            'upcomings' => $upcomings,
        ]);
    }

    public function profile() {
        $user_setting = UserMeta::getSetting(Auth::id());
        return view('user.profile', [
            'menu' => 'Profile',
            'user_setting' => $user_setting,
        ]);
    }

    public function postProfile(Request $request) {
        $rule = [
            'name' => ['required'],
            'email' => ['required'],
        ];
        if ($request->hasFile('avatar')) {
            $rule['avatar'] = ['required', 'image', 'dimensions:ratio=1'];
        }
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $user = User::find(Auth::id());
        $user['name'] = $request['name'];
        if (strcasecmp($user['email'], $request['email']) != 0) $old_email = $user['email'];
        $user['email'] = $request['email'];
        if ($request->hasFile('avatar') && ($avatar = $request->file('avatar')->store('avatar'))) {
            $user['avatar'] = asset('public/uploads/'.$avatar);
        }
        $user->save();
        UserMeta::saveSetting(Auth::id(), $request->only(['headline', 'position', 'secondary_email']));
        $message = '';
        if (!empty($old_email)) {
            try {
                $data = [
                    'name' => $user['name'],
                    'email' => $user['email'],
                ];
                Mail::to($old_email)->send(new EmailChagned($data));
            } catch(\Exception $exception) {
            }
            $message = '. And your account email has been updated.';
        }
        return back()->with('info_message', 'Successfully saved'.$message);
    }

    public function meetings() {
        $meetings = Meeting::where('user_id', Auth::id())
            ->orderBy('booking_time', 'desc')
            ->get();
        $timezone = getTimezone();
        if ($timezone != 'Unknown') {
            date_default_timezone_set($timezone);
        }
        return view('user.meetings', [
            'menu' => 'Meetings',
            'meetings' => $meetings,
            'timezone' => $timezone,
        ]);
    }

    public function guests() {
        $guests = Guest::where('user_id', Auth::id())->get();
        return view('user.guests.index', [
            'menu' => 'Guests',
            'guests' => $guests,
        ]);
    }

    public function addGuest() {
        return view('user.guests.add', [
            'menu' => 'Guests',
        ]);
    }

    public function postAddGuest(Request $request) {
        $rule = [
            'email' => ['required', 'email'],
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $email = $request['email'];
        $guest = Guest::where('user_id', Auth::id())->where('email', $email)->first();
        if (!empty($guest)) {
            return back()->withInput()->with('error_message', 'email already exists');
        }
        $guest = new Guest();
        $guest['user_id'] = Auth::id();
        $guest['name'] = $request['name'];
        $guest['email'] = $email;
        $guest->save();
        return redirect()->route('guests')->with('info_message', 'Guest has been added');
    }

    public function editGuest($email) {
        $guest = Guest::where('user_id', Auth::id())->where('email', $email)->first();
        if (empty($guest)) {
            return back()->with('error_message', 'Cannot find guest info');
        }
        return view('user.guests.add', [
            'menu' => 'Guests',
            'guest' => $guest,
        ]);
    }

    public function postEditGuest($email, Request $request) {
        $guest = Guest::where('user_id', Auth::id())->where('email', $email)->first();
        if (empty($guest)) {
            return back()->with('error_message', 'Cannot find guest info');
        }
        $rule = [
            'email' => ['required', 'email'],
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        if ($email != $request['email'] && !empty(Guest::where('user_id', Auth::id())->where('email', $request['email'])->first())) {
            return back()->withInput()->with('email_error', 'This email already exists');
        }
        $guest['name'] = $request['name'];
        $guest['email'] = $request['email'];
        $guest->save();
        return redirect()->route('guests')->with('info_message', 'Guest has been saved');
    }

    public function deleteGuest(Request $request) {
        $email = $request['email'];
        $guest = Guest::where('user_id', Auth::id())->where('email', $email)->first();
        if (empty($guest)) {
            return back()->with('error_message', 'Cannot find guest info');
        }
        $guest->delete();
        return back()->with('info_message', 'Guest has been removed');
    }

    public function apps() {
        $apps = App::active()->get();
        $user_setting = UserMeta::getSetting(Auth::id());
        return view('user.apps.index', [
            'menu' => 'Apps',
            'apps' => $apps,
            'app_data' => $user_setting,
        ]);
    }

    public function editApp($name) {
        $app = App::where('name', $name)->first();
        if (empty($app)) {
            return back()->with('error_message', 'Cannot find app data');
        }
        $app_data = UserMeta::getSetting(Auth::id(), 'app_%_'.$app['id'], 'like');
        return view('user.apps.edit', [
            'menu' => 'Apps',
            'app' => $app,
            'app_data' => $app_data,
        ]);
    }

    public function postEditApp($name, Request $request) {
        $app = App::where('name', $name)->first();
        if (empty($app)) {
            return back()->with('error_message', 'Cannot find app data');
        }
        $rule = [];
        if ($app['id'] == 1) {
            $rule = [
                'link' => ['required', 'url'],
            ];
        } else if ($app['id'] == 2) {
            $rule = [
                'link' => ['required', 'url'],
                'passcode' => ['required'],
            ];
        }
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $data = [];
        if ($app['id'] == 1) {
            $data['app_link_1'] = $request['link'];
        } else if ($app['id'] == 2) {
            $data = [
                'app_link_2' => $request['link'],
                'app_passcode_2' => $request['passcode'],
            ];
        }
        UserMeta::saveSetting(Auth::id(), $data);
        return redirect()->route('apps')->with('info_message', '');
    }

    public function membership() {
        $packages = MembershipPackage::active()->get();
        $memberships = Membership::active()->get();
        $current = Auth::user()->membership;
        return view('user.membership.index', [
            'menu' => 'Membership',
            'packages' => $packages,
            'memberships' => $memberships,
            'current' => $current,
        ]);
    }
}
