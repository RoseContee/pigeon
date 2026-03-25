<?php

namespace App\Console\Commands;

use App\Mail\Template;
use App\Models\MailTemplate;
use App\Models\Meeting;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class CheckCompleteMeeting extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:complete-meeting';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This is the command to send a notification to send to host and guests after complete meeting';

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
        $now = date('Y-m-d H:i:00');
        $meetings = Meeting::where('server_time', '<=', $now)->where('completed', 0)->get();
        foreach ($meetings as $meeting) {
            try {
                $mail = MailTemplate::ofCategory('complete-meeting')->first();
                $subject = str_replace('{Name}', $meeting['host_name'], $mail['subject']);
                $mail_body = str_replace('{Name}', $meeting['host_name'], $mail['body']);
                $mail_body = str_replace('{Email}', $meeting['guests'], $mail_body);
                $data = [
                    'subject' => $subject,
                    'mail_body' => $mail_body,
                ];
                Mail::to($meeting['host_name'])->send(new Template($data));
            } catch (\Exception $exception) {
            }
            $guests = explode(',', $meeting['guests']);
            foreach ($guests as $guest) {
                try {
                    $mail = MailTemplate::ofCategory('guests-notify')->first();
                    $subject = str_replace('{Name}', $guest, $mail['subject']);
                    $mail_body = str_replace('{Name}', $guest, $mail['body']);
                    $mail_body = str_replace('{Email}', $meeting['host_name'], $mail_body);
                    $data = [
                        'subject' => $subject,
                        'mail_body' => $mail_body,
                    ];
                    Mail::to($guest)->send(new Template($data));
                } catch (\Exception $exception) {
                }
            }
            $meeting['completed'] = 1;
            $meeting->save();
        }
        return 0;
    }
}
