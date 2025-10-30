@extends('layouts.main_template')

@section('style')
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js" type="text/javascript"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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

        .tbr table td.activetop {
            border-top: 2px solid rgb(138, 175, 61);
        }

        .tbr table td.active {
            border-left: 2px solid rgb(138, 175, 61);
            border-right: 2px solid rgb(138, 175, 61);
        }

        .tbr table td.activebottom {
            border-bottom: 2px solid rgb(138, 175, 61);
        }

        .tbr table td.activeright {
            border-right: 2px solid rgb(138, 175, 61);
        }

        .tbr table td.activeleft {
            border-left: 2px solid rgb(138, 175, 61);
        }

        .aaa {
            color: rgb(138, 175, 61);
        }

        .img-my-5 {
            margin-top: 3rem;
            margin-bottom: 3rem;
        }

        .img-mx-5 {
            margin-left: 3rem;
            margin-right: 3rem;
        }

        .img-m-5 {
            margin: 3rem;
        }

        .my-5 {
            margin-top: 1rem;
            margin-bottom: 1rem;
        }
    </style>
@endsection

@section('content')
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
                        ใบกำกับภาษี/ใบเสร็จรับเงิน
                        <div class="page-title-subheading">META Knowledge ใบกำกับภาษี/ใบเสร็จรับเงิน Data</div>
                    </div>
                </div>
                <div class="page-title-actions">
                    <div class="d-inline-block dropdown">

                        <a class="btn btn-warning " href="#" onclick="export_report();"><i class="fa fa-print"></i>
                            Print</a>
                        <a href="{{ route('receipts', ['sfield' => $pdsfield]) }}" class="btn btn-success"
                            data-toggle="modal" data-target=".bd-example-modal-lg" id="CreateButton"><i
                                class="fa fa-backward"></i> Back
                            ใบกำกับภาษี/ใบเสร็จรับเงิน</a>


                    </div>
                </div>
            </div>
        </div>
        @foreach ($data as $receipt_info => $receipt_val)
            <div class="main-card mb-3 card " id="x_content">

                <div class="card-body">
                    @php
                        //var_dump($data);
                        //exit();
                    @endphp
                    <table align="center" width="85%" cellpadding="0" cellspacing="0">
                        <thead>
                            <tr>
                                <td width="15%" rowspan="4"><img src="{{ asset('images/infinite.jpg') }}"
                                        alt="..." height="106" style="padding-bottom: 5px"></td>
                                <td>บริษัท อินฟินิท เบรน จำกัด (สำนักงานใหญ่) </td>
                            </tr>
                            <tr>
                                <td>555/9 ม.1 ต.บางขนุน อ.บางกรวย จ.นนทบุรี 11130</td>
                            </tr>
                            <tr>
                                <td>เลขประจำตัวผู้เสียภาษี: 0125563031038 </td>
                            </tr>
                            <tr>
                                <td>โทร 098 509 8554</td>
                            </tr>
                        </thead>
                    </table>
                    @php
                        //var_dump($data);
                        //exit();
                    @endphp
                    <table align="center" width="85%" cellpadding="0" cellspacing="0">
                        <tr>
                            <td colspan="4" align="center"><b>
                                    {{ $receipt_val['mes'] }}<br>
                                    {{ $receipt_val['text'] }}
                                </b></td>

                            <td align="center" class="aaa"><b>ต้นฉบับ <br> Original <br>สำหรับลูกค้า</b></td>

                        </tr>
                        <tr>
                            <td class="grey">นามลูกค้า,ที่อยู่/Client,Address</td>
                            <td align="right" class="grey">รหัสลูกค้า/Customer's Code</td>
                            <td> <b> {{ $receipt_val['customer_number'] }} </b></td>
                            <td align="right" class="grey">เลขที่ / Document No.</td>
                            <td> <b> {{ $receipt_val['number'] }} </b></td>
                        </tr>
                        <tr>
                            <td>
                                <font class="grey">K.</font> <b> {{ $receipt_val['name_parent'] }} </b>
                            </td>
                            <td align="right" class="grey">ชื่อนักเรียน/Nickname</td>
                            <td align="left" width="30%"> <b>{{ $receipt_val['first_name'] }}
                                    {{ $receipt_val['last_name'] }}</b></td>
                            <td align="right" class="grey">วันที่ / Date</td>
                            <td> <b>{{ $receipt_val['submission_date'] }}</b></td>
                        </tr>
                        <tr>
                            <!-- <td colspan="3"><font class="grey">ที่อยู่</font> <b> </b></td> -->
                            <td colspan="3"></td>
                            <td align="right" class="grey">เงื่อนไขการชำระเงิน / Credit Term</td>
                            <td>..........................</td>
                        </tr>
                        <tr>
                            <td colspan="3"></td>

                            <td align="right" class="grey">ครบกำหนด / Due Date</td>
                            <td>..........................</td>
                        </tr>
                        <!-- <tr>
                                                                <td colspan="5"><font class="grey">โทร.</font> <b>  </b></td>

                                                            </tr> -->
                    </table>
                    <div class="tbr">
                        <table align="center" width="85%" cellpadding="0" cellspacing="0">
                            <tr class="active">
                                <td align="center" width="10%" class="grey">ลำดับที่<br> NO.</td>
                                <td align="center" class="grey">รายการ <br>Description</td>
                                <td align="center" class="grey">จำนวน <br>Quantity</td>
                                <td align="center" class="grey">หน่วย <br>Unit</td>
                                <td align="center" class="grey">ราคาต่อหน่วย <br>Unit Price</td>
                                <td align="center" class="grey">ส่วนลด <br>Discount</td>
                                <td align="center" class="grey">จำนวนเงิน <br>Amount</td>

                            </tr>
                            @php
                                //var_dump($receipt_detail_arr);
                                //exit();
                            @endphp
                            @foreach ($receipt_val['detail'] as $receipt_detail)
                                <tr>
                                    <td align="center" style="vertical-align: top;">{{ $receipt_detail['no'] }}</td>
                                    <td align="left">{!! $receipt_detail['description'] !!}</td>
                                    <td align="center">{{ $receipt_detail['quantity'] }}</td>
                                    <td align="center">{{ $receipt_detail['unit'] }}</td>
                                    <td align="center">{{ $receipt_detail['unitprice'] }}</td>
                                    <td align="center">{{ $receipt_detail['discount'] }}</td>
                                    <td align="center" style="vertical-align: top;">{{ $receipt_detail['price'] }}</td>
                                </tr>
                            @endforeach
                            {{--  <tr>
                            <td align="center" style="vertical-align: top;">1</td>
                            <td align="left">{!! $des_text !!}</td>
                            <td ></td>
                            <td ></td>
                            <td ></td>
                            <td ></td>
                            <td align="center" style="vertical-align: top;">{{ $price_val }}</td>
                            </tr>
                            <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>

                            </tr> --}}
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                        </table>
                        <table align="center" width="85%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td width="45%" class="activetop"
                                    style="padding-top:20px;padding-bottom:30px; padding-left:40px;">
                                    <table width="100%" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td></td>
                                            <td colspan="2" style="padding-left:50px;" class="  grey">
                                                การชำระเงิน/Payment
                                            </td>

                                        </tr>
                                        <tr>
                                            <td class="active activebottom activetop" width="10%"></td>
                                            <td class="  grey">1.เงินสด/Cash</td>
                                            <td class="  grey"></td>

                                        </tr>
                                        <tr>
                                            <td class="active activebottom" width="10%" align="center"><i
                                                    style="font-size: 1.8em; color:red" class="fa fa-close"></i></td>
                                            <td class=" grey">2.โอนเงิน/Transfer</td>
                                            <td class="  grey"></td>

                                        </tr>
                                        <tr>
                                            <td class="active activebottom" width="10%"></td>
                                            <td class=" grey">3.บัตรเครดิต/Credit Card</td>
                                            <td class="  grey"></td>

                                        </tr>
                                    </table>
                                </td>
                                <td colspan="3" class="activetop activeleft">
                                    <table width="100%" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td width="40%"></td>
                                            <td width="40%" class="grey">มูลค่าที่ยกเว้นภาษี/Non-Vat Amount</td>
                                            <!-- <td width="20%"></td> -->
                                            <td width="20%" align="right" style="padding-right: 35px"> <b>
                                                    {{-- {{ $vat_price_val }} --}} 00.00</b></td>
                                            <!-- <td width="10%"></td> -->


                                        </tr>
                                        <tr>
                                            <td width="40%"></td>
                                            <td width="40%" class="grey">มูลค่าที่คำนวนภาษี/Pre-Vat Amount</td>
                                            <!-- <td width="10%"></td> -->
                                            <td width="20%" align="right" style="padding-right: 35px">
                                                <b>{{ $receipt_val['vat_price_val'] }}</b>
                                            </td>
                                            <!-- <td width="10%"></td> -->
                                        </tr>
                                        <tr>
                                            <td width="40%"></td>
                                            <!-- <td width="20%"></td> -->
                                            <td width="40%" class="grey">ส่วนลด/Discout</td>
                                            <td width="20%" align="right" style="padding-right: 35px"><b>00.00</b>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="40%"></td>
                                            <!-- <td width="20%"></td> -->
                                            <td width="40%" class="grey">ภาษีมูลค่าเพิ่ม 7% / Vat 7%</td>
                                            <td width="20%" align="right" style="padding-right: 35px">
                                                <b>{{ $receipt_val['vat_val'] }}</b>
                                            </td>
                                        </tr>
                                    </table>
                                </td>

                            </tr>
                            <tr class="active">
                                <td align="center" class="grey">รวมทั้งสิ้น<br>Grand Total</td>
                                <td align="center">
                                    <b>{{ $receipt_val['price_text'] }}</b><br><b>{{ $receipt_val['price_texten'] }}</b>
                                </td>
                                <td align="center"><b>{{ $receipt_val['price_val'] }}</b></td>

                                <td align="right" class="grey">บาท<br>Baht</td>
                            </tr>

                        </table>

                        <!-- <table align="center" width="85%" cellpadding="0" cellspacing="0">
                                                                <tr>
                                                                    <td align="center" class="grey">ได้รับริการตามบริการถูกต้องแล้ว</td>
                                                                    <td align="center" class="grey">ในนามบริษัท อินฟินิท เบรน จำกัด</td>
                                                                </tr>
                                                            </table> -->

                        <table align="center" width="85%" cellpadding="0" cellspacing="0" style="margin-top:30px;">
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td align="center">.........................</td>
                                <td align="center">.........................</td>
                            </tr>
                            <tr>
                                <td align="center" class="grey">ผู้รับบริการ</td>
                                <td align="center" class="grey">ผู้จัดการ</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td align="center">Received by</td>
                                <td align="center">Manager</td>
                            </tr>

                        </table>
                        <center>{!! $receipt_val['file_att'] !!}</center>
                        <br>
                        <br>
                    </div>

                </div>

            </div>
        @endforeach

    </div>
@endsection

@section('script')
    <script>
        function export_report() {
            url =
                '{{ route('receipts.show_day', ['type' => 'print', 'pdsfield' => $pdsfield, 'print_rdate' => $print_date]) }}';
            window.open(
                url.replace(/&amp;/g, "&")
            );

        }
    </script>
@endsection
