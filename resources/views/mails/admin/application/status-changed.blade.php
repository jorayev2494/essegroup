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
                {{ __('system.hi')  }},
            </div>
        </td>
    </tr>

    <tr>
        <td align="left" style="font-size:0px;padding:10px 25px;word-break:break-word;">
            <div style="font-family:'Helvetica Neue',Arial,sans-serif;font-size:16px;line-height:22px;text-align:left;color:#555;">
                {{ __('mails.application.status_was_changed.text')  }}
            </div>
        </td>
    </tr>

    <tr>
        <td align="left" style="font-size:0px;padding:10px 25px;word-break:break-word;">
            <div style="font-family:'Helvetica Neue',Arial,sans-serif;font-size:16px;line-height:22px;text-align:left;color:#555;">
                {{ __('system.application')  }} uuid: {{ $application->getUuid()->value }}<br>
                {{ __('system.new_status')  }}: {{ StatusValueTranslate::execute($status->getStatusValue(), $locale)->getValue()->value }}<br>
                {{ __('system.new_note')  }}: {{ $status->getNote() }}
            </div>
        </td>
    </tr>
@endsection
