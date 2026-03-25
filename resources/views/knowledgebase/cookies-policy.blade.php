@extends('layouts')

@section('title', 'Cookies Policy')

@section('seo')
    <meta name="description" content=""/>

    <meta property="og:title" content="Cookies Policy | PIGEON"/>
    <meta property="og:url" content="{{ route('cookies-policy') }}"/>
    <meta property="og:description" content=""/>
@endsection

@section('content')
    <div class="container my-5">
        <div class="row">
            <div class="col-12 text-black-50 mb-4">
                <a href="{{ route('knowledgebase') }}" class="text-dark">Knowledge Base</a>
                <i class="fa fa-arrow-right mx-2"></i> Cookies Policy
            </div>
            <div class="col-12">
                <h5 class="mb-3 text-bold">Cookies Policy</h5>
                <p>
                    This website (joinpigeon.com) (“our Site” or “the Site”) uses cookies to distinguish you from other
                    users of our Site. This helps us to provide you with a good experience when you browse our Site and
                    also allows us to improve our Site.<br>
                </p>
                <p>
                    A cookie is a small file of letters and numbers that we store on your browser or the hard drive of
                    your computer or internet-enabled device if you agree. Cookies contain information that is
                    transferred to your computer's hard drive or internet-enabled device.<br>
                </p>
                <p>
                    We use the following cookies:<br>
                </p>
                <p>
                    <b>• Strictly necessary cookies.</b> These are cookies that are required for the operation of our Site.
                    These necessary cookies enable core functionality, such as security, network management and
                    accessibility.<br>
                </p>
                <p>
                    <b>• Analytical or performance cookies.</b> These allow us to recognise and count the number of
                    visitors and to see how visitors move around our Site when they are using it. This helps us to
                    improve the way our Site works, for example, by ensuring that users are finding what they are looking
                    for easily.<br>
                </p>
                <p>
                    <b>• Functionality cookies.</b> These are used to recognise you when you return to our Site. This
                    enables us to personalise our content for you, greet you by name and remember your preferences (for
                    example, your choice of language or region).<br>
                </p>
                <p>
                    You can find more information about the individual cookies we use and the purposes for which we use
                    them in the table below:<br><br>
                </p>
                <table class="table table-bordered table-responsive">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Purpose</th>
                        <th>Cookie Expires</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>G_AUTHUSER_H</td>
                        <td>Strictly Necessary</td>
                        <td>Used for “Sign in with Google”</td>
                        <td>End of session</td>
                    </tr>
                    <tr>
                        <td>XSRF-TOKEN</td>
                        <td>Strictly Necessary</td>
                        <td>This cookie is written to help with site security in preventing Cross-Site Request Forgery attacks.</td>
                        <td>End of session</td>
                    </tr>
                    <tr>
                        <td>pigeon_session</td>
                        <td>Strictly Necessary</td>
                        <td>Session Management, User Authentication, Content Management</td>
                        <td>End of session</td>
                    </tr>
                    <tr>
                        <td>_gat_gtag_UA_179172738_1</td>
                        <td>Analytics</td>
                        <td>Google Analytics cookie</td>
                        <td>1 minute</td>
                    </tr>
                    <tr>
                        <td>_ga</td>
                        <td>Analytics</td>
                        <td>Google Analytics cookie</td>
                        <td>2 years</td>
                    </tr>
                    <tr>
                        <td>_gid</td>
                        <td>Analytics</td>
                        <td>Google Analytics cookie</td>
                        <td>1 day</td>
                    </tr>
                    </tbody>
                </table>
                <br>
                <p>
                    Please note that the following third parties may also use cookies, over which we have no control.
                    These named third parties may include, for example, advertising networks and providers of external
                    services like web traffic analysis services. These third party cookies are likely to be analytical
                    cookies or performance cookies or targeting cookies:<br>
                </p>
                <p>
                    Google Analytics<br>
                </p>
                <p>
                    You can block cookies by activating the setting on your browser that allows you to refuse the
                    setting of all or some cookies. However, if you use your browser settings to block all cookies
                    (including essential cookies) you may not be able to access all or parts of our Site.<br>
                </p>
                <p>
                    For instructions on how to manage and disable cookies, see the privacy and help documentation of
                    your specific browser’s website. If you use more devices and/or browsers you will need to disable
                    cookies on each device and on each browser separately.<br>
                </p>
                <p>
                    To manage or disable the use of cookies by Google Analytics, please visit
                    <a href="http://tools.google.com/dlpage/gaoptout">http://tools.google.com/dlpage/gaoptout</a>.<br>
                </p>
                <p>
                    Find out how to manage or disable cookies on popular browsers:<br>
                    <a href="https://support.google.com/accounts/answer/61416?co=GENIE.Platform%3DDesktop&hl=en">Google Chrome</a><br>
                    <a href="https://privacy.microsoft.com/en-us/windows-10-microsoft-edge-and-privacy">Microsoft Edge</a><br>
                    <a href="https://support.mozilla.org/en-US/kb/enable-and-disable-cookies-website-preferences">Mozilla Firefox</a><br>
                    <a href="https://support.microsoft.com/en-gb/help/17442/windows-internet-explorer-delete-manage-cookies">Microsoft Internet Explorer</a><br>
                    <a href="https://www.opera.com/help/tutorials/security/privacy/">Opera</a><br>
                    <a href="https://support.apple.com/kb/ph21411?locale=en_US">Apple Safari</a><br>
                </p>
                <p>
                    Except for essential cookies, all cookies on this Site expire after 90 days<br>
                </p>
            </div>
        </div>
    </div>
@endsection