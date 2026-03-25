<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,500,600,700" rel="stylesheet" type="text/css">
    <style>
        @import url(https://fonts.googleapis.com/css?family=Raleway:300,400,500,600,700);

        html {
            width: 100%;
        }

        body {
            width: 100%;
            background-color: white;
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
            mso-margin-top-alt: 0px;
            mso-margin-bottom-alt: 0px;
            mso-padding-alt: 0px 0px 0px 0px;
        }

        p, h1, h2, h3, h4 {
            margin-top: 0;
            margin-bottom: 0;
            padding-top: 0;
            padding-bottom: 0;
        }

        table {
            font-size: 14px;
            border-collapse: collapse;
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
            border: 0px;
        }

        @media only screen and (max-width: 600px) {
            body {
                min-width: 100% !important;
            }

            .title {
                width: 450px !important;
                text-align: center !important;
            }

            .image_container_main a img {
                width: 450px !important;
                height: auto !important
            }
        }

        @media only screen and (max-width: 481px) {
            body {
                min-width: 100% !important;
            }

            .title {
                text-align: center !important;
                width: 300px !important;
            }

            .image_container_main a img {
                width: 300px !important;
                height: auto !important;
            }
        }
    </style>
</head>
<body style="background: rgb(204, 204, 204); padding: 50px 0px;">
<table width="100%" align="center" cellpadding="0" cellspacing="0" border="0"
       style="max-width:800px;display: table; background-color: #ffffff;" data-type="image">
    <tbody>
    <tr>
        <td align="center" style="padding: 015px 20px 15px 20px ;" class="image">
            <div class="ui-wrapper" style="overflow: hidden; position: relative; width: 180px; top: 0px; left: 0px; margin: 0px;">
                <a href="{{ route('index') }}" style="text-decoration: none;">
                    <img class="resizable ui-resizable" border="0"
                         style="display: block; max-width: 65px; margin: 12px 0; resize: none; position: static; zoom: 1;"
                         alt="" src="{{ asset('public/'.$setting['site_logo']) }}" tabindex="0">
                    <h1>{{ $setting['site_name'] }}</h1>
                </a>
            </div>
        </td>
    </tr>
    </tbody>
</table>
<table class="main" width="100%" align="center" cellpadding="0" cellspacing="0" border="0"
       style="max-width:800px;border: 0; display: table; background-color: #ffffff;">
    <tbody>
    <tr>
        <td class="divider-simple" style="padding: 015px 20px 0px 20px ;">
            <table width="100%" cellspacing="0" cellpadding="0" border="0" style="border-top: 1px solid #DADFE1;">
                <tbody>
                <tr>
                    <td width="100%" height="15px"></td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>
<table width="100%" align="center" cellpadding="0" cellspacing="0" border="0" style=" display: table;max-width:800px; background-color: #fff">
    <tbody>
    <tr>
        <td align="center" class="title" style="padding:05px 20px 5px 20px ; color: #757575;">
            <h3 style="width:auto; font-family: Arial, sans-serif; padding-top: 30px; font-weight: 500; color: #000000; line-height: 42px; font-size: 25px;"
                >Hi {{ $data['name'] }}</h3>
            <h4 style="font-family: Arial, sans-serif; font-weight: 500; color: #039a0f; line-height: 22px; font-size: 16px;"></h4>
        </td>
    </tr>
    </tbody>
</table>
<table width="100%" align="center" cellpadding="0" cellspacing="0" border="0" style="max-width:800px;display: table; background-color:  #ffffff">
    <tbody>
    <tr>
        <td align="left" style="padding:10px 30px 0 30px; text-decoration: none; font-family: 'Raleway', Open Sans, sans-serif; font-size: 17px; line-height:30px; color:#000; font-weight:400;">
            <p style="padding: 5px;">
                The Email Address for {{ $data['name'] }} has been changed to {{ $data['email'] }}.
                If you did not request this action, please contact us immediately at {{ $setting['contact_email'] }} and report it.
            </p>
        </td>
    </tr>
    <tr>
        <td align="left" style="padding:10px 30px 0 30px; text-decoration: none; font-family: 'Raleway', Open Sans, sans-serif; font-size: 17px; line-height:30px; color:#000; font-weight:400;">
        </td>
    </tr>
    <tr>
        <td align="left" style="padding:0 30px; text-decoration: none; font-family: 'Raleway', Open Sans, sans-serif; font-size: 17px; line-height:30px; color:#000; font-weight:400;">
            <p style="padding: 5px">Thanks</p>
            <p style="padding: 5px">{{ $setting['site_name'] }} Support</p>
        </td>
    </tr>
    </tbody>
</table>
<table width="100%" align="center" cellpadding="0" cellspacing="0" border="0" style="max-width:800px;display: table; background-color:  #ffffff">
    <tbody>
    <tr>
        <td align="left" style="padding:10px 20px 10px 20px; text-decoration: none; font-family: 'Raleway', Open Sans, sans-serif; font-size: 17px; line-height:30px; color:#000; font-weight:400; text-align: center;">
            <h3> </h3>
        </td>
    </tr>
    </tbody>
</table>
<table width="100%" align="center" cellpadding="0" cellspacing="0" border="0" style="max-width:800px;display: table; background-color:#929292">
    <tbody>
    <tr style="height: 63px;">
        <td align="left"
            style="padding:10px 20px 10px 20px; text-decoration: none; font-family: 'Raleway', Open Sans, sans-serif; font-size: 14px; line-height:21px; color:#ffffff; text-align: center; font-weight:400;">
            <p style="text-align: center;"><span style="font-size: 10pt;">&copy; {{ date('Y') }}, {{ $setting['site_name'] }}. All Rights Reserved.</span></p>
        </td>
    </tr>
    </tbody>
</table>
</body>
</html>