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

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <style>
      table {
        font-size: 0.7rem;
      }

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

      .tbr table td.active_twin {
        border-left: 2px solid rgb(138, 175, 61);
        border-right: 2px solid rgb(138, 175, 61);
      }

      .tbr table td.active {
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
    </style>
    <style>
      /* .image-container {
            text-align: center;
            margin: 50px 0;
        }

        .image-container img {
            height: 400px;
            display: inline-block;
        } */

      .image-container {
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 50px 0;
      }

      .image-container img {
        height: 450px;
      }
    </style>
  </head>

  <body>
    <div class="row">
      @if ($typeRec == 9 || $group_rec)
        <div class="main-card card mb-3" id="x_content">
          <div class="card-body">
            <table align="center" width="99%" cellpadding="0" cellspacing="0">
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
            <table align="center" width="99%" cellpadding="0" cellspacing="0">
              <tr>
                <td colspan="4" align="center" style="padding-left: 50px">
                  <b>
                    {{ $mes2 }}
                    <br />
                    {{ $text2 }}
                  </b>
                </td>

                <td align="center" class="aaa">
                  <b>
                    ต้นฉบับ
                    <br />
                    Original
                    <br />
                    สำหรับลูกค้า
                  </b>
                </td>
              </tr>
              <tr>
                <td width="25%" class="grey">
                  นามลูกค้า,ที่อยู่/Client,Address
                </td>
                <td
                  width="25%"
                  style="padding-left: 20px"
                  align="right"
                  class="grey"
                >
                  รหัสลูกค้า/Customer's Code
                </td>
                <td width="20%" style="padding-left: 15px">
                  <b>
                    {{-- {{ $data2->code }} --}}
                    {{ $student_code }}
                  </b>
                </td>
                <td width="20%" align="right" class="grey">
                  เลขที่ / Document No.
                </td>
                <td width="10%" style="padding-left: 10px">
                  <b>{{ $data->receipt_number }}</b>
                </td>
              </tr>
              <tr>
                <td width="25%">
                  <font class="grey">K.</font>
                  <b>{{ $data2->name_parent }}</b>
                </td>
                <td
                  width="25%"
                  align="right"
                  style="padding-left: 20px"
                  class="grey"
                >
                  ชื่อนักเรียน/Nickname
                </td>
                <td width="20%" align="left" style="padding-left: 15px">
                  <b>{{ $student }}</b>
                </td>
                <td width="20%" align="right" class="grey">วันที่ / Date</td>
                <td width="10%" style="padding-left: 10px">
                  <b>{{ $data->submission_date }}</b>
                </td>
              </tr>
              <tr>
                <!-- <td colspan="3"><font class="grey">ที่อยู่</font> <b>{{ $data->street_address }} {{ $data->street_address2 }}
                                    {{ $data->city }} {{ $data->province }} {{ $data->postcode }} </b></td> -->
                <td colspan="3"></td>

                <td width="45%" align="right" class="grey">
                  เงื่อนไขการชำระเงิน / Credit Term
                </td>
                <td width="30%" style="padding-left: 10px">
                  ..........................
                </td>
              </tr>
              <tr>
                <td colspan="3"></td>

                <td align="right" width="45%" class="grey">
                  ครบกำหนด / Due Date
                </td>
                <td align="right" width="30%" style="padding-left: 10px">
                  ..........................
                </td>
              </tr>
              <!-- <tr>
                            <td colspan="5"><font class="grey">โทร.</font> <b> {{ $data->mobile }} </b></td>

                        </tr> -->
            </table>

            <div class="tbr">
              <table align="center" width="99%" cellpadding="0" cellspacing="0">
                <tr class="active">
                  <td align="center" width="10%" class="grey">
                    ลำดับที่
                    <br />
                    NO.
                  </td>
                  <td align="center" class="grey">
                    รายการ
                    <br />
                    Description
                  </td>
                  <td align="center" class="grey">
                    ระยะเวลา
                    <br />
                    Period
                  </td>
                  <td align="center" class="grey">
                    จำนวน
                    <br />
                    Quantity
                  </td>
                  <td align="center" class="grey">
                    หน่วย
                    <br />
                    Unit
                  </td>
                  <td align="center" class="grey">
                    ราคาต่อหน่วย
                    <br />
                    Unit Price
                  </td>
                  <td align="center" class="grey">
                    ส่วนลด
                    <br />
                    Discount
                  </td>
                  <td align="center" class="grey">
                    จำนวนเงิน
                    <br />
                    Amount
                  </td>
                </tr>
                @php
                  // dd($receipt_detail_arr);
                @endphp

                @foreach ($receipt_detail_arr as $receipt_detail)
                  @if ($receipt_detail['course_type'] == 1)
                    @php
                      $startDate = new DateTime('2024-02-07');
                      $currentDate = new DateTime($data->submission_date); //2024-02-08
                      $checkDate = $currentDate > $startDate;
                      $unitBook = $receipt_detail['bookprice'] / $receipt_detail['book'];
                    @endphp
                    @php
                      $startDate = new DateTime('2024-02-07');
                      $currentDate = new DateTime($data->submission_date); //2024-02-08
                      $checkDate = $currentDate > $startDate;

                      $bookPrice = (float) $receipt_detail['bookprice'];
                      $bookQuantity = (int) $receipt_detail['book'];
                      // $bookQuantity = (int) $receipt_detail['book'];
                      $unitpriceQuantity = (int) str_replace(',', '', $receipt_detail['unitprice']);
                      // dd($unitpriceQuantity,$receipt_detail['unitprice']);

                      $unitBook = $bookPrice / $bookQuantity;
                      $unitpriceBook = $unitpriceQuantity + $unitBook;
                      // dd($unitpriceQuantity,$receipt_detail['unitprice'],$unitpriceBook,$unitBook,$receipt_detail['price']);
                    @endphp
                    <tr>
                      <td align="center" style="vertical-align: top">
                        {{
                          $receipt_detail[
                            'no'
                          ]
                        }}
                      </td>
                      <td align="left">
                        ค่าคอร์สเรียน {!!
                          $receipt_detail[
                            'description'
                          ]
                        !!}
                      </td>
                      <td align="center">
                        {{
                          $receipt_detail[
                            'period'
                          ]
                        }}
                      </td>
                      <td align="center">
                        {{
                          $receipt_detail[
                            'quantity'
                          ]
                        }}
                      </td>
                      <td align="center">
                        {{
                          $receipt_detail[
                            'unit'
                          ]
                        }}
                      </td>
                      <td align="center">
                        {{
                          number_format(
                            $unitpriceBook,
                            2,
                          )
                        }}
                      </td>
                      <td align="center">
                        {{
                          $receipt_detail[
                            'discount'
                          ]
                        }}
                      </td>
                      <td align="center" style="vertical-align: top">
                        {{
                          number_format(
                            $unitpriceBook,
                            2,
                          )
                        }}
                      </td>
                    </tr>
                    @if ($receipt_detail['entrance_fee'] > 0)
                      <td></td>
                      <td align="left">ค่าแรกเข้า</td>
                      <td align="left"></td>
                      <td align="center">1</td>
                      <td align="center">ครั้ง</td>
                      <td align="center">
                        {{
                          number_format(
                            $receipt_detail['entrance_fee'],
                            2,
                          )
                        }}
                      </td>
                      <td align="center"></td>
                      <td align="center" style="vertical-align: top">
                        {{
                          number_format(
                            $receipt_detail['entrance_fee'],
                            2,
                          )
                        }}
                      </td>
                    @endif
                  @elseif ($receipt_detail['course_type'] == 2)
                    <tr>
                      <td align="center" style="vertical-align: top">
                        @if ($receipt_detail['course_type'] == 2 &&
                          $receipt_detail['course_type'] !== 1)
                          {{
                            $receipt_detail[
                              'no'
                            ]
                          }}
                        @endif
                      </td>
                      @if ($receipt_detail['book'] !== '0')
                        <td align="left">
                          ค่าหนังสือ {!!
                            $receipt_detail[
                              'description'
                            ]
                          !!}
                        </td>
                        <td align="center">-</td>
                        <td align="center">
                          {{
                            $receipt_detail[
                              'book'
                            ]
                          }}
                        </td>
                        <td align="center">เล่ม</td>
                        <td align="center">
                          {{
                            number_format(
                              $receipt_detail['books'],
                              2,
                            )
                          }}
                        </td>
                        <td align="center"></td>
                        <td align="center" style="vertical-align: top">
                          {{
                            $receipt_detail[
                              'bookprice'
                            ]
                          }}
                        </td>
                      @endif
                    </tr>
                  @elseif ($receipt_detail['course_type'] == 3)
                    <td align="center" style="vertical-align: top">
                      {{
                        $receipt_detail[
                          'no'
                        ]
                      }}
                    </td>
                    <td align="left">
                      ค่าสื่อการสอน {!!
                        $receipt_detail[
                          'media_name'
                        ]
                      !!}
                    </td>
                    <td align="left"></td>
                    <td align="center">
                      {{
                        $receipt_detail[
                          'quantity'
                        ]
                      }}
                    </td>
                    <td align="center">
                      {{
                        $receipt_detail[
                          'unit'
                        ]
                      }}
                    </td>
                    <td align="center">
                      {{
                        $receipt_detail[
                          'unitprice'
                        ]
                      }}
                    </td>
                    <td align="center">
                      {{
                        $receipt_detail[
                          'discount'
                        ]
                      }}
                    </td>
                    <td align="center" style="vertical-align: top">
                      {{
                        $receipt_detail[
                          'price'
                        ]
                      }}
                    </td>
                  @endif
                @endforeach

                {{--
                  <tr>
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
                  
                  </tr>
                --}}
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
              <table align="center" width="99%" cellpadding="0" cellspacing="0">
                {{--
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
                  {!! $payment !!}
                  </table>
                  </td>
                  <td colspan="3" class="activetop activeleft">
                  <table width="100%" cellpadding="0" cellspacing="0">
                  <tr>
                  <td width="40%"></td>
                  <td width="40%" class="grey">มูลค่าที่ยกเว้นภาษี/Non-Vat Amount</td>
                  <!-- <td width="20%"></td> -->
                  <td width="20%"> <b> {{ number_format($booksum, 2) }} </b></td>
                  <!-- <td width="10%"></td> -->
                  
                  
                  </tr>
                  <tr>
                  <td width="40%"></td>
                  <td width="40%" class="grey">มูลค่าที่คำนวนภาษี/Pre-Vat Amount</td>
                  <!-- <td width="10%"></td> -->
                  <td width="20%"> <b> {{ $vat_price_val }} </b></td>
                  <!-- <td width="10%"></td> -->
                  </tr>
                  <tr>
                  <td width="40%"></td>
                  <!-- <td width="20%"></td> -->
                  <td width="40%" class="grey">ส่วนลด/Discout</td>
                  <td width="20%"><b>{{ number_format($discount, 2) }}</b></td>
                  </tr>
                  <tr>
                  <td width="40%"></td>
                  <td width="40%" class="grey">ภาษีมูลค่าเพิ่ม 7% / Vat 7%</td>
                  <td width="20%"><b>{{ $vat_val }}</b></td>
                  </tr>
                  </table>
                  </td>
                  
                  </tr>
                --}}
                <tr class="active">
                  <td align="center" class="grey">
                    รวมทั้งสิ้น
                    <br />
                    Grand Total
                  </td>
                  <td align="center">
                    <b>{{ $price_text }}</b>
                    <br />
                    <b>{{ $price_texten }}</b>
                  </td>
                  <td align="center"><b>{{ $price_val }}</b></td>

                  <td align="right" class="grey">
                    บาท
                    <br />
                    Baht
                  </td>
                </tr>
              </table>

              <!-- <table align="center" width="85%" cellpadding="0" cellspacing="0">
                                                                                                                        <tr>
                                                                                                                            <td align="center" class="grey">ได้รับริการตามบริการถูกต้องแล้ว</td>
                                                                                                                            <td align="center" class="grey">ในนามบริษัท อินฟินิท เบรน จำกัด</td>
                                                                                                                        </tr>
                                                                                                                    </table> -->

              <table
                align="center"
                width="99%"
                cellpadding="0"
                cellspacing="0"
                style="margin-top: 30px"
              >
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

              <center>{!! $html !!}</center>
              {{--
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
              --}}
            </div>
          </div>
        </div>
        <div class="main-card card mb-3" id="x_content">
          <div class="card-body">
            <table align="center" width="99%" cellpadding="0" cellspacing="0">
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

            <table align="center" width="99%" cellpadding="0" cellspacing="0">
              <tr>
                <td colspan="4" align="center" style="padding-left: 50px">
                  <b>
                    {{ $mes }}
                    <br />
                    {{ $text }}
                  </b>
                </td>

                <td align="center" class="aaa">
                  <b>
                    ต้นฉบับ
                    <br />
                    Original
                    <br />
                    สำหรับลูกค้า
                  </b>
                </td>
              </tr>
              <tr>
                <td width="25%" class="grey">
                  นามลูกค้า,ที่อยู่/Client,Address
                </td>
                <td
                  width="25%"
                  style="padding-left: 20px"
                  align="right"
                  class="grey"
                >
                  รหัสลูกค้า/Customer's Code
                </td>
                <td width="20%" style="padding-left: 15px">
                  <b>
                    {{-- {{ $data2->code }} --}}
                    {{ $student_code }}
                  </b>
                </td>
                <td width="20%" align="right" class="grey">
                  เลขที่ / Document No.
                </td>
                <td width="10%" style="padding-left: 10px">
                  <b>{{ $data->receipt_number }}</b>
                </td>
              </tr>
              <tr>
                <td width="25%">
                  <font class="grey">K.</font>
                  <b>{{ $data2->name_parent }}</b>
                </td>
                <td
                  width="25%"
                  align="right"
                  style="padding-left: 20px"
                  class="grey"
                >
                  ชื่อนักเรียน/Nickname
                </td>
                <td width="20%" align="left" style="padding-left: 15px">
                  <b>{{ $student }}</b>
                </td>
                <td width="20%" align="right" class="grey">วันที่ / Date</td>
                <td width="10%" style="padding-left: 10px">
                  <b>{{ $data->submission_date }}</b>
                </td>
              </tr>
              <tr>
                <!-- <td colspan="3"><font class="grey">ที่อยู่</font> <b>{{ $data->street_address }} {{ $data->street_address2 }}
                                    {{ $data->city }} {{ $data->province }} {{ $data->postcode }} </b></td> -->
                <td colspan="3"></td>

                <td width="45%" align="right" class="grey">
                  เงื่อนไขการชำระเงิน / Credit Term
                </td>
                <td width="30%" style="padding-left: 10px">
                  ..........................
                </td>
              </tr>
              <tr>
                <td colspan="3"></td>

                <td align="right" width="45%" class="grey">
                  ครบกำหนด / Due Date
                </td>
                <td align="right" width="30%" style="padding-left: 10px">
                  ..........................
                </td>
              </tr>
              <!-- <tr>
                            <td colspan="5"><font class="grey">โทร.</font> <b> {{ $data->mobile }} </b></td>

                        </tr> -->
            </table>
            <div class="tbr">
              <table align="center" width="99%" cellpadding="0" cellspacing="0">
                <tr class="active">
                  <td align="center" width="10%" class="grey">
                    ลำดับที่
                    <br />
                    NO.
                  </td>
                  <td align="center" class="grey">
                    รายการ
                    <br />
                    Description
                  </td>
                  <td align="center" class="grey">
                    ระยะเวลา
                    <br />
                    Period
                  </td>
                  <td align="center" class="grey">
                    จำนวน
                    <br />
                    Quantity
                  </td>
                  <td align="center" class="grey">
                    หน่วย
                    <br />
                    Unit
                  </td>
                  <td align="center" class="grey">
                    ราคาต่อหน่วย
                    <br />
                    Unit Price
                  </td>
                  <td align="center" class="grey">
                    ส่วนลด
                    <br />
                    Discount
                  </td>
                  <td align="center" class="grey">
                    จำนวนเงิน
                    <br />
                    Amount
                  </td>
                </tr>
                @php
                  // dd($receipt_detail_arr);
                @endphp

                @foreach ($receipt_detail_arr as $receipt_detail)
                  @if ($receipt_detail['course_type'] == 1)
                    <tr>
                      <td align="center" style="vertical-align: top">
                        {{
                          $receipt_detail[
                            'no'
                          ]
                        }}
                      </td>
                      <td align="left">
                        ค่าคอร์สเรียน {!!
                          $receipt_detail[
                            'description'
                          ]
                        !!}
                      </td>
                      <td align="center">
                        {{
                          $receipt_detail[
                            'period'
                          ]
                        }}
                      </td>
                      <td align="center">
                        {{
                          $receipt_detail[
                            'quantity'
                          ]
                        }}
                      </td>
                      <td align="center">
                        {{
                          $receipt_detail[
                            'unit'
                          ]
                        }}
                      </td>
                      <td align="center">
                        {{
                          $receipt_detail[
                            'unitprice'
                          ]
                        }}
                      </td>
                      <td align="center">
                        {{
                          $receipt_detail[
                            'discount'
                          ]
                        }}
                      </td>
                      <td align="center" style="vertical-align: top">
                        {{
                          $receipt_detail[
                            'price'
                          ]
                        }}
                      </td>
                    </tr>
                    @if ($receipt_detail['entrance_fee'] > 0)
                      <td></td>
                      <td align="left">ค่าแรกเข้า</td>
                      <td align="left"></td>
                      <td align="center">1</td>
                      <td align="center">ครั้ง</td>
                      <td align="center">
                        {{
                          number_format(
                            $receipt_detail['entrance_fee'],
                            2,
                          )
                        }}
                      </td>
                      <td align="center"></td>
                      <td align="center" style="vertical-align: top">
                        {{
                          number_format(
                            $receipt_detail['entrance_fee'],
                            2,
                          )
                        }}
                      </td>
                    @endif
                    <tr>
                      <td align="center" style="vertical-align: top">
                        @if ($receipt_detail['course_type'] == 2 &&
                          $receipt_detail['course_type'] !== 1)
                          {{
                            $receipt_detail[
                              'no'
                            ]
                          }}
                        @endif
                      </td>
                      @if ($receipt_detail['book'] !== '0')
                        <td align="left">
                          ค่าหนังสือ {!!
                            $receipt_detail[
                              'description'
                            ]
                          !!}
                        </td>
                        <td align="left"></td>
                        <td align="center">
                          {{
                            $receipt_detail[
                              'book'
                            ]
                          }}
                        </td>
                        {{--
                          <td align="center">
                          เล่ม
                          ชุด
                          </td>
                        --}}
                        @php
                          $startDate = new DateTime('2024-02-07');
                          $currentDate = new DateTime($data->submission_date); //2024-02-08
                          $checkDate = $currentDate > $startDate;
                          $unitBook = $receipt_detail['bookprice'] / $receipt_detail['book'];
                        @endphp
                        @if ($checkDate)
                          <td align="center">
                            {{-- เล่ม --}}
                            ชุด
                          </td>
                          <td align="center">
                            {{
                              number_format(
                                $unitBook,
                                2,
                              )
                            }}
                          </td>
                        @else
                          <td align="center">
                            เล่ม
                            {{-- ชุด --}}
                          </td>
                          <td align="center">
                            {{
                              number_format(
                                $unitBook,
                                2,
                              )
                            }}
                          </td>
                        @endif
                        <td align="center"></td>
                        <td align="center" style="vertical-align: top">
                          {{
                            number_format(
                              $receipt_detail['bookprice'],
                              2,
                            )
                          }}
                        </td>
                      @endif
                    </tr>
                  @elseif ($receipt_detail['course_type'] == 2)
                    <tr>
                      <td align="center" style="vertical-align: top">
                        @if ($receipt_detail['course_type'] == 2 &&
                          $receipt_detail['course_type'] !== 1)
                          {{
                            $receipt_detail[
                              'no'
                            ]
                          }}
                        @endif
                      </td>
                      @if ($receipt_detail['book'] !== '0')
                        <td align="left">
                          ค่าหนังสือ {!!
                            $receipt_detail[
                              'description'
                            ]
                          !!}
                        </td>
                        <td align="center">-</td>
                        <td align="center">
                          {{
                            $receipt_detail[
                              'book'
                            ]
                          }}
                        </td>
                        <td align="center">เล่ม</td>
                        <td align="center">
                          {{
                            number_format(
                              $receipt_detail['books'],
                              2,
                            )
                          }}
                        </td>
                        <td align="center"></td>
                        <td align="center" style="vertical-align: top">
                          {{
                            $receipt_detail[
                              'bookprice'
                            ]
                          }}
                        </td>
                      @endif
                    </tr>
                  @elseif ($receipt_detail['course_type'] == 3)
                    <td align="center" style="vertical-align: top">
                      {{
                        $receipt_detail[
                          'no'
                        ]
                      }}
                    </td>
                    <td align="left">
                      ค่าสื่อการสอน {!!
                        $receipt_detail[
                          'media_name'
                        ]
                      !!}
                    </td>
                    <td align="left"></td>
                    <td align="center">
                      {{
                        $receipt_detail[
                          'quantity'
                        ]
                      }}
                    </td>
                    <td align="center">
                      {{
                        $receipt_detail[
                          'unit'
                        ]
                      }}
                    </td>
                    <td align="center">
                      {{
                        $receipt_detail[
                          'unitprice'
                        ]
                      }}
                    </td>
                    <td align="center">
                      {{
                        $receipt_detail[
                          'discount'
                        ]
                      }}
                    </td>
                    <td align="center" style="vertical-align: top">
                      {{
                        $receipt_detail[
                          'price'
                        ]
                      }}
                    </td>
                  @endif
                @endforeach

                {{--
                  <tr>
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
                  
                  </tr>
                --}}
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
              <table align="center" width="99%" cellpadding="0" cellspacing="0">
                <tr>
                  <td
                    width="45%"
                    class="activetop"
                    style="
                      padding-top: 20px;
                      padding-bottom: 30px;
                      padding-left: 40px;
                    "
                  >
                    <table width="100%" cellpadding="0" cellspacing="0">
                      <tr>
                        <td></td>
                        <td colspan="2" style="padding-left: 50px" class="grey">
                          การชำระเงิน/Payment
                        </td>
                      </tr>
                      {!! $payment !!}
                    </table>
                  </td>
                  <td colspan="3" class="activetop activeleft">
                    <table width="100%" cellpadding="0" cellspacing="0">
                      <tr>
                        <td width="40%"></td>
                        <td width="40%" class="grey">
                          มูลค่าที่ยกเว้นภาษี/Non-Vat Amount
                        </td>
                        <!-- <td width="20%"></td> -->
                        <td width="20%">
                          <b>{{
                            number_format(
                              $booksum,
                              2,
                            )
                          }}</b>
                        </td>
                        <!-- <td width="10%"></td> -->
                      </tr>
                      <tr>
                        <td width="40%"></td>
                        <td width="40%" class="grey">
                          มูลค่าที่คำนวนภาษี/Pre-Vat Amount
                        </td>
                        <!-- <td width="10%"></td> -->
                        <td width="20%"><b>{{ $vat_price_val }}</b></td>
                        <!-- <td width="10%"></td> -->
                      </tr>
                      <tr>
                        <td width="40%"></td>
                        <!-- <td width="20%"></td> -->
                        <td width="40%" class="grey">ส่วนลด/Discout</td>
                        <td width="20%">
                          <b>{{
                            number_format(
                              $discount,
                              2,
                            )
                          }}</b>
                        </td>
                      </tr>
                      <tr>
                        <td width="40%"></td>
                        <!-- <td width="20%"></td> -->
                        <td width="40%" class="grey">
                          ภาษีมูลค่าเพิ่ม 7% / Vat 7%
                        </td>
                        <td width="20%"><b>{{ $vat_val }}</b></td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <tr class="active">
                  <td align="center" class="grey">
                    รวมทั้งสิ้น
                    <br />
                    Grand Total
                  </td>
                  <td align="center">
                    <b>{{ $price_text }}</b>
                    <br />
                    <b>{{ $price_texten }}</b>
                  </td>
                  <td align="center"><b>{{ $price_val }}</b></td>

                  <td align="right" class="grey">
                    บาท
                    <br />
                    Baht
                  </td>
                </tr>
              </table>

              <!-- <table align="center" width="85%" cellpadding="0" cellspacing="0">
                                                                                                                        <tr>
                                                                                                                            <td align="center" class="grey">ได้รับริการตามบริการถูกต้องแล้ว</td>
                                                                                                                            <td align="center" class="grey">ในนามบริษัท อินฟินิท เบรน จำกัด</td>
                                                                                                                        </tr>
                                                                                                                    </table> -->

              <table
                align="center"
                width="99%"
                cellpadding="0"
                cellspacing="0"
                style="margin-top: 30px"
              >
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
              <center>{!! $html !!}</center>
            </div>
          </div>
        </div>
      @else
        <div class="main-card card mb-3" id="x_content">
          <div class="card-body">
            <table align="center" width="99%" cellpadding="0" cellspacing="0">
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

            <table align="center" width="99%" cellpadding="0" cellspacing="0">
              <tr>
                <td colspan="4" align="center" style="padding-left: 50px">
                  <b>
                    {{ $mes }}
                    <br />
                    {{ $text }}
                  </b>
                </td>

                <td align="center" class="aaa">
                  <b>
                    ต้นฉบับ
                    <br />
                    Original
                    <br />
                    สำหรับลูกค้า
                  </b>
                </td>
              </tr>
              <tr>
                <td width="25%" class="grey">
                  นามลูกค้า,ที่อยู่/Client,Address
                </td>
                <td
                  width="25%"
                  style="padding-left: 20px"
                  align="right"
                  class="grey"
                >
                  รหัสลูกค้า/Customer's Code
                </td>
                <td width="20%" style="padding-left: 15px">
                  <b>
                    {{-- {{ $data2->code }} --}}
                    {{ $student_code }}
                  </b>
                </td>
                <td width="20%" align="right" class="grey">
                  เลขที่ / Document No.
                </td>
                <td width="10%" style="padding-left: 10px">
                  <b>{{ $data->receipt_number }}</b>
                </td>
              </tr>
              <tr>
                <td width="25%">
                  <font class="grey">K.</font>
                  <b>{{ $data2->name_parent }}</b>
                </td>
                <td
                  width="25%"
                  align="right"
                  style="padding-left: 20px"
                  class="grey"
                >
                  ชื่อนักเรียน/Nickname
                </td>
                <td width="20%" align="left" style="padding-left: 15px">
                  <b>{{ $student }}</b>
                </td>
                <td width="20%" align="right" class="grey">วันที่ / Date</td>
                <td width="10%" style="padding-left: 10px">
                  <b>{{ $data->submission_date }}</b>
                </td>
              </tr>
              <tr>
                <!-- <td colspan="3"><font class="grey">ที่อยู่</font> <b>{{ $data->street_address }} {{ $data->street_address2 }}
                                    {{ $data->city }} {{ $data->province }} {{ $data->postcode }} </b></td> -->
                <td colspan="3"></td>

                <td width="45%" align="right" class="grey">
                  เงื่อนไขการชำระเงิน / Credit Term
                </td>
                <td width="30%" style="padding-left: 10px">
                  ..........................
                </td>
              </tr>
              <tr>
                <td colspan="3"></td>

                <td align="right" width="45%" class="grey">
                  ครบกำหนด / Due Date
                </td>
                <td align="right" width="30%" style="padding-left: 10px">
                  ..........................
                </td>
              </tr>
              <!-- <tr>
                            <td colspan="5"><font class="grey">โทร.</font> <b> {{ $data->mobile }} </b></td>

                        </tr> -->
            </table>
            <div class="tbr">
              <table align="center" width="99%" cellpadding="0" cellspacing="0">
                <tr class="active">
                  <td align="center" width="10%" class="grey">
                    ลำดับที่
                    <br />
                    NO.
                  </td>
                  <td align="center" class="grey">
                    รายการ
                    <br />
                    Description
                  </td>
                  <td align="center" class="grey">
                    ระยะเวลา
                    <br />
                    Period
                  </td>
                  <td align="center" class="grey">
                    จำนวน
                    <br />
                    Quantity
                  </td>
                  <td align="center" class="grey">
                    หน่วย
                    <br />
                    Unit
                  </td>
                  <td align="center" class="grey">
                    ราคาต่อหน่วย
                    <br />
                    Unit Price
                  </td>
                  <td align="center" class="grey">
                    ส่วนลด
                    <br />
                    Discount
                  </td>
                  <td align="center" class="grey">
                    จำนวนเงิน
                    <br />
                    Amount
                  </td>
                </tr>
                @php
                  // dd($receipt_detail_arr);
                @endphp

                @foreach ($receipt_detail_arr as $receipt_detail)
                  @if ($receipt_detail['course_type'] == 1)
                    <tr>
                      <td align="center" style="vertical-align: top">
                        {{
                          $receipt_detail[
                            'no'
                          ]
                        }}
                      </td>
                      <td align="left">
                        ค่าคอร์สเรียน {!!
                          $receipt_detail[
                            'description'
                          ]
                        !!}
                      </td>
                      <td align="center">
                        {{
                          $receipt_detail[
                            'period'
                          ]
                        }}
                      </td>
                      <td align="center">
                        {{
                          $receipt_detail[
                            'quantity'
                          ]
                        }}
                      </td>
                      <td align="center">
                        {{
                          $receipt_detail[
                            'unit'
                          ]
                        }}
                      </td>
                      <td align="center">
                        {{
                          $receipt_detail[
                            'unitprice'
                          ]
                        }}
                      </td>
                      <td align="center">
                        {{
                          $receipt_detail[
                            'discount'
                          ]
                        }}
                      </td>
                      <td align="center" style="vertical-align: top">
                        {{
                          $receipt_detail[
                            'price'
                          ]
                        }}
                      </td>
                    </tr>
                    @if ($receipt_detail['entrance_fee'] > 0)
                      <td></td>
                      <td align="left">ค่าแรกเข้า</td>
                      <td align="left"></td>
                      <td align="center">1</td>
                      <td align="center">ครั้ง</td>
                      <td align="center">
                        {{
                          number_format(
                            $receipt_detail['entrance_fee'],
                            2,
                          )
                        }}
                      </td>
                      <td align="center"></td>
                      <td align="center" style="vertical-align: top">
                        {{
                          number_format(
                            $receipt_detail['entrance_fee'],
                            2,
                          )
                        }}
                      </td>
                    @endif
                    <tr>
                      <td align="center" style="vertical-align: top">
                        @if ($receipt_detail['course_type'] == 2 &&
                          $receipt_detail['course_type'] !== 1)
                          {{
                            $receipt_detail[
                              'no'
                            ]
                          }}
                        @endif
                      </td>
                      @if ($receipt_detail['book'] !== '0')
                        <td align="left">
                          ค่าหนังสือ {!!
                            $receipt_detail[
                              'description'
                            ]
                          !!}
                        </td>
                        <td align="left"></td>
                        <td align="center">
                          {{
                            $receipt_detail[
                              'book'
                            ]
                          }}
                        </td>
                        {{--
                          <td align="center">
                          เล่ม
                          ชุด
                          </td>
                        --}}
                        @php
                          $startDate = new DateTime('2024-02-07');
                          $currentDate = new DateTime($data->submission_date); //2024-02-08
                          $checkDate = $currentDate > $startDate;
                          $unitBook = $receipt_detail['bookprice'] / $receipt_detail['book'];
                        @endphp
                        @php
                          $startDate = new DateTime('2024-02-07');
                          $currentDate = new DateTime($data->submission_date); //2024-02-08
                          $checkDate = $currentDate > $startDate;

                          // Ensure $receipt_detail['bookprice'] and $receipt_detail['book'] are treated as numbers
                          $bookPrice = (float) $receipt_detail['bookprice'];
                          $bookQuantity = (int) $receipt_detail['book'];

                          // Perform the calculation
                          $unitBook = $bookPrice / $bookQuantity;
                        @endphp
                        @if (true)
                          <td align="center">ชุด</td>
                          <td align="center">
                            {{
                              number_format(
                                $unitBook,
                                2,
                              )
                            }}
                          </td>
                        @else
                          <td align="center">เล่ม</td>
                          <td align="center">
                            {{
                              number_format(
                                $unitBook,
                                2,
                              )
                            }}
                          </td>
                        @endif
                        <td align="center"></td>
                        <td align="center" style="vertical-align: top">
                          {{
                            number_format(
                              $receipt_detail['bookprice'],
                              2,
                            )
                          }}
                        </td>
                      @endif
                    </tr>
                  @elseif ($receipt_detail['course_type'] == 2)
                    <tr>
                      <td align="center" style="vertical-align: top">
                        @if ($receipt_detail['course_type'] == 2 &&
                          $receipt_detail['course_type'] !== 1)
                          {{
                            $receipt_detail[
                              'no'
                            ]
                          }}
                        @endif
                      </td>
                      @if ($receipt_detail['book'] !== '0')
                        <td align="left">
                          ค่าหนังสือ {!!
                            $receipt_detail[
                              'description'
                            ]
                          !!}
                        </td>
                        <td align="center">-</td>
                        <td align="center">
                          {{
                            $receipt_detail[
                              'book'
                            ]
                          }}
                        </td>
                        <td align="center">เล่ม</td>
                        <td align="center">
                          {{
                            number_format(
                              $receipt_detail['books'],
                              2,
                            )
                          }}
                        </td>
                        <td align="center"></td>
                        <td align="center" style="vertical-align: top">
                          {{
                            $receipt_detail[
                              'bookprice'
                            ]
                          }}
                        </td>
                      @endif
                    </tr>
                  @elseif ($receipt_detail['course_type'] == 3)
                    <td align="center" style="vertical-align: top">
                      {{
                        $receipt_detail[
                          'no'
                        ]
                      }}
                    </td>
                    <td align="left">
                      ค่าสื่อการสอน {!!
                        $receipt_detail[
                          'media_name'
                        ]
                      !!}
                    </td>
                    <td align="left"></td>
                    <td align="center">
                      {{
                        $receipt_detail[
                          'quantity'
                        ]
                      }}
                    </td>
                    <td align="center">
                      {{
                        $receipt_detail[
                          'unit'
                        ]
                      }}
                    </td>
                    <td align="center">
                      {{
                        $receipt_detail[
                          'unitprice'
                        ]
                      }}
                    </td>
                    <td align="center">
                      {{
                        $receipt_detail[
                          'discount'
                        ]
                      }}
                    </td>
                    <td align="center" style="vertical-align: top">
                      {{
                        $receipt_detail[
                          'price'
                        ]
                      }}
                    </td>
                  @endif
                @endforeach

                {{--
                  <tr>
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
                  
                  </tr>
                --}}
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
              <table align="center" width="99%" cellpadding="0" cellspacing="0">
                <tr>
                  <td
                    width="45%"
                    class="activetop"
                    style="
                      padding-top: 20px;
                      padding-bottom: 30px;
                      padding-left: 40px;
                    "
                  >
                    <table width="100%" cellpadding="0" cellspacing="0">
                      <tr>
                        <td></td>
                        <td colspan="2" style="padding-left: 50px" class="grey">
                          การชำระเงิน/Payment
                        </td>
                      </tr>
                      {!! $payment !!}
                    </table>
                  </td>
                  <td colspan="3" class="activetop activeleft">
                    <table width="100%" cellpadding="0" cellspacing="0">
                      <tr>
                        <td width="40%"></td>
                        <td width="40%" class="grey">
                          มูลค่าที่ยกเว้นภาษี/Non-Vat Amount
                        </td>
                        <!-- <td width="20%"></td> -->
                        <td width="20%">
                          <b>{{
                            number_format(
                              $booksum,
                              2,
                            )
                          }}</b>
                        </td>
                        <!-- <td width="10%"></td> -->
                      </tr>
                      <tr>
                        <td width="40%"></td>
                        <td width="40%" class="grey">
                          มูลค่าที่คำนวนภาษี/Pre-Vat Amount
                        </td>
                        <!-- <td width="10%"></td> -->
                        <td width="20%"><b>{{ $vat_price_val }}</b></td>
                        <!-- <td width="10%"></td> -->
                      </tr>
                      <tr>
                        <td width="40%"></td>
                        <!-- <td width="20%"></td> -->
                        <td width="40%" class="grey">ส่วนลด/Discout</td>
                        <td width="20%">
                          <b>{{
                            number_format(
                              $discount,
                              2,
                            )
                          }}</b>
                        </td>
                      </tr>
                      <tr>
                        <td width="40%"></td>
                        <!-- <td width="20%"></td> -->
                        <td width="40%" class="grey">
                          ภาษีมูลค่าเพิ่ม 7% / Vat 7%
                        </td>
                        <td width="20%"><b>{{ $vat_val }}</b></td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <tr class="active">
                  <td align="center" class="grey">
                    รวมทั้งสิ้น
                    <br />
                    Grand Total
                  </td>
                  <td align="center">
                    <b>{{ $price_text }}</b>
                    <br />
                    <b>{{ $price_texten }}</b>
                  </td>
                  <td align="center"><b>{{ $price_val }}</b></td>

                  <td align="right" class="grey">
                    บาท
                    <br />
                    Baht
                  </td>
                </tr>
              </table>

              <!-- <table align="center" width="85%" cellpadding="0" cellspacing="0">
                                                                                                                        <tr>
                                                                                                                            <td align="center" class="grey">ได้รับริการตามบริการถูกต้องแล้ว</td>
                                                                                                                            <td align="center" class="grey">ในนามบริษัท อินฟินิท เบรน จำกัด</td>
                                                                                                                        </tr>
                                                                                                                    </table> -->

              <table
                align="center"
                width="99%"
                cellpadding="0"
                cellspacing="0"
                style="margin-top: 30px"
              >
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
              <center>{!! $html !!}</center>
            </div>
          </div>
        </div>
      @endif
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
