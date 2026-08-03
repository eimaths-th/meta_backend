@php
  $displayName = trim(implode(' ', array_filter([
    $registration->first_name,
    $registration->middle_name,
    $registration->last_name,
  ])));
  $formName = optional($registration->formManage)->form_name ?: 'Registration Form';
  $address = trim(implode(' ', array_filter([
    $registration->street_address,
    $registration->street_address2,
  ])));
@endphp

<table class="details-table">
  <tr><th colspan="2">Registration Details</th></tr>
  <tr><td>Registration ID</td><td>#{{ $registration->id }}</td></tr>
  <tr><td>Form</td><td>{{ $formName }}</td></tr>
  <tr><td>Submission Date</td><td>{{ optional($registration->created_at)->format('d/m/Y H:i') }}</td></tr>
  <tr><td>Name</td><td>{{ $displayName ?: '-' }}</td></tr>
  <tr><td>Nickname</td><td>{{ $registration->nick_name ?: '-' }}</td></tr>
  <tr><td>Gender</td><td>{{ $registration->gender ?: '-' }}</td></tr>
  <tr><td>Birth Date</td><td>{{ $registration->birth_date ?: '-' }}</td></tr>
  <tr><td>School</td><td>{{ $registration->school_name ?: '-' }}</td></tr>
  <tr><td>Grade</td><td>{{ $registration->grade ?: '-' }}</td></tr>
  <tr><td>Package</td><td>{{ $registration->package ?: '-' }}</td></tr>
  @if ($registration->exam_mode)
    <tr><td>Exam Mode</td><td>{{ ucfirst($registration->exam_mode) }}</td></tr>
  @endif
  @if (!empty($awardValues))
    <tr><td>Award</td><td>{{ implode(', ', $awardValues) }}</td></tr>
  @endif
  <tr><td>Parent / Contact Name</td><td>{{ $registration->name_parent ?: '-' }}</td></tr>
  <tr>
    <td>Address</td>
    <td>
      {{ $address ?: '-' }}
      @if ($registration->postcode)
        <br />Postcode: {{ $registration->postcode }}
      @endif
    </td>
  </tr>
  <tr><td>Phone</td><td>{{ $registration->mobile ?: '-' }}</td></tr>
  <tr><td>Email</td><td>{{ $registration->email ?: '-' }}</td></tr>
  @if ($registration->referent_code)
    <tr><td>Referent Code</td><td>{{ $registration->referent_code }}</td></tr>
  @endif
  @if ($registration->news_form)
    <tr><td>News / Consent</td><td>{{ $registration->news_form }}</td></tr>
  @endif
</table>

@if (!empty($photoImages))
  <div class="attachment-block">
    <div class="attachment-label">Applicant Photo</div>
    @foreach ($photoImages as $image)
      <img src="{{ $image }}" alt="Applicant photo" class="attachment-image applicant-image" />
    @endforeach
  </div>
@endif

@if (!empty($fileImages))
  <div class="attachment-block">
    <div class="attachment-label">Supporting Document / Payment Slip</div>
    @foreach ($fileImages as $image)
      <img src="{{ $image }}" alt="Supporting document" class="attachment-image document-image" />
    @endforeach
  </div>
@endif
