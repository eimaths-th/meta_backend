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
    </style>
    <style>
      @media print {
        @page {
          size: landscape;
        }
      }
    </style>
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
            <table align="center" width="70%" cellpadding="0" cellspacing="0">
              <tr class="active" height="30">
                <td align="center" width="10%" class="active_left grey"></td>
                <td align="center" width="80%" colspan="5">
                  <font class="grey">Record Time META Knowledge </font>
                  {{ $year }}

                  <b> </b>
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

            <table align="center" width="70%" cellpadding="0" cellspacing="0">
              {{-- <thead> --}}
              <tr class="activebg" height="30">
                <td class="actived grey" align="center">No.</td>
                <td class="actived grey" align="center">Code</td>
                <td class="actived" align="center">
                  <font class="grey">Name</font>
                </td>
                <td class="actived grey" align="center">รายการ</td>
                <td class="actived grey" align="center">ทั้งหมด</td>
                <td class="actived grey" align="center">ลา</td>
                <td class="activedr grey" align="center">คงเหลือ</td>

                {{-- @foreach ($stwork as $status)
                                <td class="actived" align="center">
                                    {{ $status->name }}
                                </td>
                            @endforeach --}}
              </tr>
              {{-- </thead> --}}

              {{-- <tbody> --}}
              @php
                $loops = 1;
                $result = 0;
              @endphp
              @foreach ($stwork as $status)
                @if ($status->id == 2 ||
                  $status->id == 3 ||
                  $status->id == 4 ||
                  $status->id == 13)
                  <tr class="activeda" height="15">
                    <td class="actived" align="center">{{ $loops }}</td>
                    <td class="actived grey" align="center">
                      INF{{
                        $recTap4->first()->user
                          ->code
                      }}
                    </td>
                    <td class="actived">
                      <font class="grey"
                        >&nbsp; {{
                          $recTap4->first()->user
                            ->name
                        }}</font
                      >
                    </td>
                    <td class="actived" align="center">
                      @php
                        if ($status->name == 'ขาดงาน') {
                          # code...
                          $nameStatus = 'ไม่ได้ลางาน';
                        } else {
                          $nameStatus = $status->name;
                        }
                      @endphp
                      {{ $nameStatus }}
                    </td>
                    <td class="actived" align="center">
                      @php
                        $all = 0;
                        if ($status->id == 2) {
                          # code...
                          $all = 30;
                          $use = $recTap4->where('status', $status->id)->count();
                        } elseif ($status->id == 3) {
                          # code...
                          $all = 6;
                          $use = $recTap4->where('status', $status->id)->count();
                        } elseif ($status->id == 4) {
                          # code...
                          $all = 3;
                          $use = $recTap4->where('status', $status->id)->count();
                        } else {
                          # code...
                          $all = $recTap4->where('status', $status->id)->count();
                          $use = $recTap4->where('status', $status->id)->count();
                        }
                      @endphp
                      {{ $all }}
                    </td>
                    <td class="actived" align="center">
                      {{-- @php

                                            $use = $recTap4->where('status', $status->id)->count();

                                        @endphp --}}
                      @if ($status->id == 5 || $status->id == 13)
                        {{ $all - $use }}
                      @else
                        {{ $use }}
                      @endif
                    </td>
                    <td class="activedr grey" align="center">
                      {{ $all - $use }}
                    </td>
                  </tr>
                  @php
                    $loops++;
                  @endphp
                @else
                @endif
              @endforeach

              <tr class="activeda" height="15">
                <td align="center" width="5%" class="activeda"></td>
                <td align="center" width="15%" class="activeda"></td>
                <td align="left" class="activeda">&nbsp;</td>
                <td align="center" class="activeda"></td>
                <td width="10%" align="center" class="activeda"></td>
                <td width="10%" align="center" class="activeda"></td>

                <td width="10%" align="center" class="activeda"></td>
              </tr>
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

            <table align="center" width="70%" cellpadding="0" cellspacing="0">
              <tr class="active" height="30">
                <td align="center" width="10%" class="active_left grey"></td>
                <td align="center" width="80%" colspan="5">
                  <font class="grey">Record Time META Knowledge </font>
                  {{ $year }}

                  <b> </b>
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

            <table align="center" width="70%" cellpadding="0" cellspacing="0">
              <tr class="activebg" height="30">
                <td class="actived grey" align="center">No.</td>
                <td class="actived grey" align="center">Code</td>
                <td class="actived" align="center">
                  <font class="grey">Name</font>
                </td>
                <td class="actived grey" align="center">รายการ</td>
                <td class="actived grey" align="center">วัน</td>
                <td class="actived grey" align="center">นาที</td>
                <td class="activedr grey" align="center">เฉลี่ย</td>

                {{-- @foreach ($stwork as $status)
                                <td class="actived" align="center">
                                    {{ $status->name }}
                                </td>
                            @endforeach --}}
              </tr>
              @php
                $result = 0;
              @endphp
              @foreach ($stwork as $status)
                @if ($status->id == 5)
                  <tr class="activeda" height="15">
                    <td class="actived" align="center">{{ $loops }}</td>
                    <td class="actived grey" align="center">
                      INF{{
                        $recTap4->first()->user
                          ->code
                      }}
                    </td>
                    <td class="actived">
                      <font class="grey"
                        >&nbsp; {{
                          $recTap4->first()->user
                            ->name
                        }}</font
                      >
                    </td>
                    <td class="actived" align="center">
                      @php
                        if ($status->name == 'ขาดงาน') {
                          # code...
                          $nameStatus = 'ไม่ได้ลางาน';
                        } else {
                          $nameStatus = $status->name;
                        }
                      @endphp
                      {{ $nameStatus }}
                    </td>
                    <td class="actived" align="center">
                      @php
                        $all = 0;

                        $use = $recTap4->where('status', $status->id)->count();

                        $all = $recTap4->where('status', $status->id)->count();
                        $late = $recTap4->where('status', 5)->sum('late_time');
                        $average = $late / $all; // Calculate average in hours
                        $hours = floor($average); // Get the whole hours
                        $minutes = ($average - $hours) * 60; // Convert the decimal part to minutes

                        $formattedAverage = $hours . '.' . round($minutes); // Format as hours.minutes
                      @endphp
                      {{ $all }}
                    </td>
                    <td class="activedr" align="center">
                      {{-- @php

                                            $use = $recTap4->where('status', $status->id)->count();

                                        @endphp --}}
                      {{
                        number_format(
                          $late,
                        )
                      }}
                    </td>
                    <td class="activedr grey" align="center">
                      {{ $formattedAverage }}
                    </td>
                  </tr>
                  @php
                    $loops++;
                  @endphp
                @else
                @endif
              @endforeach

              <tr class="activeda" height="15">
                <td align="center" width="5%" class="activeda"></td>
                <td align="center" width="15%" class="activeda"></td>
                <td align="left" class="activeda">&nbsp;</td>
                <td align="center" class="activeda"></td>
                <td width="10%" align="center" class="activeda"></td>
                <td width="10%" align="center" class="activeda"></td>
                {{-- @foreach ($stwork as $status)
                                <td align="center" class="activeda">

                                </td>
                            @endforeach --}}
                <td width="10%" align="center" class="activeda"></td>
              </tr>
            </table>

            <br /><br /><br />

            <table align="center" width="98%" cellpadding="0" cellspacing="0">
              <tr>
                <td></td>
                <td></td>
                <td align="center">
                  ลงชื่อ...................................
                </td>
              </tr>
              <tr>
                <td></td>
                <td></td>
                <td align="center">ผู้จัดการ</td>
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
</html>
