@php
  $displayName = trim(implode(' ', array_filter([
    $registration->first_name,
    $registration->middle_name,
    $registration->last_name,
  ])));
  $packageName = $registration->package ?: '-';
  $formName = optional($registration->formManage)->form_name ?: 'Registration Form';
@endphp

<div class="registration-details">
  <div class="details-heading">Registration Details</div>

  <div class="details-row">
    <div class="details-label">Registration ID</div>
    <div class="details-value">#{{ $registration->id }}</div>
  </div>
  <div class="details-row">
    <div class="details-label">Form</div>
    <div class="details-value">{{ $formName }}</div>
  </div>
  <div class="details-row">
    <div class="details-label">Submission Date</div>
    <div class="details-value">{{ optional($registration->created_at)->format('d/m/Y H:i') }}</div>
  </div>
  <div class="details-row">
    <div class="details-label">Name</div>
    <div class="details-value">{{ $displayName ?: '-' }}</div>
  </div>
  <div class="details-row">
    <div class="details-label">Nickname</div>
    <div class="details-value">{{ $registration->nick_name ?: '-' }}</div>
  </div>
  <div class="details-row">
    <div class="details-label">Gender</div>
    <div class="details-value">{{ $registration->gender ?: '-' }}</div>
  </div>
  <div class="details-row">
    <div class="details-label">Birth Date</div>
    <div class="details-value">{{ $registration->birth_date ?: '-' }}</div>
  </div>
  <div class="details-row">
    <div class="details-label">School</div>
    <div class="details-value">{{ $registration->school_name ?: '-' }}</div>
  </div>
  <div class="details-row">
    <div class="details-label">Grade</div>
    <div class="details-value">{{ $registration->grade ?: '-' }}</div>
  </div>
  <div class="details-row">
    <div class="details-label">Package</div>
    <div class="details-value">{{ $packageName }}</div>
  </div>
  @if ($registration->exam_mode)
    <div class="details-row">
      <div class="details-label">Exam Mode</div>
      <div class="details-value">{{ ucfirst($registration->exam_mode) }}</div>
    </div>
  @endif
  @if (!empty($awardValues))
    <div class="details-row">
      <div class="details-label">Award</div>
      <div class="details-value">{{ implode(', ', $awardValues) }}</div>
    </div>
  @endif
  <div class="details-row">
    <div class="details-label">Parent / Contact Name</div>
    <div class="details-value">{{ $registration->name_parent ?: '-' }}</div>
  </div>
  <div class="details-row">
    <div class="details-label">Address</div>
    <div class="details-value">
      {{ trim(implode(' ', array_filter([$registration->street_address, $registration->street_address2]))) ?: '-' }}
      @if ($registration->postcode)
        <br />Postcode: {{ $registration->postcode }}
      @endif
    </div>
  </div>
  <div class="details-row">
    <div class="details-label">Phone</div>
    <div class="details-value">{{ $registration->mobile ?: '-' }}</div>
  </div>
  <div class="details-row">
    <div class="details-label">Email</div>
    <div class="details-value">{{ $registration->email ?: '-' }}</div>
  </div>
  @if ($registration->referent_code)
    <div class="details-row">
      <div class="details-label">Referent Code</div>
      <div class="details-value">{{ $registration->referent_code }}</div>
    </div>
  @endif
  @if ($registration->news_form)
    <div class="details-row">
      <div class="details-label">News / Consent</div>
      <div class="details-value">{{ $registration->news_form }}</div>
    </div>
  @endif

  @if (!empty($photoImages))
    <div class="attachment-block">
      <div class="details-label">Applicant Photo</div>
      <div class="attachment-list">
        @foreach ($photoImages as $image)
          <img src="{{ $image }}" alt="Applicant photo" class="attachment-image applicant-image" />
        @endforeach
      </div>
    </div>
  @endif

  @if (!empty($fileImages))
    <div class="attachment-block">
      <div class="details-label">Supporting Document / Payment Slip</div>
      <div class="attachment-list">
        @foreach ($fileImages as $image)
          <img src="{{ $image }}" alt="Supporting document" class="attachment-image document-image" />
        @endforeach
      </div>
    </div>
  @endif
</div>
