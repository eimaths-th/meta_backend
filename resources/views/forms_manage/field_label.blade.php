@php
  $fieldLabelParts = preg_split('/\s+\/\s+/', trim($fieldLabel ?? ''), 2);
  $fieldLabelPrimary = $fieldLabelParts[0];
  $fieldLabelSecondary = '';
  // Reorder only clearly bilingual labels. Custom single-language text stays intact.
  if (count($fieldLabelParts) === 2 &&
      !preg_match('/[\x{0E00}-\x{0E7F}]/u', $fieldLabelParts[0]) &&
      preg_match('/[\x{0E00}-\x{0E7F}]/u', $fieldLabelParts[1])) {
    $fieldLabelPrimary = $fieldLabelParts[1];
    $fieldLabelSecondary = $fieldLabelParts[0];
  } else {
    $fieldLabelPrimary = $fieldLabel ?? '';
  }
@endphp
{{ $fieldLabelPrimary }}
@if ($fieldRequired ?? false)
  <span class="form-required">*</span>
@endif
@if ($fieldLabelSecondary !== '')
  <span class="registration-field-translation">{{ $fieldLabelSecondary }}</span>
@endif
