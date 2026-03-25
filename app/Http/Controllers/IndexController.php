<?php

namespace App\Http\Controllers;

use App\Mail\Template;
use App\Models\Admin;
use App\Models\Guest;
use App\Models\ScheduledEvent;
use App\Models\User;
use App\Models\UserEvent;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class IndexController extends Controller
{
    public function index() {
        return view('index');
    }

    public function home() {
        if (Auth::check()) {
            return redirect()->route('home');
        } else {
            return view('index', [
                'where' => 'extension',
            ]);
        }
    }

    public function privacy() {
        return view('privacy');
    }

    public function terms() {
        return view('terms');
    }

    public function how() {
        return view('how');
    }

    public function knowledgebase() {
        return view('knowledgebase.index');
    }

    public function gettingStarted() {
        return view('knowledgebase.getting-started');
    }

    public function connectingZoom() {
        return view('knowledgebase.connecting-zoom');
    }

    public function faq() {
        return view('knowledgebase.faq');
    }

    public function cookiesPolicy() {
        return view('knowledgebase.cookies-policy');
    }

    public function support() {
        return view('support');
    }

    public function postSupport(Request $request) {
        $rule = [
            'name' => ['required', 'string'],
            'email' => ['required', 'email'],
            'type' => ['required', 'in:General,Technical,Billing,Account Related'],
            'description' => ['required', 'string'],
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('error_message', 'Please fill all required fields');
        }
        try {
            $admin = Admin::find(1);
            $mail_body = view('mail.contact', [
                'data' => [
                    'name' => $request['name'],
                    'email' => $request['email'],
                    'type' => $request['type'],
                    'description' => $request['description'],
                ],
            ]).'';
            $data = [
                'subject' => '',
                'mail_body' => $mail_body,
            ];
            Mail::to($admin['email'])->send(new Template($data));

            return back()->with('info_message', 'Thanks for your contacting us. We will contact you shortly.');
        } catch (\Exception $exception) {
        }
        return back()->with('error_message', 'Some went wrong. please try again.');
    }

    public function scheduleEvent($name, $event, Request $request) {
        $host = User::where('slug', $name)->first();
        if (empty($host['schedule'])) return abort(404);
        $today = date('Y-m-d');
        $event = UserEvent::active()
            ->where('user_id', $host['id'])
            ->where('slug', $event)
            ->first();
        if (empty($event) || ($event['end_date'] && $event['end_date'] < $today)) {
            return abort(404);
        }
        $rule = [
            'date' => ['required'],
            'time' => ['required'],
            'timezone' => ['required'],
            'name' => ['required'],
            'email' => ['required', 'email'],
            'phone' => ['required'],
        ];
        $validator = Validator::make($request->all(), $rule, [
            'date.required' => 'Please select the date & time to schedule',
            'time.required' => 'Please select the date & time to schedule',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('error_message', 'Please fill all required fields');
        }
        try {
            $timezone = date_default_timezone_get();
            $scheduled_time = convertTimezone($request['timezone'], $timezone, $request['time'], $request['date']);
            $booking = ScheduledEvent::where('user_id', $host['id'])
                ->where('scheduled_time', date('Y-m-d H:i:00', strtotime($scheduled_time)))
                ->first();
            if (!empty($booking)) {
                return back()->with('error_message', 'Cannot use the time when you selected.');
            }

            $schedule_event = new ScheduledEvent;
            $schedule_event['user_id'] = $host['id'];
            $schedule_event['event_id'] = $event['id'];
            $schedule_event['invitee_name'] = $request['name'];
            $schedule_event['invitee_email'] = $request['email'];
            $schedule_event['invitee_phone'] = $request['phone'];
            $schedule_event['scheduled_time'] = date('Y-m-d H:i:00', strtotime($scheduled_time));
            $schedule_event['timezone'] = $request['timezone'];
            $schedule_event->save();

            Guest::updateOrCreate([
                'user_id' => $host['id'],
                'email' => $request['email'],
            ], [
                'name' => $request['name'],
            ]);

            $email = $request['email'];
            $scheduled_time = convertTimezone($request['timezone'], $event['timezone'], $request['time'], $request['date']);
            $scheduled_time = date('h:i A, l, F j, Y', strtotime($scheduled_time));
            $mail_body = view('mail.schedule', [
                'name' => $host['name'],
                'event' => $event,
                'data' => [
                    'name' => $request['name'],
                    'email' => $email,
                    'phone' => $request['phone'],
                    'date' => $scheduled_time,
                ],
            ]).'';
            $data = [
                'subject' => 'New schedule event on '.$scheduled_time,
                'mail_body' => $mail_body,
            ];
            Mail::to($host['email'])->send(new Template($data));

            $scheduled_time = $request['date'].' '.$request['time'];
            $scheduled_time = date('h:i A, l, F j, Y', strtotime($scheduled_time));
            $mail_body = view('mail.schedule', [
                'name' => $request['name'],
                'event' => $event,
                'data' => [
                    'date' => $scheduled_time,
                ],
            ]).'';
            $data = [
                'subject' => 'New schedule event on '.$scheduled_time,
                'mail_body' => $mail_body,
            ];
            Mail::to($email)->send(new Template($data));

            return back()->with('info_message', 'Successfully done.');
        } catch(\Exception $exception) {
            return back()->with('error_message', 'Some went wrong. please try again.');
        }
    }

    public function timeSlots(Request $request) {
        $rule = [
            'host' => ['required'],
            'event' => ['required'],
            'date' => ['required', 'date', 'date_format:Y-m-d'],
            'timezone' => ['required'],
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) return response(['status' => 'failed']);
        $host = User::where('slug', $request['host'])->first();
        if (empty($host['schedule'])) return response(['status' => 'failed']);
        $event = UserEvent::active()->where('user_id', $host['id'])->where('slug', $request['event'])->first();
        if (empty($event)) return response(['status' => 'failed']);
        $timezone = date_default_timezone_get();
        $visitor_timezone = $request['timezone'];
        $booking_date = $request['date'];
        $slots = [];
        $now = convertTimezone($timezone, $visitor_timezone, date('Y-m-d h:i A'));
        $start_time = convertTimezone($visitor_timezone, $event['timezone'], $booking_date);
        $end_time = convertTimezone($visitor_timezone, $event['timezone'], '11:59 PM', $booking_date);
        $start_time_weekday = strtolower(date('D', strtotime($start_time)));
        $end_time_weekday = strtolower(date('D', strtotime($end_time)));
        $w = $start_time_weekday; $date = explode(' ', $start_time)[0];
        for ($i = 0; $i < 2; $i++) {
            if ($event['schedule']) {
                $time_slots = $event['schedule'][$w];
            } else {
                $time_slots = $event[$w];
            }
            if (!empty($time_slots)) {
                $time_slots = explode(',', $time_slots);
                foreach ($time_slots as $time_slot) {
                    $time = $date . ' ' . $time_slot;
                    if (timecmp($time, $start_time) >= 0 && timecmp($time, $end_time) <= 0) {
                        $slots[] = $time;
                    }
                }
            }
            if ($w == $end_time_weekday) break;
            $w = $end_time_weekday; $date = explode(' ', $end_time)[0];
        }
        $interval = $event['duration'] + $event['break_time'];
        $time_slots = []; $cur_time = $cur_end_time = null;
        for ($i = 0; $i < count($slots); $i++) {
            $slot_end_time = date('Y-m-d h:i A', strtotime('+1 hours', strtotime($slots[$i])));
            $slot_end_time = convertTimezone($event['timezone'], $visitor_timezone, $slot_end_time);
            if (empty($cur_time)) {
                $cur_time = convertTimezone($event['timezone'], $visitor_timezone, $slots[$i]);
                $cur_end_time = date('Y-m-d h:i A', strtotime("+$event[duration] minutes", strtotime($cur_time)));
            }
            while (timecmp($slot_end_time, $cur_end_time) >= 0) {
                $cur_server_time = convertTimezone($visitor_timezone, $timezone, $cur_time);
                if (strtotime($cur_time) > strtotime($now)) {
                    $booking = ScheduledEvent::where('user_id', $host['id'])
                        ->where('scheduled_time', date('Y-m-d H:i:00', strtotime($cur_server_time)))
                        ->first();
                    if (empty($booking)) {
                        $time_slots[] = [
                            date('h:i A', strtotime($cur_time)),
                            date('h:i A', strtotime($cur_end_time))
                        ];
                    }
                }
                $cur_time = date('Y-m-d h:i A', strtotime("+$interval minutes", strtotime($cur_time)));
                $cur_end_time = date('Y-m-d h:i A', strtotime("+$event[duration] minutes", strtotime($cur_time)));
            }
            if ($i + 1 < count($slots)) {
                if ($slot_end_time != convertTimezone($event['timezone'], $visitor_timezone, $slots[$i + 1])) {
                    $cur_time = $cur_end_time = null;
                }
            }
        }
        return response([
            'status' => 'success',
            'time_slots' => view('schedule.time-slots', ['time_slots' => $time_slots, 'booking_date' => $booking_date]).'',
        ]);
    }

    public function userEvents($name) {
        $host = User::where('slug', $name)->first();
        if (empty($host['schedule'])) return abort(404);
        $events = UserEvent::active()
            ->where('user_id', $host['id'])
            ->where('end_date', '>=', date('Y-m-d'))
            ->get();
        return view('schedule.user-events', [
            'user' => $host,
            'events' => $events
        ]);
    }

    public function eventCalendar($name, $event) {
        $host = User::where('slug', $name)->first();
        if (empty($host['schedule'])) return abort(404);
        $event = UserEvent::active()
            ->where('user_id', $host['id'])
            ->where('slug', $event)
            ->first();
        $timezone = date_default_timezone_get();
        $host_today = convertTimezone($timezone, $event['timezone'], date('Y-m-d H:i:s'));
        $host_today = date('Y-m-d', strtotime($host_today));
        if (empty($event) || ($event['end_date'] && $event['end_date'] < $host_today)) {
            return abort(404);
        }
        $week = $event;
        if (!empty($event['schedule'])) {
            $week = $event['schedule'];
        }
        $visitor_timezone = getTimezone();
        $weeks = [0, 1, 2, 3, 4, 5, 6];
        for ($day = new Carbon($event['start_date']), $i = 0; $day->lt($event['end_date']) && $i < 7; $day->addDay(), $i++) {
            $date = $day->format('Y-m-d');
            $slots = $week[strtolower($day->shortEnglishDayOfWeek)];
            if (empty($slots)) continue;
            $slots = explode(',', $slots);
            foreach ($slots as $slot) {
                $d = convertTimezone($event['timezone'], $visitor_timezone, $slot, $date);
                unset($weeks[date('w', strtotime($d))]);
            }
        }
        if (count($weeks) == 7) return abort(404);

        $today = convertTimezone($event['timezone'], $visitor_timezone, $host_today);
        $today = explode(' ', $today)[0];
        $minDate = $today;
        if (!empty($event['start_date'])) {
            $w = strtolower(date('D', strtotime($event['start_date'])));
            if (empty($week[$w])) $time = ''; else $time = explode(',', $week[$w])[0];
            $event['start_date'] = convertTimezone($event['timezone'], $visitor_timezone, $time, $event['start_date']);
            $event['start_date'] = explode(' ', $event['start_date'])[0];
            if ($event['start_date'] > $today) $minDate = $event['start_date'];
        }
        $maxDate = null;
        if (!empty($event['end_date'])) {
            $w = strtolower(date('D', strtotime($event['end_date'])));
            if (empty($week[$w])) $time = ''; else $time = explode(',', $week[$w])[0];
            $maxDate = convertTimezone($event['timezone'], $visitor_timezone, $time, $event['end_date']);
            $maxDate = explode(' ', $maxDate)[0];
        }

        return view('schedule.event-calendar', [
            'event' => $event,
            'weeks' => $weeks,
            'minDate' => $minDate,
            'maxDate' => $maxDate,
        ]);
    }
}
