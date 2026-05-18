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
        border-top: 2px solid rgb(255, 174, 0);
        border-bottom: 2px solid rgb(255, 174, 0);
      }

      .tbr table td.activetop {
        border-top: 2px solid rgb(255, 174, 0);
      }

      .tbr table td.active_twin {
        border-left: 2px solid rgb(255, 174, 0);
        border-right: 2px solid rgb(255, 174, 0);
      }

      .tbr table td.active {
        border-right: 2px solid rgb(255, 174, 0);
      }

      .tbr table td.activebottom {
        border-bottom: 2px solid rgb(255, 174, 0);
      }

      .tbr table td.activeright {
        border-right: 2px solid rgb(255, 174, 0);
      }

      .tbr table td.activeleft {
        border-left: 2px solid rgb(255, 174, 0);
      }

      .aaa {
        color: rgb(255, 174, 0);
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

      /* Print page break styles */
      @media print {
        .main-card {
          page-break-after: always;
          page-break-inside: avoid;
          break-after: page;
          break-inside: avoid;
        }

        .main-card:last-child {
          page-break-after: auto;
          break-after: auto;
        }

        @page {
          size: A4;
          margin: 10mm;
        }

        body {
          -webkit-print-color-adjust: exact;
          print-color-adjust: exact;
        }
      }
    </style>
  </head>

  <body>
    <div class="row">
      @foreach ($data as $receipt_info => $receipt_val)
        <div class="main-card card mb-3" id="x_content">
          <div class="card-body">
            <table align="center" width="99%" cellpadding="0" cellspacing="0">
              {{--
                <thead>
                <tr>
                <td width="25%" rowspan="6" align="center">
                <img src="{{ asset('images/infinite.jpg') }}" alt="..." height="150"
                style="padding-bottom: 5px">
                </td>
                
                </tr>
                <tr>
                <td style="vertical-align: top;" height="5px">บริษัท อินฟินิท เบรน จำกัด
                (สำนักงานใหญ่)
                </td>
                </tr>
                <tr>
                <td style="vertical-align: top;" height="5px">555/9 ม.1 ต.บางขนุน อ.บางกรวย จ.นนทบุรี
                11130
                </td>
                </tr>
                <tr>
                <td style="vertical-align: top;"height="5px">เลขประจำตัวผู้เสียภาษี: 0125563031038</td>
                </tr>
                <tr>
                <td style="vertical-align: top;" height="5px">โทร 098 509 8554</td>
                </tr>
                <tr>
                <td style="vertical-align: top;" height="50px"></td>
                </tr>
                </thead>
              --}}

              @include('receipt.partials.company_header_full', [
                'company' => $company ?? config('receipt.profiles.' . ($metaCheck ? 'meta2' : config('receipt.default_profile')))
              ])
            </table>
            <table align="center" width="99%" cellpadding="0" cellspacing="0">
              <tr>
                <td colspan="4" align="center">
                  <b>
                    {{
                      $receipt_val[
                        'mes'
                      ]
                    }}
                    <br />
                    {{
                      $receipt_val[
                        'text'
                      ]
                    }}
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
                  <b>{{
                    $receipt_val[
                      'customer_number'
                    ]
                  }}</b>
                </td>
                <td width="20%" align="right" class="grey">
                  เลขที่ / Document No.
                </td>
                <td width="10%" style="padding-left: 10px">
                  <b>{{
                    $receipt_val[
                      'number'
                    ]
                  }}</b>
                </td>
              </tr>
              <tr>
                <td>
                  <font class="grey">K.</font>
                  <b>{{
                    $receipt_val[
                      'name_parent'
                    ]
                  }}</b>
                </td>
                <td align="right" style="padding-left: 20px" class="grey">
                  ชื่อนักเรียน/Nickname
                </td>
                <td align="left" style="padding-left: 15px">
                  <b>
                    {{
                      $receipt_val[
                        'first_name'
                      ]
                    }} {{
                      $receipt_val[
                        'middle_name'
                      ]
                    }} {{
                      $receipt_val[
                        'last_name'
                      ]
                    }}
                  </b>
                </td>
                <td align="right" class="grey">วันที่ / Date</td>
                <td style="padding-left: 10px">
                  <b>{{
                    $receipt_val[
                      'submission_date'
                    ]
                  }}</b>
                </td>
              </tr>
              <tr>
                <!-- <td colspan="3"><font class="grey">ที่อยู่</font> <b> </b></td> -->
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
                        <td colspan="5"><font class="grey">โทร.</font> <b>  </b></td>

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
                @foreach ($receipt_val['detail'] as $receipt_detail)
                  <tr>
                    <td align="center" style="vertical-align: top">
                      {{
                        $receipt_detail[
                          'no'
                        ]
                      }}
                    </td>
                    <td align="left">
                      {!!
                        $receipt_detail[
                          'description'
                        ]
                      !!}
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
                @endforeach

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
                    width="37%"
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
                      <tr>
                        <td
                          class="active activebottom activetop activeleft"
                          width="10%"
                        ></td>
                        <td style="padding-left: 30px" class="grey">
                          1.เงินสด/Cash
                        </td>
                        <td class="grey"></td>
                      </tr>
                      <tr>
                        <td
                          class="active_twin activebottom activeleft"
                          width="10%"
                          align="center"
                        >
                          <img
                            src="{{ asset('images/close.png') }}"
                            alt="..."
                            height="14"
                            style="padding-bottom: 1px"
                          />
                        </td>

                        <!-- <td class="active activebottom activeleft" width="10%" align="center"><i
                                                style="font-size: 1.8em; color:red" class="fa fa-close"></i></td> -->
                        <td style="padding-left: 30px" class="grey">
                          2.โอนเงิน/Transfer
                        </td>
                        <td class="grey"></td>
                      </tr>
                      <tr>
                        <td
                          class="active activebottom activeleft"
                          width="10%"
                        ></td>
                        <td style="padding-left: 30px" class="grey">
                          3.บัตรเครดิต/Credit Card
                        </td>
                        <td class="grey"></td>
                      </tr>
                    </table>
                  </td>
                  <td colspan="6" class="activetop activeleft">
                    <table width="100%" cellpadding="0" cellspacing="0">
                      <tr>
                        <td width="10%"></td>
                        <td width="67%" class="grey">
                          มูลค่าที่ยกเว้นภาษี/Non-Vat Amount
                        </td>
                        <!-- <td width="20%"></td> -->
                        <td width="15%" align="right"><b>00.00</b></td>
                        <td width="8%"></td>
                      </tr>
                      <tr>
                        <td width="10%"></td>
                        <td width="67%" class="grey">
                          มูลค่าที่คำนวนภาษี/Pre-Vat Amount
                        </td>
                        <!-- <td width="10%"></td> -->
                        <td width="15%" align="right">
                          <b>
                            {{
                              $receipt_val[
                                'vat_price_val'
                              ]
                            }}
                            {{-- {{ $vat_price_val }} --}}
                          </b>
                        </td>
                        <td width="8%"></td>
                      </tr>
                      <tr>
                        <td width="10%"></td>
                        <!-- <td width="20%"></td> -->
                        <td width="67%" class="grey">ส่วนลด/Discout</td>
                        <td width="15%" align="right"><b>00.00</b></td>
                        <td width="8%"></td>
                      </tr>
                      <tr>
                        <td width="10%"></td>
                        <!-- <td width="20%"></td> -->
                        <td width="67%" class="grey">
                          ภาษีมูลค่าเพิ่ม 7% / Vat 7%
                        </td>
                        <td width="15%" align="right">
                          <b>{{
                            $receipt_val[
                              'vat_val'
                            ]
                          }}</b>
                        </td>
                        <td width="8%"></td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <tr class="active">
                  <td width="20%" align="center" class="grey">
                    รวมทั้งสิ้น
                    <br />
                    Grand Total
                  </td>
                  <td colspan="4" width="40%" align="left">
                    <b>{{
                      $receipt_val[
                        'price_text'
                      ]
                    }}</b>
                    <br />
                    <b>{{
                      $receipt_val[
                        'price_texten'
                      ]
                    }}</b>
                  </td>
                  <td width="20%" align="center">
                    <b>{{
                      $receipt_val[
                        'price_val'
                      ]
                    }}</b>
                  </td>

                  <td width="20%" align="center" class="grey">
                    บาท
                    <br />
                    Baht
                  </td>
                </tr>
              </table>
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
              <center>
                @if (!empty($receipt_val['file_att']))
                  {!!
                    $receipt_val[
                      'file_att'
                    ]
                  !!}
                @else
                  <img
                    src="{{ asset('images/infinite-c.png') }}"
                    alt=""
                    height="400"
                    class="my-5"
                  />
                @endif
              </center>
            </div>
          </div>
        </div>
      @endforeach
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
