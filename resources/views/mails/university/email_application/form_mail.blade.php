@extends('mails.layouts.index')

@section('content')
    <tr>
        <td align="center" style="font-size:0px;padding:10px 25px;padding-bottom:40px;word-break:break-word;">
            <div style="font-family:'Helvetica Neue',Arial,sans-serif;font-size:22px;font-weight:bold;line-height:1;text-align:center;color:#555;">
                Site Email Application
            </div>
        </td>
    </tr>

{{--    <tr>--}}
{{--        <td align="center" style="font-size:0px;padding:10px 25px;padding-bottom:40px;word-break:break-word;">--}}
{{--            <div style="font-family:'Helvetica Neue',Arial,sans-serif;font-size:22px;font-weight:bold;line-height:1;text-align:center;color:#555;">--}}
{{--                {{ __('system.welcome') }} {{ $firstName }}!--}}
{{--            </div>--}}
{{--        </td>--}}
{{--    </tr>--}}

{{--    <tr>--}}
{{--        <td align="left" style="font-size:0px;padding:10px 25px;word-break:break-word;">--}}
{{--            <div style="font-family:'Helvetica Neue',Arial,sans-serif;font-size:16px;line-height:22px;text-align:left;color:#555;">--}}
{{--                {{ __('mails.auth.register.student.text', ['product_name' => getenv('APP_NAME')])  }}--}}
{{--            </div>--}}
{{--        </td>--}}
{{--    </tr>--}}

{{--    <tr>--}}
{{--        <td align="left" style="font-size:0px;padding:10px 25px;word-break:break-word;">--}}
{{--            <div style="font-family:'Helvetica Neue',Arial,sans-serif;font-size:16px;line-height:22px;text-align:left;color:#555;">--}}
{{--                {{ __('mails.auth.register.student.credentials_text')  }}--}}
{{--            </div>--}}
{{--        </td>--}}
{{--    </tr>--}}

    <tr>
        <td align="left" style="font-size:0px;padding:10px 25px;word-break:break-word;">
            <div style="font-family:'Helvetica Neue',Arial,sans-serif;font-size:16px;line-height:22px;text-align:left;color:#555;">
                Öğrencinin adi: <b>{{ $firstName }}</b> <br>
                Öğrencinin soyadı: <b>{{ $lastName }}</b><br><br>

                Baba adı: <b>{{ $fatherFirstName }}</b><br>
                Anne adı: <b>{{ $motherFirstName }}</b><br><br>

                Telefon: <b>{{ $phone }}</b><br>
                Ek Telefon: <b>{{ $additionalPhone }}</b><br><br>

                Not: <b>{{ $note }}</b><br>
            </div>
        </td>
    </tr>

{{--    <tr>--}}
{{--        <td align="center" style="font-size:0px;padding:10px 25px;padding-top:30px;padding-bottom:30px;word-break:break-word;">--}}
{{--            <a href="{{ $dashboardLink }}">--}}
{{--                <table align="center" border="0" cellpadding="0" cellspacing="0" style="border-collapse:separate;line-height:100%;" role="button">--}}
{{--                    <tr>--}}
{{--                        <td align="center" bgcolor="#2F67F6" role="presentation" style="border:none;border-radius:3px;color:#ffffff;cursor:auto;padding:15px 25px;" valign="middle">--}}
{{--                            <p style="background:#2F67F6;color:#ffffff;font-family:'Helvetica Neue',Arial,sans-serif;font-size:15px;font-weight:normal;line-height:120%;Margin:0;text-decoration:none;text-transform:none;">--}}
{{--                                {{ __('mails.auth.register.student.go_to_login_btn')  }}--}}
{{--                            </p>--}}
{{--                        </td>--}}
{{--                    </tr>--}}
{{--                </table>--}}
{{--            </a>--}}
{{--        </td>--}}
{{--    </tr>--}}
@endsection
