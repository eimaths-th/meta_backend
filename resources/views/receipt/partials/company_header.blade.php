{{--
  Receipt Company Header Partial
  ================================
  ใช้แสดงข้อมูลบริษัทบนใบเสร็จ ดึงจาก config/receipt.php

  การใช้งาน:
    @include('receipt.partials.company_header', ['company' => $company])

  หรือถ้าต้องการระบุ layout (เช่น สำหรับ print ใช้ width ต่างกัน):
    @include('receipt.partials.company_header', ['company' => $company, 'logoHeight' => 106])

  ตัวแปร $company ต้องเป็น array ที่มี keys: name_en, name_th, address, tax_id, phone, logo
--}}

@php
  $logoHeight = $logoHeight ?? 106;
  $companyName = $company['name_en'] ?? 'META KNOWLEDGE CO., LTD.';
  $companyAddress = $company['address'] ?? '555/9 ม.1 ต.บางขนุน อ.บางกรวย จ.นนทบุรี 11130';
  $companyTaxId = $company['tax_id'] ?? '0125565026368';
  $companyPhone = $company['phone'] ?? '093-358-6333';
  $companyLogo = $company['logo'] ?? 'images/logo_meta.png';
@endphp

<thead>
  <tr>
    <td width="15%" rowspan="4">
      <img
        src="{{ asset($companyLogo) }}"
        alt="{{ $companyName }}"
        height="{{ $logoHeight }}"
        style="padding-bottom: 5px"
      />
    </td>
    <td>{{ $companyName }}</td>
  </tr>
  <tr>
    <td>{{ $companyAddress }}</td>
  </tr>
  <tr>
    <td>เลขประจำตัวผู้เสียภาษี: {{ $companyTaxId }}</td>
  </tr>
  <tr>
    <td>โทร {{ $companyPhone }}</td>
  </tr>
</thead>
