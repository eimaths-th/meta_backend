<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    @if ($template === 'meta' || $template === 'meta2')
      <style>
        /* ------------------- */
        table td.grey {
          color: rgb(141, 138, 138);
        }

        font.grey {
          color: rgb(141, 138, 138);
        }

        .tbr table tr.active td {
          border-top: 2px solid rgb(255, 115, 0);
          border-bottom: 2px solid rgb(255, 115, 0);
        }

        .tbr table tr.activebg td {
          background: rgb(255, 180, 119);
        }

        .tbr table tr.actived td {
          border-bottom: 1px solid rgb(7, 7, 7);
        }

        .tbr table tr.activeda td {
          border-bottom: 1px solid rgb(7, 7, 7);
          border-top: 1px solid rgb(7, 7, 7);
        }

        .tbr table td.activetop {
          border-top: 2px solid rgb(255, 115, 0);
        }

        .tbr table td.active {
          border-left: 2px solid rgb(255, 115, 0);
          border-right: 2px solid rgb(255, 115, 0);
        }

        .tbr table td.actived {
          border-left: 1px solid rgb(7, 7, 7);
          border-right: 1px solid rgb(7, 7, 7);
        }

        .tbr table td.active_left {
          border-left: 2px solid rgb(255, 115, 0);
        }

        .tbr table td.active_right {
          border-right: 2px solid rgb(255, 115, 0);
        }

        .tbr table td.activebottom {
          border-bottom: 2px solid rgb(255, 115, 0);
        }

        .tbr table td.activebottomd {
          border-bottom: 1px solid rgb(7, 7, 7);
        }
      </style>
    @else
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
    @endif
  </head>

  <body>
    <div class="row">
      <div class="main-card card mb-3" id="x_content">
        <div class="card-body">
          <table align="center" width="90%" cellpadding="0" cellspacing="0">
            @if ($template === 'meta' || $template === 'meta2')
              @if ($metaCheck)
                <thead>
                  <tr>
                    <td width="15%" rowspan="4">
                      <img
                        src="{{ asset('images/logo_meta_2.png') }}"
                        alt="..."
                        height="106"
                        style="padding-bottom: 5px"
                      />
                    </td>
                    <td>บริษัท เมต้า2 โนวเลจ จำกัด (สำนักงานใหญ่)</td>
                  </tr>
                  <tr>
                    <td>555/9 ม.1 ต.บางขนุน อ.บางกรวย จ.นนทบุรี 11130</td>
                  </tr>
                  <tr>
                    <td>เลขประจำตัวผู้เสียภาษี: 0125567041160</td>
                  </tr>
                  <tr>
                    <td>โทร 093-358-6333</td>
                  </tr>
                </thead>
              @else
                <thead>
                  <tr>
                    <td width="15%" rowspan="4">
                      <img
                        src="{{ asset('images/logo_meta.png') }}"
                        alt="..."
                        height="106"
                        style="padding-bottom: 5px"
                      />
                    </td>
                    <td>META KNOWLEDGE CO., LTD.</td>
                  </tr>
                  <tr>
                    <td>555/9 ม.1 ต.บางขนุน อ.บางกรวย จ.นนทบุรี 11130</td>
                  </tr>
                  <tr>
                    <td>เลขประจำตัวผู้เสียภาษี: 0125565026368</td>
                  </tr>
                  <tr>
                    <td>โทร 093-358-6333</td>
                  </tr>
                </thead>
              @endif
            @else
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
                {{-- <tr>
                                <td>โทร 098 509 8554</td>
                            </tr> --}}
              </thead>
            @endif
          </table>

          <div class="tbr">
            <table align="center" width="90%" cellpadding="0" cellspacing="0">
              <tr class="active" height="30">
                <td align="center" width="15%" class="active_left grey"></td>
                <td align="center" width="40%">
                  <font class="grey">รายรับประจำเดือน </font>
                  <b>{{ $thaimonth }} {{ $thaiyear }} </b>
                </td>
                <td align="center" width="15%">
                  <b>{{
                    $sfielda[
                      $sfield
                    ]
                  }}</b>
                </td>
                <td align="center" width="15%">
                  <font class="grey">รหัสเอกสาร</font>
                </td>
                <td align="center" width="15%" class="active_right">
                  <b
                    >{{
                      $sfieldas[
                        $sfield
                      ]
                    }}{{ $ymcode }}/{{ $fprint_number }}</b
                  >
                </td>
              </tr>
            </table>

            <table align="center" width="90%" cellpadding="0" cellspacing="0">
              <tr class="activebg" height="30">
                <td class="actived grey" align="center" width="15%">
                  วัน / เดือน / ปี
                </td>
                <td class="actived" align="center" width="40%">
                  <font class="grey">รายการ</font>
                </td>
                <td align="center" width="15%" class="grey actived">
                  เอกสารอ้างอิง
                </td>
                <td class="actived" align="center" width="15%">
                  <font class="grey">รายรับ</font>
                </td>
                <td align="center" width="15%" class="actived gray">หน่วย</td>
              </tr>
              @foreach ($data as $receipt)
                <tr
                  class="activeda"
                  height="15"
                  @if (($receipt['cancle'] ?? 0) == 1) style="background:#f8d7da;color:#842029;" @endif
                >
                  <td align="center" width="15%" class="actived">
                    <b>
                      <font size="{{ $fontsize }}"
                        >{{
                          $receipt[
                            'receipt_submission_date'
                          ]
                        }}
                      </font>
                    </b>
                  </td>
                  <td align="left" width="40%" class="actived">
                    &nbsp;
                    <b>
                      <font size="{{ $fontsize }}"
                        >{{
                          $receipt[
                            'receipt_firstname'
                          ]
                        }} {{
                          $receipt[
                            'receipt_lastname'
                          ]
                        }} {!!
                          $receipt[
                            'receipt_des'
                          ]
                        !!}</font
                      >
                    </b>
                  </td>
                  <td align="center" width="15%" class="actived">
                    <b>
                      <font size="{{ $fontsize }}">{{
                        $receipt[
                          'receipt_number'
                        ]
                      }}</font>
                    </b>
                  </td>
                  <td align="center" width="15%" class="actived">
                    <b>
                      <font size="{{ $fontsize }}">{{
                        $receipt[
                          'receipt_price'
                        ]
                      }}</font>
                    </b>
                  </td>
                  <td align="center" width="15%" class="actived grey">
                    <b>
                      <font size="{{ $fontsize }}">{{
                        $receipt[
                          'receipt_price_label'
                        ]
                      }}</font>
                    </b>
                  </td>
                </tr>
              @endforeach
              <tr class="activebg" height="25">
                <td
                  align="center"
                  colspan="3"
                  width="15%"
                  class="actived activebottomd grey"
                >
                  <font size="{{ $fontsize }}"><b>รวมทั้งสิ้น</b></font>
                </td>
                <td align="center" width="15%" class="actived activebottomd">
                  <font size="{{ $fontsize }}"><b>{{ $total_price }}</b></font>
                </td>
                <td
                  align="center"
                  width="15%"
                  class="actived activebottomd grey"
                >
                  <font size="{{ $fontsize }}"><b>บาท</b></font>
                </td>
              </tr>
            </table>

            <table align="center" width="90%" cellpadding="0" cellspacing="0">
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
