<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <style>
      table td.grey {
        color: rgb(141, 138, 138);
      }

      font.grey {
        color: rgb(141, 138, 138);
      }

      .tbr table tr.active td {
        border-top: 2px solid rgb(138, 175, 61);
        border-bottom: 2px solid rgb(138, 175, 61);
      }

      .tbr table tr.activebg td {
        background: #c9fcb9;
      }

      .tbr table tr.actived td {
        border-bottom: 1px solid rgb(7, 7, 7);
      }

      .tbr table tr.activeda td {
        /* border-bottom: 1px solid rgb(7, 7, 7); */
        border-top: 1px solid rgb(7, 7, 7);
      }

      .tbr table tr.activedab td {
        border-bottom: 1px solid rgb(7, 7, 7);
        border-top: 1px solid rgb(7, 7, 7);
      }

      .tbr table td.activetop {
        border-top: 2px solid rgb(138, 175, 61);
      }

      .tbr table td.active {
        border-left: 2px solid rgb(138, 175, 61);
        border-right: 2px solid rgb(138, 175, 61);
      }

      .tbr table td.actived {
        border-left: 1px solid rgb(7, 7, 7);
        /* border-right: 1px solid rgb(7, 7, 7); */
      }

      .tbr table td.activedr {
        border-left: 1px solid rgb(7, 7, 7);
        border-right: 1px solid rgb(7, 7, 7);
      }

      .tbr table td.activedright {
        border-right: 1px solid rgb(7, 7, 7);
      }

      .tbr table td.active_left {
        border-left: 2px solid rgb(138, 175, 61);
      }

      .tbr table td.active_right {
        border-right: 2px solid rgb(138, 175, 61);
      }

      .tbr table td.activebottom {
        border-bottom: 2px solid rgb(138, 175, 61);
      }

      .tbr table td.activebottomd {
        border-bottom: 1px solid rgb(7, 7, 7);
      }

      .text-right {
        text-align: right;
      }

      .text-success {
        color: rgb(97, 240, 166) !important;
      }
      .text-danger {
        color: #d92550 !important;
      }
      .text-warning {
        color: #f8d821 !important;
      }
      .text-primary {
        color: #3f6ad8 !important;
      }
      .text-dark {
        color: rgb(22, 22, 22) !important;
      }
    </style>
    {{-- <style>
        @media print {
            @page {
                size: landscape;
            }
        }
    </style> --}}
  </head>

  <body>
    <div class="row">
      <div class="main-card card mb-3" id="x_content">
        <div class="card-body">
          <table align="center" width="98%" cellpadding="0" cellspacing="0">
            <thead>
              <tr>
                <td width="15%" rowspan="4">
                  <img
                    src="{{ asset('images/infinite.jpg') }}"
                    alt="..."
                    height="106"
                    style="padding-bottom: 5px"
                  />
                </td>
                <td>บริษัท อินฟินิท เบรน จำกัด (สำนักงานใหญ่)</td>
              </tr>
              <tr>
                <td>555/9 ม.1 ต.บางขนุน อ.บางกรวย จ.นนทบุรี 11130</td>
              </tr>
              <tr>
                <td>เลขประจำตัวผู้เสียภาษี: 0125563031038</td>
              </tr>
              <tr>
                <td>โทร 098 509 8554</td>
              </tr>
            </thead>
          </table>

          <div class="tbr">
            <table align="center" width="98%" cellpadding="0" cellspacing="0">
              <tr class="active" height="30">
                <td align="center" width="10%" class="active_left grey"></td>
                <td align="center" width="80%" colspan="5">
                  <font class="grey"> Record Time META Knowledge </font>
                  {{ $name }} {{
                    date(
                      'F-Y',
                      strtotime("$year-$month"),
                    )
                  }}<b> </b>
                </td>
                {{-- <td align="center" width="10%"><b></b></td>
                            <td align="center" width="10%">
                                <font class="grey"></font>
                            </td> --}}
                <td align="center" width="10%" class="active_right">
                  <b></b></b>
                </td>
              </tr>
            </table>

            <table align="center" width="98%" cellpadding="0" cellspacing="0">
              {{-- <thead> --}}
              <tr class="activebg" height="30">
                <td class="actived grey" align="center">No.</td>
                <td class="actived grey" align="center">Code</td>
                <td class="actived" align="center">
                  <font class="grey">Name</font>
                </td>
                <td class="actived" align="center">
                  <font class="grey"> Date </font>
                </td>
                <td align="center" class="grey actived">Time</td>
                <td class="actived" align="center">
                  <font class="grey">Status</font>
                </td>
                <td align="center" class="activedr gray">Detail</td>
              </tr>
              {{-- </thead> --}}

              {{-- <tbody> --}}
              @php
                $resul_late_time = 0;
                $resul_late = 0;
                $resul_missing = 0;
                $resul_notIn = 0;
                $resul_notOut = 0;
                $resul_leaveFirst = 0;
              @endphp
              @foreach ($rec_times as $key => $rec_time)
                @php
                @endphp
                <tr class="activeda" height="15">
                  <td align="center" class="actived">
                    <b>
                      <font size="{{ $fontsize }}"> {{ $key + 1 }} </font>
                    </b>
                  </td>
                  <td align="center" class="actived">
                    <b>
                      <font size="{{ $fontsize }}">
                        INF{{ $rec_time->user->code }}
                      </font>
                    </b>
                  </td>
                  <td align="left" class="actived">
                    &nbsp;
                    <b>
                      <font size="{{ $fontsize }}"
                        >{{
                          $rec_time->user
                            ->name
                        }}
                      </font>
                    </b>
                  </td>
                  <td align="center" class="actived">
                    <b>
                      <font size="{{ $fontsize }}">
                        {{
                          date(
                            'D d-M-Y',
                            strtotime($rec_time->date),
                          )
                        }}
                      </font>
                    </b>
                  </td>
                  <td align="center" class="actived">
                    <b>
                      <font size="{{ $fontsize }}">
                        {{ $rec_time->full_time }}
                      </font>
                    </b>
                  </td>
                  @php
                    $class = '';
                    switch ($rec_time->status) {
                      case 1:
                        $class = 'success';
                        break;

                      case 2:
                      case 3:
                      case 4:
                      case 13:
                        $class = 'danger';
                        break;

                      case 5:
                      case 6:
                      case 7:
                      case 8:
                      case 9:
                        $class = 'warning';
                        break;

                      case 11:
                      case 12:
                        $class = 'primary';
                        break;

                      case 10:
                        $class = 'dark';

                        break;

                      default:
                        break;
                    }
                  @endphp
                  <td align="center" class="actived">
                    <b>
                      <font size="{{ $fontsize }}">
                        <span class="text-{{ $class }} align-items-center">
                          {{ $rec_time->status_name }}</span
                        >
                      </font>
                    </b>
                  </td>
                  <td align="center" class="activedr grey">
                    <b>
                      <font size="{{ $fontsize }}">
                        @php
                          $text_late = '';
                          if ($rec_time->late_time) {
                            $text_late = '| สาย : ' . $rec_time->late_time . ' นาที';
                          }
                          $resul_late_time += $rec_time->late_time;

                          // $resul_missing = 0;
                        @endphp
                        {{ $rec_time->explain }} {{ $text_late }}
                      </font>
                    </b>
                  </td>
                </tr>
                @php
                  if ($rec_time->status == 5) {
                    # code...
                    $resul_late++;
                  }
                  if ($rec_time->status == 13) {
                    # code...
                    // $resul_late++;
                    $resul_missing++;
                  }
                  if ($rec_time->status == 6) {
                    # code...
                    // $resul_late++;
                    $resul_notIn++;
                  }
                  if ($rec_time->status == 7) {
                    # code...
                    // $resul_late++;
                    $resul_notOut++;
                  }
                  if ($rec_time->status == 9) {
                    # code...
                    // $resul_late++;
                    $resul_leaveFirst++;
                  }
                @endphp
              @endforeach

              {{-- <tr class="activeda" height="15">
                            <td align="center" width="1%" class="activeda">

                            </td>
                            <td align="center" width="1%" class="activeda">

                            </td>
                            <td align="left" class="activeda">&nbsp;

                            </td>
                            <td align="center" class="activeda">

                            </td>
                            <td align="center" class="activeda">

                            </td>
                            <td align="center" class="activeda ">

                            </td>
                            <td align="center" class="activeda">

                            </td>
                        </tr> --}}
              {{-- </tbody> --}}

              {{-- <tr class="activebg" height="25">
                            <td align="center" colspan="3" width="15%" class="actived activebottomd grey">
                                <font size="{{ $fontsize }}"><b>รวมทั้งสิ้น</b></font>
                            </td>
                            <td align="center" width="15%" class="actived activebottomd">
                                <font size="{{ $fontsize }}"><b></b></font>
                            </td>
                            <td align="center" width="15%" class="activedr activebottomd grey">
                                <font size="{{ $fontsize }}"><b>ชั่วโมง</b></font>
                            </td>
                        </tr> --}}
            </table>

            <table align="center" width="98%" cellpadding="0" cellspacing="0">
              <tr class="activedab" height="30">
                <td width="15%" class="actived" align="center">
                  ขาดงาน : {{ $resul_missing }} &nbsp;=
                </td>

                <td width="15%" align="left">ลาป่วย :</td>

                <td width="15%" align="left">ลากิจ :</td>
                <td width="15%" align="left">ลาพักร้อน :</td>
                <td align="right" width="15%">
                  สาย : {{ $resul_late }} ครั้ง &nbsp;=
                </td>
                <td align="left" width="15%" class="activedright">
                  &nbsp;
                  <span align="left">{{ $resul_late_time }}</span>
                  <span align="right">นาที</span>
                </td>
              </tr>
              <tr class="actived" align="left" height="30">
                {{-- <td>ไม่สแกนเข้า</td>
                            <td>ไม่สแกนออก</td>
                            <td>ออกก่อน</td>
                            <td>ลาครึ่งวัน</td>
                            <td>OT</td>
                            <td>ชดเชย</td> --}}

                <td width="15%" class="actived" align="center">
                  ไม่สแกนเข้า : {{ $resul_notIn }}
                </td>
                <td width="15%" align="left">
                  ไม่สแกนออก : {{ $resul_notOut }}
                </td>
                <td width="15%" align="left">
                  ออกก่อน : {{ $resul_leaveFirst }}
                </td>
                <td width="15%" align="left">ลาครึ่งวัน :</td>
                <td align="center" width="15%">OT :</td>
                <td align="left" width="15%" class="activedright">
                  &nbsp;&nbsp;ชดเชย :
                </td>
              </tr>
            </table>

            <br /><br /><br />

            <table align="center" width="98%" cellpadding="0" cellspacing="0">
              <tr>
                <td></td>
                <td></td>
                <td align="center">ลงชื่อ.. {{ auth()->user()->name }} ....</td>
                <td></td>
                <td></td>
                <td align="center">ลงชื่อ...............................</td>
                <td></td>
                <td></td>
                <td align="center">ลงชื่อ................................</td>
              </tr>
              <tr>
                <td></td>
                <td></td>
                <td align="center"></td>
                <td></td>
                <td></td>
                <td align="center">(....{{ $name }}....)</td>
                <td></td>
                <td></td>
                <td align="center"></td>
              </tr>
              <tr>
                <td></td>
                <td></td>
                <td align="center">ผู้ดำเนินการ</td>
                <td></td>
                <td></td>
                <td align="center">พนักงาน</td>
                <td></td>
                <td></td>
                <td align="center">ฝ่ายบัญชี</td>
              </tr>
            </table>
          </div>
        </div>
      </div>
  </body>

  <script>
    function printrep() {
      window.print();
    }
    printrep();
    setTimeout(function () {
      window.close();
    }, 4000);
  </script>
