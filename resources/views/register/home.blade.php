@extends('layouts.form')

@section('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
    <script src="https://malsup.github.io/jquery.blockUI.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script src="https://rawgit.com/RobinHerbots/Inputmask/5.x/dist/jquery.inputmask.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
        integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        body {
            background-color: #d8e8b0;
        }

        .bg-light2 {
            background-color: #fff;
        }

        .card-header-custom {
            background-image: url("{{ asset('images/school_309241295.jpg') }}");
            height: 420px;
            background-repeat: no-repeat;
        }

        hr {
            margin-top: 1rem;
            margin-bottom: 1rem;
            border: 0;
            border-top: 1px solid #112d53;
        }

        .div_center {
            margin: auto;
            text-align: center;

        }

        .timeline {
            position: relative;
            padding: 21px 0px 10px;
            margin-top: 4px;
            margin-bottom: 30px;
        }

        .timeline .line {
            position: absolute;
            width: 4px;
            display: block;
            background: currentColor;
            top: 0px;
            bottom: 0px;
            margin-left: 30px;
        }

        .timeline .separator {
            border-top: 1px solid currentColor;
            padding: 5px;
            padding-left: 40px;
            font-style: italic;
            font-size: .9em;
            margin-left: 30px;
        }

        .timeline .line::before {
            top: -4px;
        }

        .timeline .line::after {
            bottom: -4px;
        }

        .timeline .line::before,
        .timeline .line::after {
            content: '';
            position: absolute;
            left: -4px;
            width: 12px;
            height: 12px;
            display: block;
            border-radius: 50%;
            background: currentColor;
        }

        .timeline .panel {
            position: relative;
            margin: 10px 0px 21px 70px;
            clear: both;
        }

        .timeline .panel::before {
            position: absolute;
            display: block;
            top: 8px;
            left: -24px;
            content: '';
            width: 0px;
            height: 0px;
            border: inherit;
            border-width: 12px;
            border-top-color: transparent;
            border-bottom-color: transparent;
            border-left-color: transparent;
        }

        .timeline .panel .panel-heading.icon * {
            font-size: 20px;
            vertical-align: middle;
            line-height: 40px;
        }

        .timeline .panel .panel-heading.icon {
            position: absolute;
            left: -59px;
            display: block;
            width: 40px;
            height: 40px;
            padding: 0px;
            border-radius: 50%;
            text-align: center;
            float: left;
        }

        .timeline .panel-outline {
            border-color: transparent;
            background: transparent;
            box-shadow: none;
        }

        .timeline .panel-outline .panel-body {
            padding: 10px 0px;
        }

        .timeline .panel-outline .panel-heading:not(.icon),
        .timeline .panel-outline .panel-footer {
            display: none;
        }
    </style>
@endsection


@section('content')
    <div id="loader"></div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card bg-light2 mb-3 ">

                    <div class="card-header card-header-custom" style="background-color: #fff;">
                        <div class="div_center avatar mx-auto white">
                            <img class="rounded-circle img-responsive bg-white p-3 image"
                                style="margin-top: 300px; border:solid #eeeded 1px ;"
                                src="{{ asset('images/infinite.jpg') }}" alt="..." height="200">
                        </div>
                    </div>


                    <div class="card-body">
                        <br>
                        <div>
                            <br><br><br>
                            <h3 class="card-title"><i class="fa fa-graduation-cap"></i> Student Information</h3>
                        </div>
                        <div style="float: right"><a href="{{ route('parent.logout') }}"><i class="fa fa-power-off"></i>
                                ออกจากระบบ</a></div>
                        <br>

                        <div class="row">

                            <div class="col-md-12 div_center">


                                <div class="row mb-3 ">
                                    <label for="success" class="col-md-4 col-form-label text-md-end"></label>

                                    <div class="col-md-6">

                                        @if ($message = Session::get('success'))
                                            <div class="alert alert-success">
                                                <p>{{ $message }}</p>
                                            </div>
                                        @endif

                                        @if ($errors->any())
                                            <div class="alert alert-danger">
                                                <p>{{ $errors->first() }}</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12">
                                <div class="card card-primary card-outline card-tabs">
                                    <div class="card-header p-0 pt-1 border-bottom-0">
                                        <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">

                                            <li class="nav-item">
                                                <a class="nav-link active" id="custom-tabs-three-profile-tab"
                                                    data-toggle="pill" href="#custom-tabs-three-profile" role="tab"
                                                    aria-controls="custom-tabs-three-profile" aria-selected="false"><i
                                                        class="fa fa-user-circle"></i> นักเรียน</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link " id="custom-tabs-three-home-tab" data-toggle="pill"
                                                    href="#custom-tabs-three-home" role="tab"
                                                    aria-controls="custom-tabs-three-home" aria-selected="true"><i
                                                        class="fa fa-users"></i> ผู้ปกครอง</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="custom-tabs-three-messages-tab" data-toggle="pill"
                                                    href="#custom-tabs-three-messages" role="tab"
                                                    aria-controls="custom-tabs-three-messages" aria-selected="false"> <i
                                                        class="fa fa-list-alt"></i> รายวิชาที่เรียน </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="custom-tabs-three-histories-tab" data-toggle="pill"
                                                    href="#custom-tabs-three-histories" role="tab"
                                                    aria-controls="custom-tabs-three-histories" aria-selected="false"> <i
                                                        class="fa fa-list-alt"></i> ประวัติการเข้าเรียน </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="custom-tabs-three-settings-tab" data-toggle="pill"
                                                    href="#custom-tabs-three-settings" role="tab"
                                                    aria-controls="custom-tabs-three-settings" aria-selected="false"> <i
                                                        class="fa fa-comments"></i> Comment
                                                    อาจารย์</a>
                                            </li>

                                            <li class="nav-item">
                                                <a class="nav-link " id="custom-tabs-three-promotion-tab" data-toggle="pill"
                                                    href="#custom-tabs-three-promotion" role="tab"
                                                    aria-controls="custom-tabs-three-promotion" aria-selected="true"><i
                                                        class="fa fa-envelope "></i> โปรโมชั่น</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link " id="custom-tabs-three-holiday-tab" data-toggle="pill"
                                                    href="#custom-tabs-three-holiday" role="tab"
                                                    aria-controls="custom-tabs-three-holiday" aria-selected="true"><i
                                                        class="fa fa-calendar"></i> วันหยุดโรงเรียน</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="card-body">
                                        <div class="tab-content" id="custom-tabs-three-tabContent">
                                            <div class="tab-pane fade " id="custom-tabs-three-home" role="tabpanel"
                                                aria-labelledby="custom-tabs-three-home-tab">
                                                <form method="POST" action="{{ route('parent.saveparent') }}">
                                                    @csrf
                                                    {!! $parent_html !!}

                                                </form>

                                            </div>




                                            <div class="tab-pane fade show active" id="custom-tabs-three-profile"
                                                role="tabpanel" aria-labelledby="custom-tabs-three-profile-tab">
                                                <form method="POST" action="{{ route('parent.save') }}">
                                                    @csrf
                                                    {!! $student_html !!}
                                                </form>
                                            </div>
                                            <div class="tab-pane fade" id="custom-tabs-three-messages" role="tabpanel"
                                                aria-labelledby="custom-tabs-three-messages-tab">
                                                {{-- @php
                                                var_dump($student_chart);
                                                @endphp  --}}

                                                @foreach ($student_chart as $chart_key)
                                                    <div>
                                                        <b> วิชาที่เรียน: ( {{ $chart_key['course'][0]->student_subject }} )
                                                        </b>
                                                        <b> รหัสนักเรียน: ( {{ $chart_key['course'][0]->student_code }} )
                                                        </b> <b>ชื่อเล่น:</b>
                                                        ({{ $chart_key['course'][0]->student_nickname }})
                                                        <b>ระดับชั้น:</b> ( {{ $chart_key['course'][0]->student_grade }}
                                                        ) <b>
                                                            Book Start:</b> ( {{ $chart_key['course'][0]->book_start }} )
                                                    </div>
                                                    <table style="width: 100%;" id="Listview"
                                                        class="table table-striped table-bordered responsive-utilities jambo_table bulk_action">
                                                        <thead>
                                                            <tr>
                                                                <th>School Grade</th>
                                                                <th class="text-center">Level</th>
                                                                <th colspan="12" class="text-center">(
                                                                    {{ $chart_key['course'][0]->student_grade }} )
                                                                </th>

                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            {{-- @php
                                                        var_dump($chart_key['course']);
                                                        @endphp   --}}
                                                            {!! $chart_key['html'] !!}


                                                        </tbody>

                                                        <tfoot>
                                                            <tr>
                                                                <td colspan="2" align="center">Year</td>
                                                                @for ($i = $chart_key['year']; $i <= $chart_key['last_year']; $i++)
                                                                    <td align="center"
                                                                        colspan="{{ $chart_key['year_span'][$i] }}">
                                                                        {{ $i }}</td>
                                                                @endfor

                                                            </tr>
                                                            <tr>
                                                                <td colspan="2" align="center">Month</td>

                                                                @foreach ($chart_key['months'] as $mkey)
                                                                    <td align="center">{{ $mkey }}</td>
                                                                @endforeach
                                                            </tr>
                                                        </tfoot>

                                                    </table>
                                                    <br><br><br>
                                                @endforeach


                                            </div>
                                            <div class="tab-pane fade " id="custom-tabs-three-histories" role="tabpanel"
                                                aria-labelledby="custom-tabs-three-histories-tab">

                                                {!! $histories_html !!}

                                            </div>
                                            <div class="tab-pane fade " id="custom-tabs-three-settings" role="tabpanel"
                                                aria-labelledby="custom-tabs-three-settings-tab">

                                                {!! $comment_html !!}

                                            </div>
                                            <!-- <div class="tab-pane fade" id="custom-tabs-three-settings" role="tabpanel"
                                                    aria-labelledby="custom-tabs-three-settings-tab">
                                                    <div class="timeline">

                                                        <div class="time-label">
                                                            <span class="bg-green">10 Feb. 2023</span>
                                                        </div>


                                                        <div>
                                                            <i class="fas fa-envelope bg-blue"></i>
                                                            <div class="timeline-item">
                                                                <span class="time"><i class="fas fa-clock"></i> 12:05</span>
                                                                <h3 class="timeline-header"><a href="#">ครู ป้อ</a>
                                                                    {{-- sent you an email --}}</h3>
                                                                <div class="timeline-body">
                                                                    เข้าใจเนื้อหาได้ดี
                                                                </div>

                                                            </div>
                                                        </div>







                                                        <div>
                                                            <i class="fas fa-comments bg-yellow"></i>
                                                            <div class="timeline-item">
                                                                <span class="time"><i class="fas fa-clock"></i> 27 mins
                                                                    ago</span>
                                                                <h3 class="timeline-header"><a href="#">ครู ป้อ</a>
                                                                    </h3>
                                                                <div class="timeline-body">
                                                                   มีความร่าเริง สนใจเนื้อหาที่เรียน
                                                                </div>

                                                            </div>
                                                        </div>


                                                        <div class="time-label">
                                                            <span class="bg-green">3 Jan. 2023</span>
                                                        </div>


                                                        <div>
                                                            <i class="fa fa-camera bg-purple"></i>
                                                            <div class="timeline-item">
                                                                <span class="time"><i class="fas fa-clock"></i> 2 days
                                                                    ago</span>
                                                                <h3 class="timeline-header"><a href="#">ครู ป้อ</a>
                                                                    รูปน้องตอนเรียน</h3>
                                                                <div class="timeline-body">
                                                                    <img src="https://placehold.it/150x100" alt="...">
                                                                    <img src="https://placehold.it/150x100" alt="...">
                                                                    <img src="https://placehold.it/150x100" alt="...">
                                                                    <img src="https://placehold.it/150x100" alt="...">
                                                                    <img src="https://placehold.it/150x100" alt="...">
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <div>
                                                            <i class="fas fa-video bg-maroon"></i>
                                                            <div class="timeline-item">
                                                                <span class="time"><i class="fas fa-clock"></i> 5 days
                                                                    ago</span>
                                                                <h3 class="timeline-header"><a href="#">ครู ป้อ</a>
                                                                    วิดีโอน้องตอนเรียน</h3>
                                                                <div class="timeline-body">
                                                                    <div class="embed-responsive embed-responsive-16by9">
                                                                        <iframe class="embed-responsive-item"
                                                                            src="https://www.youtube.com/embed/tMWkeBIohBs"
                                                                            allowfullscreen></iframe>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> -->
                                            <div class="tab-pane fade div_center" id="custom-tabs-three-promotion"
                                                role="tabpanel" aria-labelledby="custom-tabs-three-promotion-tab">
                                                <img src="{{ asset('images/promotion1.jpg') }}" width="90%">
                                                <img src="{{ asset('images/promotion2.jpg') }}" width="90%">
                                                {{-- <img src="{{ asset('images/promotion3.png') }}" width="90%">
                                                <img src="{{ asset('images/promotion4.png') }}" width="90%"> --}}
                                            </div>
                                            <div class="tab-pane fade " id="custom-tabs-three-holiday" role="tabpanel"
                                                aria-labelledby="custom-tabs-three-holiday-tab">

                                                <div class="timeline">

                                                    <div class="time-label">
                                                        <span class="bg-green">1 มกราคม 2566</span>
                                                    </div>


                                                    <div>
                                                        <i class="fas fa-calendar bg-green"></i>
                                                        <div class="timeline-item">
                                                            {{-- <span class="time"><i class="fas fa-clock"></i> 5 mins
                                                                ago</span> --}}
                                                            <h3 class="timeline-header no-border"> วันขึ้นปีใหม่</h3>
                                                        </div>
                                                    </div>

                                                    <div class="time-label">
                                                        <span class="bg-yellow">2 มกราคม 2566</span>
                                                    </div>


                                                    <div>
                                                        <i class="fas fa-calendar bg-yellow"></i>
                                                        <div class="timeline-item">
                                                            {{-- <span class="time"><i class="fas fa-clock"></i> 5 mins
                                                                ago</span> --}}
                                                            <h3 class="timeline-header no-border"> วันหยุดชดเชย
                                                                วันขึ้นปีใหม่</h3>
                                                        </div>
                                                    </div>

                                                    <div class="time-label">
                                                        <span class="bg-green">6 มีนาคม 2566</span>
                                                    </div>


                                                    <div>
                                                        <i class="fas fa-calendar bg-green"></i>
                                                        <div class="timeline-item">
                                                            {{-- <span class="time"><i class="fas fa-clock"></i> 5 mins
                                                                ago</span> --}}
                                                            <h3 class="timeline-header no-border"> วันมาฆะบูชา</h3>
                                                        </div>
                                                    </div>

                                                    <div class="time-label">
                                                        <span class="bg-yellow">13-14 เมษายน 2566</span>
                                                    </div>


                                                    <div>
                                                        <i class="fas fa-calendar bg-yellow"></i>
                                                        <div class="timeline-item">
                                                            {{-- <span class="time"><i class="fas fa-clock"></i> 5 mins
                                                                ago</span> --}}
                                                            <h3 class="timeline-header no-border"> วันสงกรานต์</h3>
                                                        </div>
                                                    </div>



                                                    <div class="time-label">
                                                        <span class="bg-green">1 พฤษภาคม 2566</span>
                                                    </div>


                                                    <div>
                                                        <i class="fas fa-calendar bg-green"></i>
                                                        <div class="timeline-item">
                                                            {{-- <span class="time"><i class="fas fa-clock"></i> 5 mins
                                                                ago</span> --}}
                                                            <h3 class="timeline-header no-border"> วันแรงงาน</h3>
                                                        </div>
                                                    </div>

                                                    <div class="time-label">
                                                        <span class="bg-yellow">5 มิถุนายน 2566</span>
                                                    </div>


                                                    <div>
                                                        <i class="fas fa-calendar bg-yellow"></i>
                                                        <div class="timeline-item">
                                                            {{-- <span class="time"><i class="fas fa-clock"></i> 5 mins
                                                                ago</span> --}}
                                                            <h3 class="timeline-header no-border"> วันวิสาขบูชา</h3>
                                                        </div>
                                                    </div>


                                                    <div class="time-label">
                                                        <span class="bg-green">28 กรกฎาคม 2566</span>
                                                    </div>


                                                    <div>
                                                        <i class="fas fa-calendar bg-green"></i>
                                                        <div class="timeline-item">
                                                            {{-- <span class="time"><i class="fas fa-clock"></i> 5 mins
                                                                ago</span> --}}
                                                            <h3 class="timeline-header no-border"> วันเฉลิมพระชนมพรรษา
                                                                พระบาทสมเด็จพระปรเมนทรรามาธิบดีศรีสินทรมหาวชิราลงกรณ
                                                                พระวชิรเกล้าเจ้าอยู่หัว</h3>
                                                        </div>
                                                    </div>

                                                    <div class="time-label">
                                                        <span class="bg-yellow">12 สิงหาคม 2566</span>
                                                    </div>


                                                    <div>
                                                        <i class="fas fa-calendar bg-yellow"></i>
                                                        <div class="timeline-item">
                                                            {{-- <span class="time"><i class="fas fa-clock"></i> 5 mins
                                                                ago</span> --}}
                                                            <h3 class="timeline-header no-border"> วันแม่แห่งชาติ</h3>
                                                        </div>
                                                    </div>

                                                    <div class="time-label">
                                                        <span class="bg-green">13 ตุลาคม 2566</span>
                                                    </div>


                                                    <div>
                                                        <i class="fas fa-calendar bg-green"></i>
                                                        <div class="timeline-item">
                                                            {{-- <span class="time"><i class="fas fa-clock"></i> 5 mins
                                                                ago</span> --}}
                                                            <h3 class="timeline-header no-border"> วันคล้ายวันสวรรคต
                                                                พระบาทสมเด็จพระบรมชนกาธิเบศร มหาภูมิพลอดุลยเดชมหาราช
                                                                บรมนาถบพิตร</h3>
                                                        </div>
                                                    </div>

                                                    <div class="time-label">
                                                        <span class="bg-yellow">23 ตุลาคม 2566</span>
                                                    </div>


                                                    <div>
                                                        <i class="fas fa-calendar bg-yellow"></i>
                                                        <div class="timeline-item">
                                                            {{-- <span class="time"><i class="fas fa-clock"></i> 5 mins
                                                                ago</span> --}}
                                                            <h3 class="timeline-header no-border"> วันปิยะมหาราช</h3>
                                                        </div>
                                                    </div>

                                                    <div class="time-label">
                                                        <span class="bg-green">30-31 ธันวาคม 2566</span>
                                                    </div>


                                                    <div>
                                                        <i class="fas fa-calendar bg-green"></i>
                                                        <div class="timeline-item">
                                                            {{-- <span class="time"><i class="fas fa-clock"></i> 5 mins
                                                                ago</span> --}}
                                                            <h3 class="timeline-header no-border"> วันสิ้นปี</h3>
                                                        </div>
                                                    </div>


                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                            <div class="card-footer text-center" style="background-color: #fff">
                                Copyright © 2022 metaknowledge.co.th All rights reserved.
                            </div>
                        </div>


                    </div>
                </div>
            </div>
            <script>
                $(document).ready(function() {
                    $(".AddDate").datepicker({
                        dateFormat: "yy-mm-dd"
                    });
                    $(".nav-tabs a").click(function() {
                        $(this).tab('show');
                    });




                });
            </script>
            <script type="text/javascript">
                const warningTitleCSS = 'color:red; font-size:60px; font-weight: bold; -webkit-text-stroke: 1px black;';
                const warningDescCSS = 'font-size: 18px;';

                console.log('%cหยุด!', warningTitleCSS);
                console.log(
                    "%cนี่เป็นคุณสมบัติการทำงานของเบราว์เซอร์ที่มีจุดมุ่งหมายให้ใช้สำหรับผู้พัฒนา หากผู้ใดบอกให้คุณคัดลอกแล้ววางข้อความบางอย่างที่นี่เพื่อเปิดใช้งานคุณสมบัติการทำงานของ ระบบ หรือเพื่อเข้าถึงบัญชีของบุคคลใดบุคคลหนึ่ง โดยมิชอบ คำบอกกล่าวเช่นนี้เป็นกลลวงและจะทำให้ผู้นั้นมีสิทธิ์เข้าถึงบัญชี ของคุณ",
                    warningDescCSS);
                //console.log('%cSee https://www.facebook.com/selfxss for more information.', warningDescCSS);
            </script>
        @endsection
