@php
    use Project\Domains\Admin\Student\Domain\Student\Student;
    use Project\Domains\Admin\Country\Domain\Country\CountryTranslate;

    /** @var Student $student */
@endphp

<!DOCTYPE html>
<html lang="zxx">
    <head>
        <title>DISEE - Invoice HTML5 Template</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="UTF-8">

        <!-- External CSS libraries -->
        <link type="text/css" rel="stylesheet" href="{{ asset('pdf/css/bootstrap.min.css')  }}">
        <link type="text/css" rel="stylesheet" href="{{ asset('pdf/fonts/font-awesome/css/font-awesome.min.css')  }}">

        <!-- Favicon icon -->
        <link rel="shortcut icon" href="{{ asset('pdf/img/favicon.ico')  }}" type="image/x-icon" >

        <!-- Google fonts -->
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900">

        <!-- Custom Stylesheet -->
        <link type="text/css" rel="stylesheet" href="{{ asset('pdf/css/style.css')  }}">

        @php
            $personalDetails = [
                'pdf.student.form.full_name' => $student->getFullName()->toArray()['full_name'],
                'pdf.student.form.birthday' => $student->getBirthday()->format('d.m.Y'),
                'pdf.student.form.email' => $student->getEmail()->value,
                'pdf.student.form.nationality' => CountryTranslate::execute($student->getNationality())?->getValue()->value ?? 'Unknown',
                'pdf.student.form.passport_info.number' => $student->getPassportInfo()->getNumber()->value,
                'pdf.student.form.passport_info.date_of_issue' => $student->getPassportInfo()->getDateOfIssue()?->format('d.m.Y'),
                'pdf.student.form.passport_info.date_of_expiry' => $student->getPassportInfo()->getDateOfExpiry()?->format('d.m.Y'),
                'pdf.student.form.phone' => $student->getPhone()->value,
                'pdf.student.form.friend_phone' => $student->getFriendPhone()->value,
                'pdf.student.form.country_of_residence' => CountryTranslate::execute($student->getCountryOfResidence())?->getValue()->value ?? 'Unknown',
                'pdf.student.form.home_address' => $student->getHomeAddress()->value,
                'pdf.student.form.gender' => $student->getGender()?->value,
                'pdf.student.form.marital_type' => $student->getMaritalType()?->value,
                'pdf.student.form.parents.father_name' => $student->getParentsName()->getFatherName()->value,
                'pdf.student.form.parents.mother_name' => $student->getParentsName()->getMotherName()->value,
                'pdf.student.form.high_school.country' => CountryTranslate::execute($student->getHighSchoolCountry())?->getValue()->value ?? 'Unknown',
                'pdf.student.form.high_school.name' => $student->getHighSchool()->getName()->value,
                'pdf.student.form.high_school.grade_average' => $student->getHighSchool()->getGradeAverage()->value,
            ];
        @endphp

    </head>
    <body>

        <!-- Invoice 1 start -->
        <div class="invoice-1 invoice-content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="invoice-inner clearfix">
                            <div class="invoice-info clearfix" id="invoice_wrapper">

                                <div class="invoice-headar">
                                    <div class="row g-0">
                                        <div class="col-sm-6">
                                            <div class="invoice-logo">
                                                <!-- logo started -->
                                                <div class="logo">
                                                    <img src="{{ asset('images/logo/192x192.png')  }}" alt="logo" height="100%">
                                                </div>
                                                <!-- logo ended -->
                                            </div>
                                        </div>

                                        <div class="col-sm-6 invoice-id">
                                            <div class="info">
                                                <h1 class="color-white inv-header-1">Invoice</h1>
                                                <p class="color-white mb-1">Invoice Number <span>#45613</span></p>
                                                <p class="color-white mb-0">Invoice Date <span>21 Sep 2021</span></p>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="invoice-top">
                                    <div class="row">

                                        <div class="col-sm-3">
                                            <div class="card-body p-0">
                                                <div class="avatar avatar-xxl">
                                                    {{-- <img class="avatar-img rounded" alt="Client Avatar" src="{{ $student->getAvatar()?->getUrl() ?? 'https://placehold.co/100x100' }}" width="100%"> --}}
                                                    <img class="avatar-img rounded" alt="Client Avatar" src="{{ $avatar }}" width="100%">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-5 pt-2">
                                            <div class="invoice-number mb-30">
                                                <h4 class="inv-title-1">Student</h4>
                                                <h2 class="name mb-10">{{ $student->getFullName()->toArray()['full_name'] ?? '' }}</h2>
                                                <p class="invo-addr-1">
                                                    Theme Vessel <br/>
                                                    info@themevessel.com <br/>
                                                    21-12 Green Street, Meherpur, Bangladesh <br/>
                                                </p>
                                            </div>
                                        </div>

                                        <div class="col-sm-4 pt-2">
                                            <div class="invoice-number mb-30">
        {{--                                        <div class="invoice-number-inner">--}}
                                                    <h4 class="inv-title-1">Invoice From</h4>
                                                    <h2 class="name mb-10">Animas Roky</h2>
                                                    <p class="invo-addr-1">
                                                        Apexo Inc  <br/>
                                                        billing@apexo.com <br/>
                                                        169 Teroghoria, Bangladesh <br/>
                                                    </p>
        {{--                                        </div>--}}
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="invoice-center">
                                    <div class="invoice-number mt-4">
                                        <div class="row">
                                            <div class="col-sm-3 col-md-3"></div>
                                            <div class="col-sm-9 col-md-9">
                                                <h4 class="inv-title-1 mb-3">
                                                    {{ trans("project.domains.admin.student.infrastructure.student.translations::pdf.student.title") }}
                                                </h4>

                                                @foreach($personalDetails as $key => $value)
                                                    <div class="row">
                                                        <p class="col-sm-7 mb-0">{{ trans("project.domains.admin.student.infrastructure.student.translations::$key") }}</p>
                                                        <p class="col-sm-5">{{ $value }}</p>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="invoice-bottom">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-8 col-sm-7">
                                            <div class="mb-30 dear-client">
                                                <h3 class="inv-title-1">Terms & Conditions</h3>
                                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been typesetting industry. Lorem Ipsum</p>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-4 col-sm-5">
                                            <div class="mb-30 payment-method">
                                                <h3 class="inv-title-1">Payment Method</h3>
                                                <ul class="payment-method-list-1 text-14">
                                                    <li><strong>Account No:</strong> 00 123 647 840</li>
                                                    <li><strong>Account Name:</strong> Jhon Doe</li>
                                                    <li><strong>Branch Name:</strong> xyz</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="invoice-contact clearfix">
                                    <div class="row g-0">
                                        <div class="col-lg-9 col-md-11 col-sm-12">
                                            <div class="contact-info">
                                                <a href="tel:+55-4XX-634-7071">
                                                    <i class="fa fa-phone"></i>
                                                    +00 123 647 840
                                                </a>
                                                <a href="tel:info@themevessel.com">
                                                    <i class="fa fa-envelope"></i>
                                                    info@themevessel.com
                                                </a>
                                                <a href="tel:info@themevessel.com" class="mr-0 d-none-580">
                                                    <i class="fa fa-map-marker"></i>
                                                    169 Teroghoria, Bangladesh
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="invoice-btn-section clearfix d-print-none">
                                <a href="javascript:window.print()" class="btn btn-lg btn-print">
                                    <i class="fa fa-print"></i> Print
                                </a>
                                <a id="invoice_download_btn" class="btn btn-lg btn-download btn-theme">
                                    <i class="fa fa-download"></i> Download
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Invoice 1 end -->

        <script src="{{ asset('pdf/js/jquery.min.js') }}"></script>
        <script src="{{ asset('pdf/js/jspdf.min.js') }}"></script>
        <script src="{{ asset('pdf/js/html2canvas.js')  }}"></script>
        <script src="{{ asset('pdf/js/app.js')  }}"></script>
    </body>
</html>
