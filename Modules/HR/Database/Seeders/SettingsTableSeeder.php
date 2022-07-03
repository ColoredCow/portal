<?php

namespace Modules\HR\Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {
        Setting::updateOrCreate([
            'module' => 'hr',
            'setting_key' => 'applicant_create_autoresponder_subject',
            'setting_value' => 'ColoredCow congratulates you!',
        ]);
        Setting::updateOrCreate([
            'module' => 'hr',
            'setting_key' => 'applicant_create_autoresponder_body',
            'setting_value' => '<div>Hello,<br /><br /></div><div>ColoredCow congratulates you on taking the first step to explore the opportunities of building great things!<br /><br /></div><div><p class="p1" style="box-sizing: border-box; margin-top: 0px; margin-bottom: 1rem; color: #212529; font-family: Raleway, sans-serif; font-size: 14.4px; white-space: pre-wrap;">We are glad to share that at ColoredCow, we are in an interesting phase of growth and offer a chance for hands-on learning and an opportunity to take your career in the direction of your dreams. </p><p class="p1" style="box-sizing: border-box; margin-top: 0px; margin-bottom: 1rem; color: #212529; font-family: Raleway, sans-serif; font-size: 14.4px; white-space: pre-wrap;"><span style="color: #000000; font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 14px;">We are reviewing your application and will get back to you soon.<br /><br /></span>Meanwhile, in case you have questions, now or later, feel free to email us. We\'ll be happy to answer those for you. </p><p class="p1" style="box-sizing: border-box; margin-top: 0px; margin-bottom: 1rem; color: #212529; font-family: Raleway, sans-serif; font-size: 14.4px; white-space: pre-wrap;">Looking forward to chatting soon.</p><p class="p1" style="box-sizing: border-box; margin-top: 0px; margin-bottom: 1rem; color: #212529; font-family: Raleway, sans-serif; font-size: 14.4px; white-space: pre-wrap;">Our FB page is the best place to get most of the update about happening at ColoredCow, be it our work or opportunities to work together. Check that out to know more <a style="box-sizing: border-box; color: #007bff; text-decoration-line: none; background-color: transparent;" href="https://www.facebook.com/ColoredCowConsulting/">https://www.facebook.com/ColoredCowConsulting/</a></p>HR Team<br />ColoredCow</div>',
        ]);
        Setting::updateOrCreate([
            'module' => 'hr',
            'setting_key' => 'round_not_conducted_mail_subject',
            'setting_value' => 'We really missed you!',
        ]);
        Setting::updateOrCreate([
            'module' => 'hr',
            'setting_key' => 'round_not_conducted_mail_body',
            'setting_value' => '<p class="p1">Hi <em>Name</em>,</p><p class="p1">We couldn\'t talk on <em>Date, Time</em>. We are sure there must be a reason why you couldn\'t be present that day. We missed you though!</p><p class="p1">The good news is that we are still interested in talking with you. Let us know if you want to reschedule the interview. </p><p class="p1">We suggest that you pick any time between 10:00 AM till 2:00 PM on any coming Friday (That\'s the day we designated for interviews). And let us know that time via email.</p><p class="p1">As we said earlier we are in an interesting phase of growth and offer the chance for hands-on learning and an opportunity to take your career in the direction of your dreams.<br /><br />In case you want to be in touch, our FB page is the best place to get most of the update about happening at ColoredCow, be it our work or opportunities to work together.<br /><br />https://www.facebook.com/ColoredCowConsulting/<br /><br />We wish you very best for your future.<br /><br />Thanks<br />HR Team,<br />ColoredCow</p>',
        ]);
        Setting::updateOrCreate([
            'module' => 'hr',
            'setting_key' => 'no_show_mail_subject',
            'setting_value' => 'You were missed!',
        ]);
        Setting::updateOrCreate([
            'module' => 'hr',
            'setting_key' => 'no_show_mail_body',
            'setting_value' => '<div>Hi |*applicant_name*|,</div><div> </div><div>We couldn\'t talk today at |*interview_time*|. We are sure there must be a reason why you couldn\'t be present. You were missed though!</div><div> </div><div>As we said earlier ColoredCow is in an interesting phase of growth and offer the chance for hands-on learning and an opportunity to take your career in the direction of your dreams. If you are still interested in exploring the opportunities with us, let us know via email.</div><div> </div><div>We are sure you are going to do great and would love to be in touch. Visit our FB page to know all the happening, be it work, opportunities, or anything else. Here is the link for your convenience</div><div><a href="https://www.facebook.com/ColoredCowConsulting/">https://www.facebook.com/ColoredCowConsulting/</a></div><div> </div><div>We wish you very best for your future.</div><div> </div><div>Thanks</div><div>HR Team,</div><div>ColoredCow</div>',
        ]);
        Setting::updateOrCreate([
            'module' => 'hr',
            'setting_key' => 'applicant_interview_reminder_subject',
            'setting_value' => 'Your interview is scheduled today with ColoredCow',
        ]);
        Setting::updateOrCreate([
            'module' => 'hr',
            'setting_key' => 'applicant_interview_reminder_body',
            'setting_value' => '<div>Hello |*applicant_name*|,</div><div> </div><div>We thought to nudge you about our talk today at |*interview_time*|.</div><div> </div><div>Also, if you haven\'t accepted the Google calendar invite, which we\'ve sent you earlier, please do so now. That will help. Ignore if you\'ve already done so.</div><div> </div><div>Talk to you soon!</div><div> </div><div>HR Team</div><div>ColoredCow</div>',
        ]);
        Setting::updateOrCreate([
            'module' => 'hr',
            'setting_key' => 'application_on_hold_subject',
            'setting_value' => 'Your application is put on hold',
        ]);
        Setting::updateOrCreate([
            'module' => 'hr',
            'setting_key' => 'application_on_hold_body',
            'setting_value' => '<div>Dear |*applicant_name*|,</div><div> </div><div>Thanks for applying to ColoredCow for the position |*job_title*|.We don\'t have a relevant opening for the position right now. Your application is kept under waiting and we will reach out to you if there are any possibilities we can explore together. </div><div>Thanks,</div><div> </div><div>HR Team,</div><div>ColoredCow</div> ',
        ]);
        Setting::updateOrCreate([
            'module' => 'hr',
            'setting_key' => 'applicant_verification_body',
            'setting_value' => '<div>Hello |*applicant_name*|,<br /><br /></div><p class="p1" style="box-sizing: border-box; margin-top: 0px; margin-bottom: 1rem; color: #212529; font-family: Raleway, sans-serif; font-size: 14.4px; white-space: pre-wrap;">For verify the application, click on the below link <a style="box-sizing: border-box; color: #007bff; text-decoration-line: none; background-color: transparent;" href="|*verification_link*|">Verification link/</a></p>HR Team<br />ColoredCow</div>',
        ]);
    }
}
