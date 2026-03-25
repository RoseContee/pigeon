<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\App;
use App\Models\Guest;
use App\Models\Meeting;
use App\Models\Membership;
use App\Models\MembershipPackage;
use App\Models\Platform;
use App\Models\Setting;
use App\Models\User;
use App\Models\Word;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Validation\Rule;

class HomeController extends Controller
{
    public function dashboard() {
        $package_number = Membership::count();
        $platform_number = Platform::count();
        $app_number = App::count();
        $user_number = User::count();
        $first_day = Carbon::now()->weekday(0)->subDays(7)->setTime(0, 0, 0).'';
        $end_day = Carbon::now()->weekday(6)->subDays(7)->setTime(0, 0, 0).'';
        $last_week_users = User::whereBetween('created_at', [$first_day, $end_day])
            ->get();
        $last_data = [];
        for ($day = new Carbon($first_day); $day <= $end_day; $day->addDay()) {
            $last_data[$day->format('jS')] = 0;
            foreach ($last_week_users as $user) {
                if ($day->format('Y-m-d') == date('Y-m-d', strtotime($user['created_at']))) {
                    $last_data[$day->format('jS')]++;
                }
            }
        }
        $first_day = Carbon::now()->weekday(0)->setTime(0, 0, 0).'';
        $end_day = Carbon::now()->nextWeekendDay()->setTime(0, 0, 0).'';
        $this_week_users = User::whereBetween('created_at', [$first_day, $end_day])
            ->get();
        $days = [];
        $this_data = [];
        for ($day = new Carbon($first_day); $day <= $end_day; $day->addDay()) {
            $days[] = $day->format('jS');
            $this_data[$day->format('jS')] = 0;
            foreach ($this_week_users as $user) {
                if ($day->format('Y-m-d') == date('Y-m-d', strtotime($user['created_at']))) {
                    $this_data[$day->format('jS')]++;
                }
            }
        }
        $last_week_user = count($last_week_users); $this_week_user = count($this_week_users);
        $user_percent = empty($last_week_user) || empty($this_week_user) ? $this_week_user * 100 : (round($this_week_user / $last_week_user, 4) * 100 - 100);

        return view('admin.dashboard', [
            'menu' => 'Dashboard',
            'package_number' => $package_number,
            'platform_number' => $platform_number,
            'app_number' => $app_number,
            'user_number' => $user_number,
            'this_week_user' => $this_week_user,
            'user_percent' => $user_percent,
            'days' => $days,
            'this_data' => $this_data,
            'last_data' => $last_data,
        ]);
    }

    public function platforms() {
        $platforms = Platform::get();
        return view('admin.platforms.index', [
            'menu' => 'Platforms',
            'platforms' => $platforms,
        ]);
    }

    public function activePlatform(Request $request) {
        $platform = Platform::find($request['platform_id']);
        if (empty($platform)) {
            return response([
                'result' => 'failed',
            ]);
        }
        $active = ($platform['active'] + 1) % 2;
        $platform['active'] = $active;
        $platform->save();
        return response([
            'result' => 'success',
            'active' => $active,
        ]);
    }

    public function deletePlatform(Request $request) {
        if (($platform_id = $request['platform_id']) < 2) {
            return back()->with('error_message', 'Cannot find platform data');
        }
        $platform = Platform::find($platform_id);
        if (empty($platform)) {
            return back()->with('error_message', 'Cannot find platform data');
        }
        $platform->delete();
        return back()->with('info_message', 'Successfully removed');
    }

    public function editPlatform($platform_id = 0) {
        $platform = Platform::find($platform_id);
        if (empty($platform) && $platform_id > 0) {
            return back()->with('error_message', 'Cannot find platform data');
        }
        return view('admin.platforms.add', [
            'menu' => 'Platforms',
            'platform' => $platform,
        ]);
    }

    public function postEditPlatform($platform_id = 0, Request $request) {
        $platform = Platform::find($platform_id);
        if (empty($platform) && $platform_id > 0) {
            return back()->with('error_message', 'Cannot find platform data');
        }
        $rule = [
            'name' => ['required'],
            'url' => ['required', 'url'],
        ];
        if (empty($platform)) {
            $rule['name'] = ['required', 'unique:platforms,name'];
        } else {
            $rule['name'] = ['required', 'unique:platforms,name,'.$platform['id']];
        }
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('error_message', 'Make sure validation rules');
        }
        if (empty($platform)) $platform = new Platform();
        if ($platform_id != 1) {
            $platform['name'] = $request['name'];
            $platform['url'] = $request['url'];
        }
        $platform['active'] = $request['active'];
        $platform->save();
        return redirect()->route('admin.platforms')->with('info_message', 'Successfully done');
    }

    public function apps() {
        $apps = App::get();
        return view('admin.apps.index', [
            'menu' => 'Apps',
            'apps' => $apps,
        ]);
    }

    public function activeApp(Request $request) {
        $app = App::find($request['app_id']);
        if (empty($app)) {
            return response([
                'result' => 'failed',
            ]);
        }
        $active = ($app['active'] + 1) % 2;
        $app['active'] = $active;
        $app->save();
        return response([
            'result' => 'success',
            'active' => $active,
        ]);
    }

    public function deleteApp(Request $request) {
        if (($app_id = $request['app_id']) < 3) {
            return back()->with('error_message', 'Cannot find app data');
        }
        $app = App::find($app_id);
        if (empty($app)) {
            return back()->with('error_message', 'Cannot find app data');
        }
        $app->delete();
        return back()->with('info_message', 'Successfully removed');
    }

    public function editApp($app_id = 0) {
        $app = App::find($app_id);
        if (empty($app) && $app_id > 0) {
            return back()->with('error_message', 'Cannot find app data');
        }
        return view('admin.apps.add', [
            'menu' => 'Apps',
            'app' => $app,
        ]);
    }

    public function postEditApp($app_id = 0, Request $request) {
        $app = App::find($app_id);
        if (empty($app) && $app_id > 0) {
            return back()->with('error_message', 'Cannot find app data');
        }
        if (empty($app)) {
            $rule['name'] = ['required', 'unique:apps,name'];
        } else {
            $rule['name'] = ['required', 'unique:apps,name,'.$app['id']];
        }
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('error_message', 'Make sure validation rules');
        }
        if (empty($app)) $app = new App();
        if ($app_id == 0 || $app_id > 2) $app['name'] = $request['name'];
        $app['active'] = $request['active'];
        $app->save();
        return redirect()->route('admin.apps')->with('info_message', 'Successfully done');
    }

    public function words() {
        $words = Word::get();
        return view('admin.words.index', [
            'menu' => 'Words',
            'words' => $words,
        ]);
    }

    public function deleteWord(Request $request) {
        $word = Word::find($request['word_id']);
        if (empty($word)) {
            return back()->with('error_message', 'Cannot find word data');
        }
        $word->delete();
        return back()->with('info_message', 'Successfully removed');
    }

    public function editWord($word_id = 0) {
        $word = Word::find($word_id);
        if (empty($word) && $word_id > 0) {
            return back()->with('error_message', 'Cannot find word data');
        }
        return view('admin.words.add', [
            'menu' => 'Words',
            'word' => $word,
        ]);
    }

    public function postEditWord($word_id = 0, Request $request) {
        $word = Word::find($word_id);
        if (empty($word) && $word_id > 0) {
            return back()->with('error_message', 'Cannot find word data');
        }
        if (empty($word)) {
            $rule['word'] = ['required', 'unique:words,word'];
        } else {
            $rule['word'] = ['required', 'unique:words,word,'.$word['id']];
        }
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('error_message', 'Make sure validation rules');
        }
        if (empty($word)) $word = new Word();
        $word['word'] = $request['word'];
        $word->save();
        return redirect()->route('admin.words')->with('info_message', 'Successfully done');
    }

    public function packages() {
        $packages = MembershipPackage::get();
        return view('admin.packages.index', [
            'menu' => 'Packages',
            'packages' => $packages,
        ]);
    }

    public function activePackage(Request $request) {
        $package = MembershipPackage::find($request['package_id']);
        if (empty($package)) {
            return response([
                'result' => 'failed',
            ]);
        }
        $active = ($package['active'] + 1) % 2;
        $package['active'] = $active;
        $package->save();
        Membership::where('membership_package_id', $package['id'])->update([
            'active' => $active,
        ]);
        return response([
            'result' => 'success',
            'active' => $active,
        ]);
    }

    public function deletePackage(Request $request) {
        $package = MembershipPackage::find($request['package_id']);
        if (empty($package)) {
            return back()->with('error_message', 'Cannot find package data');
        }
        $package->delete();
        Membership::where('membership_package_id', $package['id'])->delete();
        return back()->with('info_message', 'Successfully removed');
    }

    public function editPackage($package_id = 0) {
        $package = MembershipPackage::find($package_id);
        if (empty($package) && $package_id > 0) {
            return back()->with('error_message', 'Cannot find package data');
        }
        return view('admin.packages.add', [
            'menu' => 'Packages',
            'package' => $package,
        ]);
    }

    public function postEditPackage($package_id = 0, Request $request) {
        $package = MembershipPackage::find($package_id);
        if (empty($package) && $package_id > 0) {
            return back()->with('error_message', 'Cannot find package data');
        }
        $rule = [
            'name' => ['required'],
            'period' => ['required', 'numeric', 'gte:1'],
            'unit' => ['required', Rule::in(['month', 'year'])],
            'discount' => ['required', 'numeric', 'gte:0']
        ];
        if (empty($package)) {
            $rule['name'] = ['required', 'unique:membership_packages,name'];
        } else {
            $rule['name'] = ['required', 'unique:membership_packages,name,'.$package['id']];
        }
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('error_message', 'Make sure validation rules');
        }
        if (empty($package)) $package = new MembershipPackage();
        $package['name'] = $request['name'];
        $package['period'] = $request['period'];
        $package['unit'] = $request['unit'];
        $package['discount'] = $request['discount'];
        $package->save();
        return redirect()->route('admin.packages')->with('info_message', 'Successfully done');
    }

    public function memberships() {
        $memberships = Membership::orderBy('membership_package_id')->orderBy('name')->get();
        return view('admin.memberships.index', [
            'menu' => 'Memberships',
            'memberships' => $memberships,
        ]);
    }

    public function activeMembership(Request $request) {
        $membership = Membership::find($request['membership_id']);
        if (empty($membership)) {
            return response([
                'result' => 'failed',
            ]);
        }
        $active = ($membership['active'] + 1) % 2;
        $membership['active'] = $active;
        $membership->save();
        return response([
            'result' => 'success',
            'active' => $active,
        ]);
    }

    public function deleteMembership(Request $request) {
        $membership = Membership::find($request['membership_id']);
        if (empty($membership)) {
            return back()->with('error_message', 'Cannot find membership data');
        }
        $membership->delete();
        return back()->with('info_message', 'Successfully removed');
    }

    public function editMembership($membership_id = 0) {
        if (MembershipPackage::count() == 0) {
            return redirect()->route('admin.add-package')->with('error_message', 'Please add package first before create membership');
        }
        $membership = Membership::find($membership_id);
        if (empty($membership) && $membership_id > 0) {
            return back()->with('error_message', 'Cannot find membership data');
        }
        $packages = MembershipPackage::active()->get();
        return view('admin.memberships.add', [
            'menu' => 'Memberships',
            'membership' => $membership,
            'packages' => $packages,
        ]);
    }

    public function postEditMembership($membership_id = 0, Request $request) {
        $membership = Membership::find($membership_id);
        if (empty($membership) && $membership_id > 0) {
            return back()->with('error_message', 'Cannot find membership data');
        }
        $rule = [
            'package' => ['required', 'exists:membership_packages,id'],
            'name' => ['required'],
            'price' => ['required', 'numeric', 'gte:0'],
            'limitation' => ['required', 'numeric', 'gt:0'],
            //'description' => ['required'],
        ];
        if (empty($membership)) {
            $rule['name'] = ['required', 'unique:memberships,name'];
        } else {
            $rule['name'] = ['required', 'unique:memberships,name,'.$membership['id']];
        }
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('error_message', 'Make sure validation rules');
        }
        if (empty($membership)) $membership = new Membership();
        $membership['membership_package_id'] = $request['package'];
        $membership['name'] = $request['name'];
        $membership['price'] = $request['price'];
        $membership['limitation'] = $request['limitation'];
        $membership['description'] = $request['description'];
        $membership['active'] = $request['active'];
        $membership->save();
        return redirect()->route('admin.memberships')->with('info_message', 'Successfully done');
    }

    public function users() {
        $users = User::get();
        return view('admin.users.index', [
            'menu' => 'Users',
            'users' => $users,
        ]);
    }

    public function userLimitation(Request $request) {
        $user = User::find($request['user_id']);
        if (empty($user)) {
            return response([
                'result' => 'failed',
            ]);
        }
        $user['limitation'] = $request['limitation'];
        $user->save();
        return response([
            'result' => 'success',
        ]);
    }

    public function activeUser(Request $request) {
        $user = User::find($request['user_id']);
        if (empty($user)) {
            return response([
                'result' => 'failed',
            ]);
        }
        $active = ($user['active'] + 1) % 2;
        $user['active'] = $active;
        $user->save();
        return response([
            'result' => 'success',
            'active' => $active,
        ]);
    }

    public function deleteUser(Request $request) {
        $user = User::find($request['user_id']);
        if (empty($user)) {
            return back()->with('error_message', 'Cannot find user data');
        }
        $user->delete();
        return back()->with('info_message', 'Successfully removed');
    }

    public function editUser($user_id = 0) {
        $user = User::find($user_id);
        if (empty($user) && $user_id > 0) {
            return back()->with('error_message', 'Cannot find user data');
        }
        $memberships = Membership::active()->get();
        return view('admin.users.add', [
            'menu' => 'Users',
            'user' => $user,
            'memberships' => $memberships,
        ]);
    }

    public function postEditUser($user_id = 0, Request $request) {
        $user = User::find($user_id);
        if (empty($user) && $user_id > 0) {
            return back()->with('error_message', 'Cannot find user data');
        }
        $rule = [
            'name' => ['required'],
            'membership' => ['required', 'exists:memberships,id']
        ];
        if (empty($user)) {
            $rule['email'] = ['required', 'unique:users'];
            $rule['password'] = ['required', 'confirmed'];
        } else {
            $rule['email'] = ['required', 'unique:users,email,'.$user['id']];
            if (!empty($request['password']) || !empty($request['password_confirmation'])) {
                $rule['password'] = ['required', 'confirmed'];
            }
        }
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('error_message', 'Make sure validation rules');
        }
        if (empty($user)) $user = new User();
        $user['name'] = $request['name'];
        $user['email'] = $request['email'];
        if (!empty($request['password'])) $user['password'] = Hash::make($request['password']);
        if (empty($user['membership_id']) || $user['membership_id'] != $request['membership']) {
            $membership = Membership::find($request['membership']);
            $package = $membership['membership_package'];
            $user['limitation'] = $membership['limitation'];
            $user['start_date'] = date('Y-m-d');
            $user['end_date'] = date('Y-m-d', strtotime('+'.$package['period'].' '.($package['unit'] == 'yearly' ? 'years' : 'months')));

            //Mail Notification
        }
        $user['membership_id'] = $request['membership'];
        $user['active'] = $request['active'];
        $user->save();
        return redirect()->route('admin.users')->with('info_message', 'Successfully done');
    }

    public function userGuests($user_id) {
        $user = User::find($user_id);
        if (empty($user)) {
            return back()->with('error_message', 'Cannot find user data');
        }
        $guests = Guest::where('user_id', $user_id)->get();
        return view('admin.users.guests.index', [
            'menu' => 'Users',
            'user' => $user,
            'guests' => $guests,
        ]);
    }

    public function deleteGuest($user_id, Request $request) {
        $user = User::find($user_id);
        if (empty($user)) {
            return back()->with('error_message', 'Cannot find user data');
        }
        $guest_id = $request['guest_id'];
        $guest = Guest::find($guest_id);
        if (empty($guest)) {
            return back()->with('error_message', 'Cannot find guest info');
        }
        $guest->delete();
        return back()->with('info_message', 'Guest has been removed');
    }

    public function addUserGuest($user_id, $guest_id = 0) {
        $user = User::find($user_id);
        if (empty($user)) {
            return back()->with('error_message', 'Cannot find user data');
        }
        $guest = Guest::find($guest_id);
        if (empty($guest) && $guest_id > 0) {
            return back()->with('error_message', 'Cannot find guest data');
        }
        return view('admin.users.guests.add', [
            'menu' => 'Users',
            'user' => $user,
            'guest' => $guest,
        ]);
    }

    public function postAddUserGuest($user_id, $guest_id = 0, Request $request) {
        $user = User::find($user_id);
        if (empty($user)) {
            return back()->with('error_message', 'Cannot find user data');
        }
        $guest = Guest::find($guest_id);
        if (empty($guest) && $guest_id > 0) {
            return back()->with('error_message', 'Cannot find guest data');
        }
        $rule = [
            'email' => ['required', 'email'],
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $email = $request['email'];
        $check_guest = Guest::where('user_id', $user_id)
            ->where('id', '<>', $guest_id)
            ->where('email', $email)
            ->first();
        if (!empty($check_guest)) {
            return back()->withInput()->with('error_message', 'email already exists');
        }
        if (empty($guest)) $guest = new Guest();
        $guest['user_id'] = $user_id;
        $guest['name'] = $request['name'];
        $guest['email'] = $request['email'];
        $guest->save();
        return redirect()->route('admin.user-guests', $user['id'])->with('info_message', 'Guest has been added');
    }

    public function userMeetings($user_id) {
        $user = User::find($user_id);
        if (empty($user)) {
            return back()->with('error_message', 'Cannot find user data');
        }
        $meetings = Meeting::where('user_id', $user_id)
            ->orderBy('booking_time', 'desc')
            ->get();
        $timezone = getTimezone();
        if ($timezone != 'Unknown') {
            date_default_timezone_set($timezone);
        }
        return view('admin.users.meetings.index', [
            'menu' => 'Users',
            'user' => $user,
            'meetings' => $meetings,
            'timezone' => $timezone,
        ]);
    }

    public function setting() {
        $setting = Setting::getSetting();

        $env_path = base_path('.env');
        $content = file_get_contents($env_path);

        preg_match('/^APP_NAME=(.*)/mi', $content, $matches);
        $setting['site_name'] = $matches[1];
        preg_match('/^APP_URL=(.*)/mi', $content, $matches);
        $setting['site_url'] = $matches[1];
        preg_match('/^MAIL_FROM_ADDRESS=(.*)/mi', $content, $matches);
        $setting['contact_email'] = $matches[1];

        preg_match('/^MAIL_DRIVER=(.*)/mi', $content, $matches);
        $setting['mail_driver'] = $matches[1];
        preg_match('/^MAIL_HOST=(.*)/mi', $content, $matches);
        $setting['mail_host'] = $matches[1];
        preg_match('/^MAIL_PORT=(.*)/mi', $content, $matches);
        $setting['mail_port'] = $matches[1];
        preg_match('/^MAIL_USERNAME=(.*)/mi', $content, $matches);
        $setting['mail_username'] = $matches[1];
        preg_match('/^MAIL_ENCRYPTION=(.*)/mi', $content, $matches);
        $setting['mail_encryption'] = $matches[1];

        preg_match('/^GOOGLE_CLIENT_ID=(.*)/mi', $content, $matches);
        $setting['google_client_id'] = $matches[1];
        preg_match('/^GOOGLE_CLIENT_SECRET=(.*)/mi', $content, $matches);
        $setting['google_client_secret'] = $matches[1];

        preg_match('/^LINKEDIN_CLIENT_ID=(.*)/mi', $content, $matches);
        $setting['linkedin_client_id'] = $matches[1];
        preg_match('/^LINKEDIN_CLIENT_SECRET=(.*)/mi', $content, $matches);
        $setting['linkedin_client_secret'] = $matches[1];

        View::share('setting', $setting);

        return view('admin.setting', [
            'menu' => 'Setting',
        ]);
    }

    public function postSetting(Request $request) {
        $rule = [];
        if ($request['type'] == 'general') {
            $rule = [
                'site_name' => ['required', 'regex:/^\S*$/'],
                'site_url' => ['required', 'url'],
                'contact_email' => ['required', 'email'],
                'how_video' => ['required', 'url'],
            ];
        } else if ($request['type'] == 'seo') {
            $rule = [
                'meta_title' => ['required'],
                'meta_keywords' => ['required'],
                'meta_description' => ['required'],
            ];
        } else if ($request['type'] == 'mail') {
            $rule = [
                'mail_driver' => ['required'],
                'mail_host' => ['required'],
                'mail_port' => ['required'],
                'mail_username' => ['required'],
                'mail_encryption' => ['required'],
            ];
        } else if ($request['type'] == 'google') {
            $rule = [
                'google_client_id' => ['required'],
                'google_client_secret' => ['required'],
            ];
        } else if ($request['type'] == 'linkedin') {
            $rule = [
                'linkedin_client_id' => ['required'],
                'linkedin_client_secret' => ['required'],
            ];
        } else {
            return back()->withInput()->with('error_message', 'Some went wrong. Please try again.');
        }
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('error_message', 'Make sure validation rules');
        }

        $env_path = base_path('.env');
        $env = file_get_contents($env_path);
        if ($request['type'] == 'general') {
            if (substr($request['site_url'], -1) != '/') $request['site_url'] = $request['site_url'].'/';
            $env = preg_replace('/APP_NAME=.*\s/', "APP_NAME=".$request['site_name']."\n", $env);
            $env = preg_replace('/APP_URL=.*\s/', "APP_URL=".$request['site_url']."\n", $env);
            $env = preg_replace('/MAIL_FROM_ADDRESS=.*\s/', "MAIL_FROM_ADDRESS=".$request['contact_email']."\n", $env);
        } else if ($request['type'] == 'mail') {
            $env = preg_replace('/MAIL_DRIVER=.*\s/', "MAIL_DRIVER=".$request['mail_driver']."\n", $env);
            $env = preg_replace('/MAIL_HOST=.*\s/', "MAIL_HOST=".$request['mail_host']."\n", $env);
            $env = preg_replace('/MAIL_PORT=.*\s/', "MAIL_PORT=".$request['mail_port']."\n", $env);
            $env = preg_replace('/MAIL_USERNAME=.*\s/', "MAIL_USERNAME=".$request['mail_username']."\n", $env);
            if (!empty($request['mail_password'])) {
                $env = preg_replace('/MAIL_PASSWORD=.*\s/', "MAIL_PASSWORD=".$request['mail_password']."\n", $env);
            }
            $env = preg_replace('/MAIL_ENCRYPTION=.*\s/', "MAIL_ENCRYPTION=".$request['mail_encryption']."\n", $env);
        } else if ($request['type'] == 'google') {
            $env = preg_replace('/GOOGLE_CLIENT_ID=.*\s/', "GOOGLE_CLIENT_ID=".$request['google_client_id']."\n", $env);
            $env = preg_replace('/GOOGLE_CLIENT_SECRET=.*\s/', "GOOGLE_CLIENT_SECRET=".$request['google_client_secret']."\n", $env);
        } else if ($request['type'] == 'linkedin') {
            $env = preg_replace('/LINKEDIN_CLIENT_ID=.*\s/', "LINKEDIN_CLIENT_ID=".$request['linkedin_client_id']."\n", $env);
            $env = preg_replace('/LINKEDIN_CLIENT_SECRET=.*\s/', "LINKEDIN_CLIENT_SECRET=".$request['linkedin_client_secret']."\n", $env);
        }
        file_put_contents($env_path, $env);

        Setting::saveSetting($request->except(['_token', 'type', 'site_logo', 'favicon']));
        if ($request->hasFile('site_logo')) {
            Setting::saveSetting('site_logo', 'uploads/'.$request->file('site_logo')->store('logo'));
        }
        if ($request->hasFile('favicon')) {
            Setting::saveSetting('favicon', 'uploads/'.$request->file('favicon')->store('logo'));
        }
        return back()->with('info_message', 'Successfully saved');
    }

    public function profile() {
        return view('admin.profile', [
            'menu' => 'Profile',
        ]);
    }

    public function postProfile(Request $request) {
        $rule = [
            'email' => ['required'],
        ];
        if (!empty($request['password']) || !empty($request['password_confirmation'])) {
            $rule['password'] = ['required', 'min:6', 'confirmed'];
        }
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('error_message', 'Make sure validation rules');
        }
        $admin = Admin::find(Auth::guard('admin')->user()->id);
        $admin['email'] = $request['email'];
        if (!empty($request['password'])) $admin['password'] = Hash::make($request['password']);
        $admin->save();
        return back()->with('info_message', 'Successfully saved');
    }
}
