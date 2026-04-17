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
            <table align="center" width="98%" cellpadding="0" cellspacing="0">
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

            <table align="center" width="98%" cellpadding="0" cellspacing="0">
              {{-- <thead> --}}
              <tr class="activebg" height="30">
                <td class="actived grey" align="center">No.</td>
                <td class="actived grey" align="center">Code</td>
                <td class="actived" align="center">
                  <font class="grey">Name</font>
                </td>
                @foreach ($stwork as $status)
                  <td class="actived" align="center">{{ $status->name }}</td>
                @endforeach
                <td align="center" class="activedr gray">Late Time</td>
              </tr>
              {{-- </thead> --}}

              {{-- <tbody> --}}
              @php
                $loops = 1;
                $result = 0;
              @endphp
              @foreach ($rec_times_year as $user_id => $records)
                @php
                @endphp
                <tr class="activeda" height="15">
                  <td align="center" class="actived">
                    <b>
                      <font size="{{ $fontsize }}">
                        {{ $loop->iteration }}
                      </font>
                    </b>
                  </td>
                  <td align="center" class="actived">
                    <b>
                      <font size="{{ $fontsize }}">
                        INF{{
                          $records->first()->user->code ??
                            'code'
                        }}
                      </font>
                    </b>
                  </td>
                  <td align="left" class="actived">
                    &nbsp;
                    <b>
                      <font size="{{ $fontsize }}"
                        >{{
                          $records->first()->user->name ??
                            '404 not fond'
                        }}
                      </font>
                    </b>
                  </td>
                  @foreach ($stwork as $status)
                    <td align="center" class="actived">
                      <b>
                        <font size="{{ $fontsize }}">
                          {{-- <a href="{{ route('find_UserRecTime', ['user_id' => $records->first()->user->id, 'status' => $status->id, 'month' => $month, 'year' => $year]) }}"
                                                    class="text-dark"> --}}
                          @php
                            $statusName = $status->name;
                            $statusCount = $records->where('status_name', $status->name)->count();
                            $text = '';

                            if ($status->name === 'ลากิจ') {
                              # code...
                              $remain = 3;
                            } elseif ($status->name === 'ลาป่วย') {
                              # code...
                              $remain = 30;
                            } elseif ($status->name === 'ลาพักร้อน') {
                              # code...
                              $remain = 6;
                            }
                            if (
                              $status->name === 'ลากิจ' ||
                              $status->name === 'ลาป่วย' ||
                              $status->name === 'ลาพักร้อน'
                            ) {
                              # code...
                              $text = 'remain : ' . $remain - $statusCount ?? '';
                            }
                          @endphp
                          {{ $statusCount }}

                          {{ $text }}

                          {{-- </a> --}}
                        </font>
                      </b>
                    </td>
                  @endforeach

                  <td align="center" class="activedr grey">
                    <b>
                      <font size="{{ $fontsize }}">
                        @php
                          $statuslate = $records->where('status', 5)->sum('late_time');
                          $result += $statuslate;
                          $loops++;
                        @endphp
                        {{ $statuslate ?? '0' }} นาที
                      </font>
                    </b>
                  </td>
                </tr>
              @endforeach
              <tr class="activeda" height="15">
                <td align="center" class="actived">
                  <b>
                    <font size="{{ $fontsize }}"> # </font>
                  </b>
                </td>

                @php
                  $count_line = 0;
                @endphp
                @foreach ($stwork as $status)
                  @php
                    $count_line++;
                  @endphp
                @endforeach

                @php
                  $colspan = 2 + $count_line;
                @endphp

                <td colspan="{{ $colspan }}" align="center" class="actived">
                  <b>
                    <font size="{{ $fontsize }}"> รวม </font>
                  </b>
                </td>

                <td align="center" class="activedr">
                  <b>
                    <font size="{{ $fontsize }}"> {{ $result }} นาที </font>
                  </b>
                </td>
              </tr>
              <tr class="activeda" height="15">
                <td align="center" width="1%" class="activeda"></td>
                <td align="center" width="1%" class="activeda"></td>
                <td align="left" class="activeda">&nbsp;</td>
                @foreach ($stwork as $status)
                  <td align="center" class="activeda"></td>
                @endforeach
                <td align="center" class="activeda"></td>
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
