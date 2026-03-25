<?php

namespace App\Http\Controllers;

use App\Models\App;
use App\Models\Guest;
use App\Models\Meeting;
use App\Models\Membership;
use App\Models\MembershipPackage;
use App\Models\User;
use App\Models\UserEvent;
use App\Models\UserMeta;
use App\Models\UserSchedule;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class HomeController extends Controller
{
    public function __construct(Guard $auth) {
    }

    public function dashboard() {
        $now = date('Y-m-d');
        $meetings = Meeting::where('user_id', Auth::id())
            ->where('server_time', '>=', $now)
            ->orderBy('server_time', 'asc')
            ->get();
        $today_meetings = $upcomings = [];
        foreach ($meetings as $meeting) {
            if (stripos($meeting['server_time'], $now) !== false) {
                $today_meetings[] = $meeting;
            } else if ($meeting['server_time'] >= $now.' 00:00:00') {
                $upcomings[] = $meeting;
            }
        }
        $timezone = getTimezone();
        if ($timezone != 'Unknown') {
            date_default_timezone_set($timezone);
        }
        return view('user.dashboard', [
            'menu' => 'Dashboard',
            'meetings' => $today_meetings,
            'upcomings' => $upcomings,
            'timezone' => $timezone,
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
            $message = '. And your account email has been updated.';
        }
        return back()->with('info_message', 'Successfully saved'.$message);
    }

    public function meetings() {
        $meetings = Meeting::where('user_id', Auth::id())
            ->orderBy('server_time', 'desc')
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
        if (empty($guest)) return back()->with('error_message', 'Cannot find guest info');
        $guest->delete();
        return back()->with('info_message', 'Guest has been removed');
    }

    public function apps() {
        $apps = App::get();
        $user_meta = UserMeta::getSetting(Auth::id());
        return view('user.apps.index', [
            'apps' => $apps,
            'user_meta' => $user_meta,
        ])->withMenu('Apps');
    }

    public function availability() {
        if (!Auth::user()->slug) {
            $link = strtolower(explode(' ', Auth::user()->name)[0]);
            $i = 0;
            while (User::where('slug', $link)->first()) {
                if ($i++ == 0) $link .= date('y');
                else $link .= rand(0, 9);
            }
            return view('user.availability.availability', [
                'link' => $link,
            ])->withMenu('Availability');
        }
        return redirect()->route('events');
    }

    public function postAvailability(Request $request) {
        $rule = [
            'link' => ['required', 'unique:users,slug'],
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        try {
            $user = User::find(Auth::id());
            $user['slug'] = $request['link'];
            $user->save();
        } catch (\Exception $exception) {
            return back()->withInput()->with('error', 'The link has already been taken.');
        }
        return redirect()->route('events');
    }

    public function checkAvailability(Request $request) {
        if (!Auth::user()->slug) return redirect()->route('availability');
        $old = $link = $request['link'];
        $i = 0;
        while (User::where('slug', $link)->first()) {
            if ($i++ == 0) $link .= date('y');
            else $link .= rand(0, 9);
        }
        if ($i == 0) {
            return response([
                'available' => true,
                'suggestions' => view('user.partials.availability.suggestions').'',
            ]);
        }
        $suggestions = [$link];
        $link = $old;
        while (User::where('slug', $link)->first() || in_array($link, $suggestions)) {
            $link .= rand(0, 9);
        }
        $suggestions[] = $link;
        $link = $old;
        while (User::where('slug', $link)->first() || in_array($link, $suggestions)) {
            $link .= rand(0, 9);
        }
        $suggestions[] = $link;
        return response([
            'available' => false,
            'suggestions' => view('user.partials.availability.suggestions', ['suggestions' => $suggestions]).'',
        ]);
    }

    public function schedules() {
        if (!Auth::user()->slug) return redirect()->route('availability');
        $schedules = UserSchedule::where('user_id', Auth::id())->get();
        return view('user.availability.schedules.index', [
            'schedules' => $schedules,
        ])->withMenu('Schedules');
    }

    public function getSchedule($slug = null) {
        if (!Auth::user()->slug) return redirect()->route('availability');
        $schedule = UserSchedule::where('user_id', Auth::id())->where('slug', $slug)->first();
        if ($slug && empty($schedule)) return back()->with('error_message', 'Cannot find schedule info');
        return view('user.availability.schedules.add', [
            'schedule' => $schedule,
        ])->withMenu('Schedules');
    }

    public function postSchedule($slug = null, Request $request) {
        if (!Auth::user()->slug) return redirect()->route('availability');
        $rule = [
            'name' => ['required'],
            'mon' => ['nullable', 'array'],
            'mon_applies' => ['nullable', 'array'],
            'tue' => ['nullable', 'array'],
            'tue_applies' => ['nullable', 'array'],
            'wed' => ['nullable', 'array'],
            'wed_applies' => ['nullable', 'array'],
            'thu' => ['nullable', 'array'],
            'thu_applies' => ['nullable', 'array'],
            'fri' => ['nullable', 'array'],
            'fri_applies' => ['nullable', 'array'],
            'sat' => ['nullable', 'array'],
            'sat_applies' => ['nullable', 'array'],
            'sun' => ['nullable', 'array'],
            'status' => ['in:0,1'],
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $schedule = UserSchedule::where('user_id', Auth::id())->where('slug', $slug)->first();
        if ($slug && empty($schedule)) return back()->with('error_message', 'Cannot find schedule info');
        if (empty($schedule)) $schedule = new UserSchedule;
        $schedule['user_id'] = Auth::id();
        $schedule['name'] = $request['name'];
        if (empty($slug)) $schedule['slug'] = rand();
        $weeks = ['mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun'];
        foreach($weeks as $week) {
            foreach($weeks as $w) {
                if ($week == $w) break;
                if(empty($$week) && in_array($week, $request[$w.'_applies'] ?: [])) {
                    $$week = $schedule[$w];
                }
            }
            if (empty($$week)) {
                $$week = implode(',', $request[$week] ?: []);
            }
            $schedule[$week] = $$week;
        }
        $schedule['active'] = $request['status'];
        $schedule->save();
        if (empty($slug)) {
            $schedule['slug'] = md5($schedule['id']);
            $schedule->save();
        }
        return redirect()->route('schedules')->with('info_message', 'Successfully done');
    }

    public function deleteSchedule(Request $request) {
        $schedule = UserSchedule::where('user_id', Auth::id())->where('slug', $request['link'])->first();
        if (empty($schedule)) return back()->with('error_message', 'Cannot find schedule info');
        $schedule->delete();
        return back()->with('info_message', 'Schedule has been removed');
    }

    public function activeSchedule(Request $request) {
        if (!Auth::user()->slug) return response(['status' => 'failed']);
        $rule = [
            'slug' => ['required', 'exists:user_schedules'],
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return response([
                'status' => 'failed',
            ]);
        }
        $schedule = UserSchedule::where('user_id', Auth::id())->where('slug', $request['slug'])->first();
        if (empty($schedule)) return response(['status' => 'failed']);
        $schedule['active'] = ($schedule['active'] + 1) % 2;
        $schedule->save();
        return response([
            'status' => 'success',
            'active' => $schedule['active'],
        ]);
    }

    public function events() {
        if (!Auth::user()->slug) return redirect()->route('availability');
        $events = UserEvent::where('user_id', Auth::id())->get();
        $link = route('index').'/'.Auth::user()->slug;
        return view('user.availability.events.index', [
            'link' => $link,
            'events' => $events,
        ])->withMenu('Events');
    }

    public function getEvent($slug = null) {
        if (!Auth::user()->slug) return redirect()->route('availability');
        $event = UserEvent::where('user_id', Auth::id())->where('slug', $slug)->first();
        if ($slug && empty($event)) return back()->with('error_message', 'Cannot find event info');
        $schedules = UserSchedule::active()->where('user_id', Auth::id())->get();
        $current_event = UserEvent::active()->where('user_id', Auth::id())->count();
        return view('user.availability.events.add', [
            'event' => $event,
            'schedules' => $schedules,
            'current_event' => $current_event,
        ])->withMenu('Events');
    }

    public function postEvent($slug = null, Request $request) {
        if (!Auth::user()->slug) return redirect()->route('availability');
        $current_event = UserEvent::active()->where('user_id', Auth::id())->count();
        if (empty($slug) && $current_event >= Auth::user()->event) {
            return redirect()->route('membership');
        }
        $rule = [
            'name' => ['required'],
            'description' => ['required'],
            'date_range' => ['required', Rule::in(['days', 'daterange', 'indefinite'])],
            'days' => ['required_if:date_range,days', 'min:1'],
            'daterange' => ['required_if:date_range,daterange'],
            'time_slot' => ['required', 'in:schedule,custom'],
            'schedule' => ['required_if:time_slot,schedule'],
            'mon' => ['nullable', 'array'],
            'mon_applies' => ['nullable', 'array'],
            'tue' => ['nullable', 'array'],
            'tue_applies' => ['nullable', 'array'],
            'wed' => ['nullable', 'array'],
            'wed_applies' => ['nullable', 'array'],
            'thu' => ['nullable', 'array'],
            'thu_applies' => ['nullable', 'array'],
            'fri' => ['nullable', 'array'],
            'fri_applies' => ['nullable', 'array'],
            'sat' => ['nullable', 'array'],
            'sat_applies' => ['nullable', 'array'],
            'sun' => ['nullable', 'array'],
            'duration' => ['required', 'numeric', 'between:1,60'],
            'break_time' => ['required', 'numeric', 'between:0,60'],
            'status' => ['in:0,1'],
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $event = UserEvent::where('user_id', Auth::id())->where('slug', $slug)->first();
        if ($slug && empty($event)) return back()->with('error_message', 'Cannot find event info');
        if (empty($event)) $event = new UserEvent;
        $event['user_id'] = Auth::id();
        $event['name'] = $request['name'];
        if (empty($slug)) {
            $slug = strtolower(preg_replace("/[^A-Za-z0-9]/", '-', $request['name']));
            while(UserEvent::where('user_id', Auth::id())->where('slug', $slug)->first()) {
                $slug .= '-';
            }
            $event['slug'] = $slug;
        }
        $event['description'] = $request['description'];
        $date_range = $request['date_range'];
        if ($date_range == 'days') {
            $event['start_date'] = date('Y-m-d');
            $event['end_date'] = date('Y-m-d', strtotime('+'.$request['days'].'days'));
        } else if ($date_range == 'daterange') {
            $date = explode(' - ', $request['daterange']);
            $event['start_date'] = date('Y-m-d', strtotime($date[0]));
            $event['end_date'] = date('Y-m-d', strtotime($date[1]));
        } else {
            $event['start_date'] = null;
            $event['end_date'] = null;
        }
        if ($request['time_slot'] == 'schedule') {
            $event['schedule_id'] = $request['schedule'];
            $event['mon'] = $event['tue'] = $event['wed'] = $event['thu'] = null;
            $event['fri'] = $event['sat'] = $event['sun'] = null;
        } else {
            $event['schedule_id'] = null;
            $weeks = ['mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun'];
            foreach($weeks as $week) {
                foreach($weeks as $w) {
                    if ($week == $w) break;
                    if(empty($$week) && in_array($week, $request[$w.'_applies'] ?: [])) {
                        $$week = $event[$w];
                    }
                }
                if (empty($$week)) {
                    $$week = implode(',', $request[$week] ?: []);
                }
                $schedule[$week] = $$week;
            }
        }
        $event['duration'] = $request['duration'];
        $event['break_time'] = $request['break_time'];
        $event['timezone'] = empty($request['timezone']) ? getTimezone() : $request['timezone'];
        $event['active'] = $request['status'];
        $event->save();
        return redirect()->route('events')->with('info_message', 'Successfully done');
    }

    public function deleteEvent(Request $request) {
        $event = UserEvent::where('user_id', Auth::id())->where('slug', $request['link'])->first();
        if (empty($event)) return back()->with('error_message', 'Cannot find event info');
        $event->delete();
        return back()->with('info_message', 'Event has been removed');
    }

    public function activeEvent(Request $request) {
        if (!Auth::user()->slug) return response(['status' => 'failed']);
        $current_event = UserEvent::active()->where('user_id', Auth::id())->count();
        if ($current_event >= Auth::user()->event) response(['status' => 'failed']);
        $rule = [
            'slug' => ['required', 'exists:user_events'],
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return response([
                'status' => 'failed',
            ]);
        }
        $event = UserEvent::where('user_id', Auth::id())->where('slug', $request['slug'])->first();
        if (empty($event)) return response(['status' => 'failed']);
        $expired = 0;
        if (!empty($event['daterange'])) {
            $end_date = date('Y-m-d', strtotime(explode(' - ', $event['daterange'])[1]));
            if (date('Y-m-d') <= $end_date) {
                $event['active'] = ($event['active'] + 1) % 2;
            } else {
                $event['active'] = 0;
                $expired = 1;
            }
        } else {
            $event['active'] = ($event['active'] + 1) % 2;
        }
        $event->save();
        return response([
            'status' => 'success',
            'active' => $event['active'],
            'expired' => $expired,
            'event_link' => view('user.partials.availability.event-link', ['event' => $event]).'',
        ]);
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
