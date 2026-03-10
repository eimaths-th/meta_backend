@extends ('layouts.main_template')

@section ('style')
  <script
    src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"
    type="text/javascript"
  ></script>
  <script
    src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"
    type="text/javascript"
  ></script>
  <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <link
    rel="stylesheet"
    href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css"
  />
  <link
    rel="stylesheet"
    href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css"
  />
  <link
    href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"
    rel="stylesheet"
  />
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
@endsection

@section ('content')
  <div class="row">
    @if ($message = Session::get('success'))
      <div class="alert alert-success">
        <p>{{ $message }}</p>
      </div>
    @endif

    <div class="app-page-title">
      <div class="page-title-wrapper">
        <div class="page-title-heading">
          <div class="page-title-icon">
            <i class="pe-7s-note2 icon-gradient bg-tempting-azure"></i>
          </div>
          <div>
            Receipts
            <div class="page-title-subheading">
              META Knowledge ใบปะหน้ารายสนาม
            </div>
          </div>
        </div>
        <div class="page-title-actions">
          <div class="d-inline-block dropdown">
            <a class="btn btn-warning" href="#" onclick="export_report()"
              ><i class="fa fa-print"></i> Print</a
            >
            <a
              href="{{ route('receipts', ['sfield' => $sfield]) }}"
              class="btn btn-success"
              data-toggle="modal"
              data-target=".bd-example-modal-lg"
              id="CreateButton"
              ><i class="fa fa-backward"></i> Back Receipts</a
            >
          </div>
        </div>
      </div>
    </div>

    <div class="main-card card mb-3" id="x_content">
      <div class="card-body">
        <table align="center" width="85%" cellpadding="0" cellspacing="0">
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
              <tr>
                <td>โทร 098 509 8554</td>
              </tr>
            </thead>
          @endif
        </table>

        <div class="tbr">
          <table align="center" width="85%" cellpadding="0" cellspacing="0">
            <tr class="active" height="30">
              <td align="center" width="15%" class="active_left grey"></td>
              <td align="center" width="40%">
                <font class="grey">รวมรายรับ </font> <b>{{ $pmdes }}</b>
                {{-- <b>{{ $sfielda[$sfield] }}</b> <b>{{ $thaimonth }} {{ $thaiyear }} --}}
                </b>
              </td>
              <td align="center" width="15%"></td>
              <td align="center" width="15%">
                {{--  <font class="grey">รหัสเอกสาร</font> --}}
              </td>
              <td align="center" width="15%" class="active_right">
                <b>{{-- {{ $sfieldas[$sfield] }}{{ $ymcode }} --}}</b>
              </td>
            </tr>
          </table>

          <table align="center" width="85%" cellpadding="0" cellspacing="0">
            <tr class="actived activebg" height="30">
              <td align="center" width="15%" class="actived grey">
                วัน / เดือน / ปี
              </td>
              <td align="center" width="40%">
                <font class="actived grey">รายการ</font>
              </td>
              <td align="center" width="15%" class="grey actived">
                เอกสารอ้างอิง
              </td>
              <td align="center" width="15%">
                <font class="grey actived">รายรับ</font>
              </td>
              <td align="center" width="15%" class="actived gray">หน่วย</td>
            </tr>
            @foreach ($data as $receipt)
              <tr class="activeda" height="30">
                <td align="center" width="15%" class="actived">
                  <b>{{
                    $receipt[
                      'receipt_submission_month'
                    ]
                  }}</b>
                </td>
                <td align="left" width="40%" class="actived">
                  &nbsp;
                  <b>{!!
                    $receipt[
                      'description'
                    ]
                  !!}</b>
                </td>
                <td align="center" width="15%" class="actived">
                  <b>{{
                    $receipt[
                      'field_code'
                    ]
                  }}</b>
                </td>
                <td align="center" width="15%" class="actived">
                  <b>{{
                    $receipt[
                      'total_price'
                    ]
                  }}</b>
                </td>
                <td align="center" width="15%" class="actived grey">
                  <b>{{
                    $receipt[
                      'receipt_price_label'
                    ]
                  }}</b>
                </td>
              </tr>
            @endforeach
            <tr class="activebg" height="50">
              <td
                align="center"
                colspan="3"
                width="15%"
                class="actived activebottomd grey"
              >
                <font size="3"><b>รวมทั้งสิ้น</b></font>
              </td>
              <td align="center" width="15%" class="actived activebottomd">
                <b>{{ $total_price }}</b>
              </td>
              <td align="center" width="15%" class="actived activebottomd grey">
                <font size="3"><b>บาท</b></font>
              </td>
            </tr>
          </table>

          <br /><br /><br />

          <table align="center" width="85%" cellpadding="0" cellspacing="0">
            <tr>
              <td></td>
              <td></td>
              <td align="center">ลงชื่อ...................................</td>
            </tr>
            <tr>
              <td></td>
              <td></td>
              <td align="center">ผู้จัดการ</td>
            </tr>
          </table>
        </div>
        {{-- <h1>{{ $month_year }}</h1> --}}
        {{-- <h1>{{ $ }}</h1> --}}
      </div>
    </div>
  </div>
@endsection

@section ('script')
  <script>
    function export_report() {
      url = '{{ route('receipts.print_field', ['type' => 'print', 'pmsfield' => $pmsfield, 'fontsize' => $fontsize, 'Pmdescription' => $pmdes, 'print_monthYear' => $month_year, 'printFieldTemplate' => $template]) }}';
      console.log(url.replace(/&amp;/g, '&'));
      window.open(url.replace(/&amp;/g, '&'));
    }
  </script>
@endsection
