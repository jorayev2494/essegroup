@extends('mails.layouts.index')

@section('content')
    <tr>
        <td style="font-size:0px;padding:10px 25px;padding-bottom:20px;word-break:break-word;">
            <div style="font-family:'Helvetica Neue',Arial,sans-serif;font-size:22px;font-weight:bold;line-height:1;color:#555;">
                {{ __('system.hi') }} {{ $firstName }},
            </div>
        </td>
    </tr>

    <tr>
        <td align="left" style="font-size:0px;padding:10px 25px;word-break:break-word;">
            <div style="font-family:'Helvetica Neue',Arial,sans-serif;font-size:16px;line-height:22px;text-align:left;color:#555;">
                {{
                    __(
                        'mails.auth.forgot_password.text',
                        [
                            'product_name' => getenv('APP_NAME'),
                        ]
                    )
                }}
            </div>
        </td>
    </tr>

    <tr>
        <td align="center" style="font-size:0px;padding:10px 25px;padding-top:30px;padding-bottom:50px;word-break:break-word;">
            <a href="{{ $restoreLink }}">
                <table align="center" border="0" cellpadding="0" cellspacing="0" style="border-collapse:separate;line-height:100%;" role="button">
                    <tr>
                        <td align="center" bgcolor="#2F67F6" role="presentation" style="border:none;border-radius:3px;color:#ffffff;cursor:auto;padding:15px 25px;" valign="middle">
                            <p style="background:#2F67F6;color:#ffffff;font-family:'Helvetica Neue',Arial,sans-serif;font-size:15px;font-weight:normal;line-height:120%;Margin:0;text-decoration:none;text-transform:none;">
                                {{ __('mails.auth.forgot_password.reset_your_password_btn') }}
                            </p>
                        </td>
                    </tr>
                </table>
            </a>
        </td>
    </tr>

    <tr>
        <td align="center" style="font-size:0px;padding:10px 25px;padding-bottom:40px;word-break:break-word;">
            <div style="font-family:'Helvetica Neue',Arial,sans-serif;font-size:16px;line-height:20px;text-align:center;color:#7F8FA4;">
                {{ __('mails.auth.forgot_password.ignore_text') }}
            </div>
        </td>
    </tr>
@endsection
