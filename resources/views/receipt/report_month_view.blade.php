@extends('layouts.main_template')

@section('style')
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.37.1/apexcharts.min.js" integrity="sha512-hl0UXLK2ElpaU9SHbuVNsvFv2BaYszlhxB2EntUy5FTGdfg9wFJrJG2JDcT4iyKmWeuDLmK+Nr2hLoq2sKk6MQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script src="http://malsup.github.io/jquery.blockUI.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/inputmask@5.0.8/dist/jquery.inputmask.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js" type="text/javascript"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.37.1/apexcharts.min.css" integrity="sha512-FVK9gBi+kZ53Adi2mwTlAXLduxcltMFsyTyoLhJyJcVgbhXb0eQdAGNjoNc7Mt75cH0uc6I1JEdjWc36TUhBuQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@section('content')
    <div class="row">

        @if ($message = Session::get('success'))
            <!--<div class="alert alert-success">
                                            <p>{{ $message }}</p>
                                             </div>-->
            <script>
                toastr.success('{{ $message }}', {
                    timeOut: 5000
                });
            </script>
        @endif

        @if ($message = Session::get('error'))
            <!--<div class="alert alert-success">
                                            <p>{{ $message }}</p>
                                             </div>--->
            <script>
                toastr.error('{{ $message }}', {
                    timeOut: 5000
                });
            </script>
        @endif

        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-note2 icon-gradient bg-tempting-azure"></i>
                    </div>
                    <div>{{ $sfielda[request()->get('pmsfield')] }} Receipts Report {{ request()->get('print_month') }}
                        <div class="page-title-subheading">META Knowledge Receipt Report</div>
                    </div>
                </div>
                <div class="page-title-actions">
                    {{-- <div class="d-inline-block dropdown">
                        <div class="dropdown show">
                            <button class="btn btn-shadow btn-secondary dropdown-toggle" href="#" role="button"
                                id="dropdownMenuLink" data-toggle="dropdown" autoClose="true" aria-haspopup="true"
                                aria-expanded="false">
                                <span class="btn-icon-wrapper pr-2 opacity-7">
                                    <i class="fa fa-print fa-w-20"></i>
                                </span>
                                Print ใบปะหน้า
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                <li><a class="dropdown-item" href="#" id="printr1">ใบปะหน้ารายวัน</a></li>
                                <li><a class="dropdown-item" href="#" id="printr2">ใบปะหน้ารายเดือน</a></li>
                            </ul>
                        </div>

                    </div> --}}


                    <div class="d-inline-block dropdown">
                        {{--  <a class="btn btn-info" data-toggle="modal" data-target=".bd-example-modal-lg" id="ImportButton"><i
                                class="fa fa-file-excel"></i> Import Excel
                        </a> --}}
                        <a class="btn btn-success" data-toggle="modal" data-target=".bd-example-modal-lg"
                            id="printr2"><i class="fa fa-search"></i> Search</a>
                        {{-- <a class="btn btn-danger delete_all_button" href="#"><i class="fa fa-trash"></i> Delete
                            All</a>
 --}}
                    </div>
                </div>
            </div>
        </div>
        <div class="main-card mb-3 card " id="x_content">
            <div class="card-body">
                 <div id="chart"></div>
                <table style="width: 100%;" id="Listview"
                    class="table table-striped table-hover table-bordered responsive-utilities jambo_table bulk_action">
                    <thead>
                        <tr>
                            <th class="text-center">วัน / เดือน / ปี</th>
                            <th class="text-center">รายการ</th>
                            <th class="text-center">เอกสารอ้างอิง</th>
                            <th class="text-center">รายรับ</th>
                            <th class="text-center">หน่วย</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $receipt)
                            <tr>
                                <td align="center" width="15%">{{ $receipt['receipt_submission_date'] }}</td>
                                <td align="left" width="40%">&nbsp; {{ $receipt['description'] }}</td>
                                <td align="center" width="15%">{{ $receipt['receipt_numbers'] }}</td>
                                <td align="center" width="15%">{{ $receipt['total_price'] }}</td>
                                <td align="center" width="15%">{{ $receipt['receipt_price_label'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="activebg" height="50">
                            <td align="center" colspan="3" width="15%">
                                <font size="3"><b>รวมทั้งสิ้น</b></font>
                            </td>
                            <td align="center" width="15%"><b>{{ $total_price }}</b></td>
                            <td align="center" width="15%">
                                <font size="3"><b>บาท</b></font>
                            </td>
                        </tr>
                    </tfoot>
                </table>

            </div>
        </div>

    </div>


    <div class="body-block-example-2" style="display:none" id="loder_bar">
        <br>
        <div class="loader" id="loder_bar_div">
            <div class="spinner-border text-primary" role="status">
                <span class="sr-only">Loading...</span>
            </div>
            <div class="spinner-border text-danger" role="status">
                <span class="sr-only">Loading...</span>
            </div>
            <div class="spinner-border text-warning" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <br>
    </div>






    <!-- PrintMonth Modal -->
    <div class="fade modal bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true" id="PrintMonthModal">
        <div class="modal-dialog modal-lg" role="document">
            <form id="PrintMonthForm" class="form" action="{{ route('receipts.print_month') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Receipt Report รายเดือน</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;">
                            <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="alert alert-success alert-dismissible fade show" role="alert" style="display: none;">

                            <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true"></span>
                            </button>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="File">สนามสอบ:</label>
                                <select class="form-control" id="PrintMonthsField" name="pmsfields" required disabled>
                                    @foreach ($sfielda as $key => $value)
                                        <option value="{{ $key }}"
                                            {{ request()->get('pmsfield') == $key ? 'selected' : '' }}> {{ $value }}
                                        </option>
                                    @endforeach
                                </select>
                                <input type="hidden" name="type" value="report_view">
                                <input type="hidden" name="pmsfield" value="{{ request()->get('pmsfield') }}">
                                <input type="hidden" name="Pmdescription" value="ค่าสมัคร {{ $sfielda[request()->get('pmsfield')] }} รอบแรก  @php {{ echo date("Y"); }} @endphp">
                            </div>
                            <div class="form-group">
                                <label for="Submission Month">Report Month:</label>
                                <input type="text" class="AddMonth form-control" name="print_month"
                                    id="PrintMonthSubmissiondate" value="{{ request()->get('print_month') }}" required>
                            </div>
                           {{--  <div class="form-group">
                                <div class="position-relative form-group">
                                    <label for="Des">รายการ:</label>
                                    <input type="text" class="form-control" name="Pmdescription" id="PmDes"
                                        value="ค่าสมัคร {{ $sfielda[request()->get('pmsfield')] }} รอบแรก  @php {{ echo date("Y"); }} @endphp">
                                </div>
                            </div> --}}
                            {{-- <div class="form-group">
                             <label for="Submission Date">รหัสเอกสาร:</label>
                             <input type="number" class="form-control" name="print_number" id="PrintDayNumber"
                                 value="" required>
                         </div> --}}
                        </div>


                    </div>
                    <!-- Modal footer id="SubmitPrintDayForm"-->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Search</button>
                        <button type="button" class="btn btn-danger modelClose" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {

            $('.dropdown-toggle').dropdown();

            $(".AddDate").datepicker({
                dateFormat: "yy-mm-dd"
            });

            /* $(".AddMonth").datepicker({
                dateFormat: "yy-mm"
            }); */

            $(".AddDate").inputmask("9999-99-99");
            $(".AddMonth").inputmask("9999-99");
            $(".AddPhone").inputmask("(999) 999-9999");


            //$.noConflict();
            var token = ''
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });



            $('#printr2').on('click', function(e) {
                //console.log("TEST");
                e.preventDefault();
                $('.alert-danger').html('');
                $('.alert-danger').hide();
                $('.alert-success').html('');
                $('.alert-success').hide();
                $('.dropdown-toggle').dropdown('hide');
                $('#PrintMonthModal').modal('show');
            });

        })

        var options = {
          series: [{
          name: 'ยอดรวม',
          data: [{{ $chart_date_price }}]
        }, /* {
          name: 'Revenue',
          data: [76, 85, 101, 98, 87, 105, 91, 114, 94]
        }, {
          name: 'Free Cash Flow',
          data: [35, 41, 36, 26, 45, 48, 52, 53, 41]
        } */],
          chart: {
          type: 'bar',
          height: 350
        },
        plotOptions: {
          bar: {
            horizontal: false,
            columnWidth: '55%',
            endingShape: 'rounded'
          },
        },
        dataLabels: {
          enabled: false
        },
        stroke: {
          show: true,
          width: 2,
          colors: ['transparent']
        },
        xaxis: {
            labels: {
            rotate: -45
          },
        title: {
            text: 'ยอดรวมรายได้ {{ $sfielda[request()->get('pmsfield')] }} ประจำเดือน {{ request()->get('print_month') }}'
          },

          categories: [{!! $chart_date !!}],
        },
        yaxis: {
           /*  title: {
            text: 'ยอดรวมรายได้ {{ $sfielda[request()->get('pmsfield')] }} ประจำเดือน {{ request()->get('print_month') }}'
          } */
        },
        fill: {
            type: 'gradient',
          gradient: {
            shade: 'light',
            type: "horizontal",
            shadeIntensity: 0.25,
            gradientToColors: undefined,
            inverseColors: true,
            opacityFrom: 0.85,
            opacityTo: 0.85,
            stops: [50, 0, 100]
          },
          opacity: 1
        },
        tooltip: {
          y: {
            formatter: function (val) {
              return "$ " + val + " บาท"
            }
          }
        }
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
    </script>
@endsection
