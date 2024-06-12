@php

use Project\Domains\Admin\University\Domain\Application\Application;
use Project\Domains\Admin\University\Domain\Application\ValueObjects\Status;
use Project\Domains\Admin\University\Domain\Application\StatusValue;
use Project\Domains\Admin\University\Domain\Application\StatusValueTranslate;

/**
 * @var Application $application
 * @var Status $status
 * @var StatusValue $statusValue
 */

@endphp

@extends('mails.layouts.index')

@section('content')
    <tr>
        <td align="center" style="font-size:0px;padding:10px 25px;padding-bottom:40px;word-break:break-word;">
            <div style="font-family:'Helvetica Neue',Arial,sans-serif;font-size:22px;font-weight:bold;line-height:1;text-align:center;color:#555;">
                Uh-oh! Your {{ getenv('APP_NAME') }} free trial just ended! <strong>Student</strong>
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
                Application uuid: {{ $application->getUuid()->value }}<br>
                New status: {{ StatusValueTranslate::execute($status->getStatusValue(), $locale)->getValue()->value }}<br>
                New note: {{ $status->getNote() }}
            </div>
        </td>
    </tr>
@endsection
