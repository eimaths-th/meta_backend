<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <style>
    @page { margin: 28px 34px; }
    body { color: #263238; font-family: DejaVu Sans, sans-serif; font-size: 10px; }
    .header { border-bottom: 4px solid #ff9800; margin-bottom: 18px; padding-bottom: 12px; }
    .logo { display: block; height: 48px; margin-bottom: 6px; }
    .brand { color: #f57c00; font-size: 22px; font-weight: bold; }
    .title { color: #263238; font-size: 17px; font-weight: bold; margin-top: 5px; }
    .subtitle { color: #607d8b; font-size: 9px; margin-top: 4px; }
    .details-table { border: 1px solid #d9e0e5; border-collapse: collapse; width: 100%; }
    .details-table th { background: #fff3e0; border-bottom: 1px solid #ffb74d; color: #e65100; font-size: 12px; padding: 9px 10px; text-align: left; }
    .details-table td { border-bottom: 1px solid #e6eaed; padding: 7px 9px; vertical-align: top; }
    .details-table td:first-child { background: #f4f6f8; color: #455a64; font-weight: bold; width: 34%; }
    .attachment-block { border-top: 1px solid #e6eaed; page-break-inside: avoid; padding: 9px; }
    .attachment-label { color: #455a64; font-weight: bold; margin-bottom: 7px; }
    .attachment-image { display: block; page-break-inside: avoid; margin: 4px 0; max-width: 210px; }
    .applicant-image { max-height: 220px; }
    .document-image { max-height: 330px; }
    .footer { color: #78909c; font-size: 8px; margin-top: 15px; text-align: center; }
  </style>
</head>
<body>
  <div class="header">
    @if ($logoImage)
      <img src="{{ $logoImage }}" alt="META Knowledge" class="logo" />
    @endif
    <div class="brand">META Knowledge</div>
    <div class="title">{{ optional($registration->formManage)->form_name ?: 'Registration Form' }}</div>
    <div class="subtitle">Registration confirmation - ID #{{ $registration->id }}</div>
  </div>

  @include('receipt_form._registration_details_pdf')

  <div class="footer">This document contains the registration information submitted through the online form.</div>
</body>
</html>
