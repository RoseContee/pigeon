<?php

namespace App\Console\Commands;

use App\Mail\Template;
use App\Models\MailTemplate;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class CheckNoMeeting extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:no-meeting';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This is the command to send a notification to users who did not book any meeting after join';

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
        $date = date('Y-m-d H:i:s', strtotime('-2 days'));
        $users = User::join('meetings', 'users.id', '=', 'meetings.user_id')
            ->where('users.created_at', '>=', $date)
            ->where('users.two_days', 0)
            ->get(['users.*']);
        foreach ($users as $user) {
            try {
                $mail = MailTemplate::ofCategory('no-meeting')->first();
                $subject = str_replace('{Name}', $user['name'], $mail['subject']);
                $mail_body = str_replace('{Name}', $user['name'], $mail['body']);
                $data = [
                    'subject' => $subject,
                    'mail_body' => $mail_body,
                ];
                Mail::to($user['email'])->send(new Template($data));
            } catch (\Exception $exception) {
            }
            $user['two_days'] = 1;
            $user->save();
        }
        return 0;
    }
}
