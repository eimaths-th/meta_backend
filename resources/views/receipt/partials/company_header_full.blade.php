{{--
  Receipt Company Header Partial — Full Layout (6 rows)
  ======================================================
  ใช้สำหรับ template ที่ต้องการ layout แบบเต็ม (logo ใหญ่ + ช่องว่างด้านล่าง)
  เช่น printr_meta, viewr_meta

  การใช้งาน:
    @include('receipt.partials.company_header_full', ['company' => $company])
--}}

@php
  $logoHeight = $logoHeight ?? 150;
  $companyName = $company['name_en'] ?? $company['name_th'] ?? 'META KNOWLEDGE CO., LTD.';
  $companyAddress = $company['address'] ?? '555/9 ม.1 ต.บางขนุน อ.บางกรวย จ.นนทบุรี 11130';
  $companyTaxId = $company['tax_id'] ?? '0125565026368';
  $companyPhone = $company['phone'] ?? '093-358-6333';
  $companyLogo = $company['logo'] ?? 'images/logo_meta.png';
@endphp

<thead>
  <tr>
    <td width="25%" rowspan="6" align="center">
      <img
        src="{{ asset($companyLogo) }}"
        alt="{{ $companyName }}"
        height="{{ $logoHeight }}"
        style="padding-bottom: 5px"
      />
    </td>
  </tr>
  <tr>
    <td style="vertical-align: top" height="5px">
      {{ $companyName }}
    </td>
  </tr>
  <tr>
    <td style="vertical-align: top" height="5px">
      {{ $companyAddress }}
    </td>
  </tr>
  <tr>
    <td style="vertical-align: top" height="5px">
      เลขประจำตัวผู้เสียภาษี: {{ $companyTaxId }}
    </td>
  </tr>
  <tr>
    <td style="vertical-align: top" height="5px">
      โทร {{ $companyPhone }}
    </td>
  </tr>
  <tr>
    <td style="vertical-align: top" height="50px"></td>
  </tr>
</thead>
