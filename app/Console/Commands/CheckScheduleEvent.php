<?php

namespace App\Console\Commands;

use App\Mail\Template;
use App\Models\ScheduledEvent;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class CheckScheduleEvent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:schedule-event';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This is the command to send a notification for event before 30 min.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $from = date('Y-m-d H:i:00', strtotime('+25 minutes'));
        $to = date('Y-m-d H:i:00', strtotime('+30 minutes'));
        $timezone = date_default_timezone_get();
        $events = ScheduledEvent::whereBetween('scheduled_time', [$from, $to])->where('before_thirty', 0)->get();
        foreach ($events as $event) {
            try {
                $email = $event['invitee_email'];
                $date = convertTimezone($timezone, $event['timezone'], $event['scheduled_time']);
                $date = date('h:i A, l, F j, Y', strtotime($date));
                $mail_body = view('mail.schedule', [
                        'name' => $event['user']['name'],
                        'event' => $event['event'],
                        'data' => [
                            'name' => $event['invitee_name'],
                            'email' => $email,
                            'phone' => $event['invitee_phone'],
                            'date' => $date,
                        ],
                    ]).'';
                $data = [
                    'subject' => 'Schedule event is coming on '.$date,
                    'mail_body' => $mail_body,
                ];
                Mail::to($event['user']['email'])->send(new Template($data));

                $date = convertTimezone($timezone, $event['event']['timezone'], $event['scheduled_time']);
                $date = date('h:i A, l, F j, Y', strtotime($date));
                $mail_body = view('mail.schedule', [
                        'name' => $event['invitee_name'],
                        'event' => $event['event'],
                        'data' => [
                            'date' => $date,
                        ],
                    ]).'';
                $data = [
                    'subject' => 'Schedule event is coming on '.$date,
                    'mail_body' => $mail_body,
                ];
                Mail::to($email)->send(new Template($data));
            } catch (\Exception $exception) {
            }
            $event['before_thirty'] = 1;
            $event->save();
        }
        return 0;
    }
}
