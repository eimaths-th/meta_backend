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
                  <font class="grey">Record Time META Knowledge </font> <b> </b>
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
                <td class="actived grey" align="center">Date</td>
                <td class="actived" align="center">
                  <font class="grey">Late All</font>
                </td>
                <td class="actived" align="center">
                  <font class="grey"> Missing Work All </font>
                </td>
                <td align="center" class="grey activedr">Updated At</td>
                {{-- <td class="actived" align="center">
                                <font class="grey">Status</font>
                            </td>
                            <td align="center" class="activedr gray">Detail</td> --}}
              </tr>
              {{-- </thead> --}}

              {{-- <tbody> --}}
              @foreach ($overlates as $key => $overlate)
                <tr class="activeda" height="15">
                  <td align="center" class="actived">
                    <b>
                      <font size="{{ $fontsize }}"> {{ $key + 1 }} </font>
                    </b>
                  </td>
                  <td align="center" class="actived">
                    <b>
                      <font size="{{ $fontsize }}">
                        {{ $overlate->month ?? 'null' }}-{{ $overlate->year ?? 'null' }}
                      </font>
                    </b>
                  </td>
                  <td align="center" class="actived">
                    &nbsp;
                    <b>
                      <font size="{{ $fontsize }}">
                        {{
                          $overlate->late_time_all ??
                            '0'
                        }} นาที
                      </font>
                    </b>
                  </td>
                  <td align="center" class="actived">
                    <b>
                      <font size="{{ $fontsize }}">
                        {{
                          $overlate->missing_work_all ??
                            '0'
                        }} วัน
                      </font>
                    </b>
                  </td>
                  <td align="center" class="activedr">
                    <b>
                      <font size="{{ $fontsize }}">
                        {{
                          $overlate->updated_at ??
                            'null'
                        }}
                      </font>
                    </b>
                  </td>
                </tr>
              @endforeach
              <tr class="activeda" height="15">
                <td align="center" width="5%" class="activeda"></td>
                <td align="center" width="15%" class="activeda"></td>
                <td align="left" width="30%" class="activeda">&nbsp;</td>
                <td align="center" width="30%" class="activeda"></td>
                <td align="center" width="20%" class="activeda"></td>
                {{-- <td align="center" class="activeda ">

                            </td>
                            <td align="center" class="activeda">

                            </td> --}}
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
