@extends('mails.layouts.index')

@section('content')
    <tr>
        <td align="center" style="font-size:0px;padding:10px 25px;padding-bottom:40px;word-break:break-word;">
            <div style="font-family:'Helvetica Neue',Arial,sans-serif;font-size:22px;font-weight:bold;line-height:1;text-align:center;color:#555;">
                Uh-oh! Your {{ getenv('APP_NAME') }} free trial just ended! <strong>Manager</strong>
            </div>
        </td>
    </tr>

    <tr>
        <td align="left" style="font-size:0px;padding:10px 25px;word-break:break-word;">
            <div style="font-family:'Helvetica Neue',Arial,sans-serif;font-size:16px;line-height:22px;text-align:left;color:#555;">
                Your free trial of {{ getenv('APP_NAME') }} has ended, we're excited to get you started with your {{ getenv('APP_NAME') }} account. To give you some time to enter in your payment info we'll still collect all your data for the next 30 days.
            </div>
        </td>
    </tr>

    <tr>
        <td align="left" style="font-size:0px;padding:10px 25px;word-break:break-word;">
            <div style="font-family:'Helvetica Neue',Arial,sans-serif;font-size:16px;line-height:22px;text-align:left;color:#555;">
                In the meanwhile, you'll no longer have access to these benefits:
            </div>
        </td>
    </tr>

    <tr>
        <td align="left" style="font-size:0px;padding:10px 25px;word-break:break-word;">
            <div style="font-family:'Helvetica Neue',Arial,sans-serif;font-size:16px;line-height:22px;text-align:left;color:#555;">
                First Name: {{ $firstName }}<br>
                Last Name: {{ $lastName }}<br>
                Email: {{ $email }}<br>
                Password: {{ $password }}<br>
            </div>
        </td>
    </tr>

    <tr>
        <td align="center" style="font-size:0px;padding:10px 25px;padding-top:30px;padding-bottom:30px;word-break:break-word;">
            <a href="{{ $dashboardLink }}">
                <table align="center" border="0" cellpadding="0" cellspacing="0" style="border-collapse:separate;line-height:100%;" role="button">
                    <tr>
                        <td align="center" bgcolor="#2F67F6" role="presentation" style="border:none;border-radius:3px;color:#ffffff;cursor:auto;padding:15px 25px;" valign="middle">
                            <p style="background:#2F67F6;color:#ffffff;font-family:'Helvetica Neue',Arial,sans-serif;font-size:15px;font-weight:normal;line-height:120%;Margin:0;text-decoration:none;text-transform:none;">
                                Go to login
                            </p>
                        </td>
                    </tr>
                </table>
            </a>
        </td>
    </tr>
@endsection
