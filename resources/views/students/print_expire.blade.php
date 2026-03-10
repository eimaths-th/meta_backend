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
                  <font class="grey"
                    >RESULT EXPIRE STUDENT
                    @if ($selectGroup)
                      GROUP {{ $selectGroup }}
                    @else
                    @endif
                  </font>

                  {{ $currentMonthf }} - {{ $currentYear }}
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
                <td class="actived grey" align="center">ระยะเวลา</td>
                <td class="actived grey" align="center">Code</td>
                <td class="actived" align="center">
                  <font class="grey">ชื่อนักเรียน</font>
                </td>
                <td class="actived" align="center">
                  <font class="grey">ชื่อ ผู้ปกครอง</font>
                </td>
                <td align="center" class="grey actived">เบอร์</td>
                {{-- <td class="actived" align="activedr gray" >
                                    <font class="grey">Group</font>
                                </td> --}}
                <td align="center" class="activedr gray">Group</td>
              </tr>
              {{-- </thead> --}}

              {{-- <tbody> --}}
              @foreach ($StudentExpireCurrentMonth as $key => $list)
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
                      <font size="{{ $fontsize }}"> {{ $list->period }} </font>
                    </b>
                  </td>
                  <td align="center" class="actived">
                    <b>
                      <font size="{{ $fontsize }}">
                        {{
                          $list->std
                            ->code
                        }}
                      </font>
                    </b>
                  </td>
                  <td align="left" class="actived">
                    &nbsp;
                    <b>
                      <font size="{{ $fontsize }}"
                        >{{ $list->std->full_name }} ({{ $list->std->nick_name }})
                      </font>
                    </b>
                  </td>
                  <td align="center" class="actived">
                    <b>
                      <font size="{{ $fontsize }}">
                        {{
                          $list->std->parent
                            ->name_parent
                        }}
                      </font>
                    </b>
                  </td>
                  <td align="center" class="actived">
                    <b>
                      <font size="{{ $fontsize }}">
                        {{
                          $list->std->parent
                            ->mobile
                        }}
                      </font>
                    </b>
                  </td>
                  <td align="center" class="activedr grey">
                    <b>
                      <font size="{{ $fontsize }}"> {{ $list->group }} </font>
                    </b>
                  </td>
                  {{-- <td align="center" class="activedr grey">
                                        <b>
                                            <font size="{{ $fontsize }}">
                                                {{ $list->status }}
                                            </font>
                                        </b>
                                    </td> --}}
                </tr>
              @endforeach
              <tr class="activeda" height="15">
                <td align="center" width="1%" class="activeda"></td>
                <td align="center" class="activeda"></td>
                <td align="left" class="activeda">&nbsp;</td>
                <td align="center" class="activeda"></td>
                <td align="center" class="activeda"></td>
                <td align="center" class="activeda"></td>
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
