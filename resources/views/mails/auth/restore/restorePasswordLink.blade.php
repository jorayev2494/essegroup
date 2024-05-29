@extends('mails.layouts.index')

@section('content')
    <tr>
        <td style="font-size:0px;padding:10px 25px;padding-bottom:20px;word-break:break-word;">
            <div style="font-family:'Helvetica Neue',Arial,sans-serif;font-size:22px;font-weight:bold;line-height:1;color:#555;">
                Hi {{ $firstName }},
            </div>
        </td>
    </tr>

    <tr>
        <td align="left" style="font-size:0px;padding:10px 25px;word-break:break-word;">
            <div style="font-family:'Helvetica Neue',Arial,sans-serif;font-size:16px;line-height:22px;text-align:left;color:#555;">
                You recently requested to reset your password for your {{ getenv('APP_NAME')  }} account. Use the button below to reset it.
            </div>
        </td>
    </tr>

    {{-- <tr>
        <td align="center" style="font-size:0px;padding:10px 25px;word-break:break-word;">
            <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="border-collapse:collapse;border-spacing:0px;">
                <tbody>
                    <tr>
                        <td style="width:128px;">
                            <img height="auto" src="https://i.imgur.com/247tYSw.png" style="border:0;display:block;outline:none;text-decoration:none;width:100%;" width="128" />
                        </td>
                    </tr>
                </tbody>
            </table>
        </td>
    </tr> --}}

    <tr>
        <td align="center" style="font-size:0px;padding:10px 25px;padding-top:30px;padding-bottom:50px;word-break:break-word;">
            <a href="{{ $restoreLink }}">
                <table align="center" border="0" cellpadding="0" cellspacing="0" style="border-collapse:separate;line-height:100%;" role="button">
                    <tr>
                        <td align="center" bgcolor="#2F67F6" role="presentation" style="border:none;border-radius:3px;color:#ffffff;cursor:auto;padding:15px 25px;" valign="middle">
                            <p style="background:#2F67F6;color:#ffffff;font-family:'Helvetica Neue',Arial,sans-serif;font-size:15px;font-weight:normal;line-height:120%;Margin:0;text-decoration:none;text-transform:none;">
                                Reset Password
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
                If you did not make this request, just ignore this email. Otherwise please click the button above to reset your password.
            </div>
        </td>
    </tr>
@endsection
