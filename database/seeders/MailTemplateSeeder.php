<?php

namespace Database\Seeders;

use App\Models\MailTemplate;
use Illuminate\Database\Seeder;

class MailTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = now();

        MailTemplate::insert([
            'category' => 'signup',
            'subject' => 'Welcome to Pigeon {Name}',
            'body' => '<p dir="ltr"><strong>Hey {Name},</strong></p>

<p dir="ltr">&nbsp;</p>

<p dir="ltr"><strong>I&rsquo;m Ranvijay, the founder of Pigeon and I&rsquo;d like to personally thank you for signing up to our service.</strong></p>

<p dir="ltr"><strong>We established Pigeon in order to allow professionals like you to do more before &amp; after online meetings. Booking a meeting from your side or to allow audiences to book session slots from your published calendar, Pigeon is always standing by your side.</strong></p>

<p dir="ltr"><strong>I&rsquo;d love to hear what you think of Pigeon and if there is anything we can improve. If you have any questions, please reply to this email. I&rsquo;m always happy to help!</strong></p>

<p>&nbsp;</p>

<p dir="ltr"><strong>Thanks</strong></p>

<p><strong><img src="https://lh3.googleusercontent.com/XPj-qlh3EewMxjglCvX4ge6zuPhnf77hnw-4Myi3HDUNJ4aCqSuE7NSOtRZl91SFD1U48NeqERndx4WPtrawHGOkoGb8WPiqtIkT3emSSKqFyeOqdcdaltVU3cKe5WyRJJMsoaHo" /><br />
Ranvijay Singh<br />
<img src="https://lh5.googleusercontent.com/EvzFPB3sF-Nv_gAyWZnIPjWiOvIS-PLoTHkVwqpEMnZq3Yn3eS6aO2qB5u3WdO7iSdXWNcRN3CzIV-YnZ-Fbk5QvzDZwj2OmxirFBHj5COFmm_eRWeqPaJ4Ia2VIVp0hFbsIHCls" /></strong></p>',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        MailTemplate::insert([
            'category' => 'no-meeting',
            'subject' => 'Struggling to book a meeting?',
            'body' => '<p dir="ltr"><strong>Hi {Name},</strong></p>

<p dir="ltr"><strong>Hope you are doing well.&nbsp;</strong></p>

<p dir="ltr"><strong>Thanks for signing up with me, I am happy to have you onboard.&nbsp; But, it looks like you didn&#39;t try booking a video meeting using Pigeon Chrome Extension yet.</strong></p>

<p dir="ltr"><strong>Do you have <a href="https://chrome.google.com/webstore/detail/pigeon/adlljmlbangmeenndganepfkilcdihnm">Pigeon Chrome Extension</a> Installed in your browser?</strong></p>

<p dir="ltr"><strong>I will be happy to help you in booking a meeting, in case you are facing any problems.</strong></p>

<p dir="ltr"><strong>Please let me know.</strong><br />
&nbsp;</p>

<p dir="ltr"><strong>Your true productivity partner!</strong></p>

<p dir="ltr"><strong><img src="https://lh6.googleusercontent.com/Ld3hQW4dYm7KK_awT7WoULHqSrJvNEcl4QnNdm8jWlImVXfknd5uP_n9j32SqwBCbuQzFR8Rtu4496vetD9tQblD0TJlKpqlP4d7Uav4VS83psnGsbK2PqwvIoNic8cuWUbPT5-h" /><br />
Pigeon</strong></p>',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        MailTemplate::insert([
            'category' => 'rate-review',
            'subject' => 'May I ask you for a favor?',
            'body' => '<p dir="ltr"><strong>Hi {Name},</strong></p>

<p dir="ltr">&nbsp;</p>

<p dir="ltr"><strong>It is good to see Pigeon is working fine and helping you in scheduling your meetings and sessions with much love &amp; efficiency.<br />
Here, I wanted to make a request. If you could rate &amp; review us on <a href="https://chrome.google.com/webstore/detail/pigeon/adlljmlbangmeenndganepfkilcdihnm">Chrome Web Store</a>.<br />
It will really be helpful and will motivate us to improve and keep doing the good job for you.</strong><br />
&nbsp;</p>

<p dir="ltr"><strong>Your true productivity partner!</strong></p>

<p dir="ltr"><strong><img src="https://lh6.googleusercontent.com/Ld3hQW4dYm7KK_awT7WoULHqSrJvNEcl4QnNdm8jWlImVXfknd5uP_n9j32SqwBCbuQzFR8Rtu4496vetD9tQblD0TJlKpqlP4d7Uav4VS83psnGsbK2PqwvIoNic8cuWUbPT5-h" /><br />
Pigeon</strong></p>',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        MailTemplate::insert([
            'category' => 'complete-meeting',
            'subject' => '',
            'body' => '',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        MailTemplate::insert([
            'category' => 'guests-notify',
            'subject' => 'I wish your last meeting was successful?',
            'body' => '<p dir="ltr"><strong>Hi {Name},</strong></p>

<p dir="ltr">&nbsp;</p>

<p dir="ltr"><strong>I&rsquo;m Pigeon and I really wish your last meeting with {Email} was successful.<br />
I am a productivity tool that helps businesses &amp; professionals like you to schedule meetings in an efficient and quick way (say 15 seconds or less).<br />
You can use me for both the scopes i.e outbound outreach or publishing your calendar to allow audiences book your time slots.<br />
<br />
1. For outbound outreach you can use me as an extension (Available on <a href="https://chrome.google.com/webstore/detail/pigeon/adlljmlbangmeenndganepfkilcdihnm">Chrome Web Store</a> for Free)<br />
2. For inbound slots booking you can publish your calendar publicly.<br />
<br />
The best part is you can see all your meetings, guests at one place. So no more back &amp; forth from platform to platform to organise your prospects data.<br />
<a href="https://joinpigeon.com">Sign up for free today!</a><br />
In case you have any questions, feel free to reply to this email. I will be happy to answer your queries.<br />
<br />
Thanks!</strong><br />
&nbsp;</p>

<p dir="ltr"><strong>Your true productivity partner!</strong></p>

<p dir="ltr"><strong><img src="https://lh6.googleusercontent.com/Ld3hQW4dYm7KK_awT7WoULHqSrJvNEcl4QnNdm8jWlImVXfknd5uP_n9j32SqwBCbuQzFR8Rtu4496vetD9tQblD0TJlKpqlP4d7Uav4VS83psnGsbK2PqwvIoNic8cuWUbPT5-h" /><br />
Pigeon</strong></p>',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        MailTemplate::insert([
            'category' => 'forgot-password',
            'subject' => '',
            'body' => '',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        MailTemplate::insert([
            'category' => 'reset-notify',
            'subject' => '',
            'body' => '',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }
}
