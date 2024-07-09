@extends('mails.layouts.index')

@section('content')
    <tr>
        <td align="left" style="font-size:0px;padding:10px 25px;word-break:break-word;">
            <div style="font-family:'Helvetica Neue',Arial,sans-serif;font-size:16px;line-height:22px;text-align:left;color:#555;">
                {{ __('mails.company.student.created_text')  }}
            </div>
        </td>
    </tr>

    <tr>
        <td align="left" style="font-size:0px;padding:10px 25px;word-break:break-word;">
            <div style="font-family:'Helvetica Neue',Arial,sans-serif;font-size:16px;line-height:22px;text-align:left;color:#555;">
                {{ __('system.first_name') }}: {{ $firstName }}<br>
                {{ __('system.lsat_name') }}: {{ $lastName }}<br>
                {{ __('system.email') }}: {{ $email }}<br>
            </div>
        </td>
    </tr>
@endsection
