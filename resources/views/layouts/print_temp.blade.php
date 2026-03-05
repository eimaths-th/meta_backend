<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link
      rel="stylesheet"
      href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css"
    />
    <link
      rel="stylesheet"
      href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css"
    />
    <link href="../assets/plugins/nvd3/build/nv.d3.css" rel="stylesheet" />
    <link
      href="/assets/plugins/switchery/dist/switchery.min.css"
      rel="stylesheet"
    />

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script
      src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"
      type="text/javascript"
    ></script>
    <script
      src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"
      type="text/javascript"
    ></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script src="https://malsup.github.io/jquery.blockUI.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    {{-- <script src="https://d3js.org/d3.v7.min.js"></script> --}}
    <script src="../assets/plugins/d3/d3.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    {{-- <script src="../assets/plugins/nvd3/build/nv.d3.min.js"></script> --}}
    {{-- <script src="../assets/plugins/chart.js/dist/Chart.min.js"></script> --}}
    <script src="../assets/plugins/flot/source/jquery.canvaswrapper.js"></script>
    <script src="../assets/plugins/flot/source/jquery.colorhelpers.js"></script>
    <script src="../assets/plugins/flot/source/jquery.flot.js"></script>
    <script src="../assets/plugins/flot/source/jquery.flot.saturated.js"></script>
    <script src="../assets/plugins/flot/source/jquery.flot.browser.js"></script>
    <script src="../assets/plugins/flot/source/jquery.flot.drawSeries.js"></script>
    <script src="../assets/plugins/flot/source/jquery.flot.uiConstants.js"></script>
    <script src="/assets/plugins/switchery/dist/switchery.min.js"></script>
    <script
      src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"
      type="text/javascript"
    ></script>
    <script
      src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"
      type="text/javascript"
    ></script>

    <script
      defer
      src="{{ asset('architectui/assets/scripts/main.js') }}"
    ></script>
    <script
      src="https://code.jquery.com/jquery-3.5.1.js"
      type="text/javascript"
    ></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script
      src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
      integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
      integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF"
      crossorigin="anonymous"
    ></script>
    @yield('style')
    <script
      defer
      src="{{ asset('architectui/assets/scripts/demo.js') }}"
    ></script>
    <script
      defer
      src="{{ asset('architectui/assets/scripts/toastr.js') }}"
    ></script>
    <script
      defer
      src="{{ asset('architectui/assets/scripts/scrollbar.js') }}"
    ></script>
    {{-- <script defer src="{{ asset('architectui/assets/scripts/fullcalendar.js') }}"></script> --}}
    <script
      defer
      src="{{ asset('architectui/assets/scripts/maps.js') }}"
    ></script>
    <script
      defer
      src="{{ asset('architectui/assets/scripts/chart_js.js') }}"
    ></script>
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <script src="/js/app.js?v=1"></script>
    <script
      src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"
      type="text/javascript"
    ></script>
    <script
      src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"
      type="text/javascript"
    ></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script src="https://malsup.github.io/jquery.blockUI.js"></script>
    <link
      rel="stylesheet"
      href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css"
    />

    <link
      rel="stylesheet"
      href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css"
    />

    <script src="/assets/plugins/sweetalert/dist/sweetalert.min.js"></script>

    <!-- Scripts
      @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    -->
    <link
      rel="stylesheet"
      href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css"
      type="text/css"
    />

    <link href="../assets/css/app.minn.css" rel="stylesheet" />

    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css"
    />
    <link rel="stylesheet" href="{{ asset('css/infinite.css') }}" />

    <style>
      .form-row {
        display: flex;
        flex-wrap: wrap;
        margin-right: -5px;
        margin-left: -5px;
      }

      .form-row > .col,
      .form-row > [class*='col-'] {
        padding-right: 5px;
        padding-left: 5px;
      }

      .example {
        width: 50%;
        /* 50% of the parent container's width */
        font-size: 2em;
        /* 2 times the default font size */
      }

      /* @media screen and (max-width: 400px) {
            .screen-auto {
                max-width: 100%;
                height: auto;
            }
        }

        .screen-auto {
            max-width: 800;
            height: 200;
        } */
    </style>
    <style>
      .screen-auto {
        max-width: 100%;
        height: auto;
      }
    </style>

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
    {{--
      <style>
      @media print {
      @page {
      size: landscape;
      }
      }
      </style>
    --}}
  </head>

  <body>
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
    @yield('content')
    @yield('script')
    <table align="center" width="98%" cellpadding="0" cellspacing="0">
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
  </body>

  <script>
    function printrep() {
      setTimeout(function () {
        window.print();
      }, 2000);
      // window.print();
    }
    printrep();
    setTimeout(function () {
      window.close();
    }, 4000);
  </script>
</html>
