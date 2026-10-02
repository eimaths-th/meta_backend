@extends ('layouts.main_template')

@section ('style')
  <link rel="stylesheet" href="{{ asset('css/forms-control.css') }}?v={{ filemtime(public_path('css/forms-control.css')) }}" />
  <script src="{{ asset('js/forms-control.js') }}?v={{ filemtime(public_path('js/forms-control.js')) }}" defer></script>
@endsection

@section ('content')
  @php
    $stateLabels = ['open' => 'Open', 'upcoming' => 'Upcoming', 'closed' => 'Closed'];
    $stateDescriptions = ['open' => 'เปิดรับสมัคร', 'upcoming' => 'รอเปิดรับสมัคร', 'closed' => 'ปิดรับสมัครแล้ว'];
  @endphp
  <section class="forms-control-page" aria-labelledby="forms-control-title">
    <header class="forms-control-heading">
      <div>
        <p class="forms-control-eyebrow">Registration Management</p>
        <h1 id="forms-control-title">SetTime Forms log</h1>
        <p class="forms-control-description">Manage registration schedules, applicants and receipts.<small class="forms-control-th" lang="th">จัดการเวลาเปิด–ปิดรับสมัคร ข้อมูลผู้สมัคร และใบเสร็จ</small></p>
      </div>
      @if ($canManageForms)
        <div class="forms-control-heading-actions">
          <a class="forms-control-button" href="{{ route('form-manage.index') }}"><span>Manage Forms<small class="forms-control-th" lang="th">จัดการฟอร์มทั้งหมด</small></span></a>
          <button class="forms-control-button forms-control-button-primary" type="button" onclick="formModal('{{ route('formsTimes') }}')">
            <i class="fas fa-clock" aria-hidden="true"></i><span>Set Time<small class="forms-control-th" lang="th">กำหนดเวลาเปิด–ปิด</small></span>
          </button>
        </div>
      @endif
    </header>

    @if ($message = session('success'))
      <div class="alert alert-success" role="status">{{ $message }}</div>
    @endif
    @if ($message = session('error'))
      <div class="alert alert-danger" role="alert">{{ $message }}</div>
    @endif
    @if ($errors->any())
      <div class="alert alert-danger" role="alert">
        <strong>Please check the schedule.</strong>
        <small class="d-block" lang="th">ยังไม่ได้บันทึก กรุณาตรวจสอบวันและเวลาแล้วลองอีกครั้ง</small>
        <ul class="mb-0">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <div class="forms-control-panel">
      <div class="forms-control-filters">
        <div class="forms-control-search">
          <label for="forms-control-search">Search Forms<small class="forms-control-th" lang="th">ค้นหาจากชื่อฟอร์มหรือ URL</small></label>
          <input type="search" id="forms-control-search" placeholder="Form name or URL" autocomplete="off" />
        </div>
        <div>
          <label for="forms-control-state">Status<small class="forms-control-th" lang="th">เลือกสถานะการรับสมัคร</small></label>
          <select id="forms-control-state">
            <option value="all">All statuses</option>
            @foreach ($stateLabels as $value => $label)
              <option value="{{ $value }}">{{ $label }}</option>
            @endforeach
          </select>
        </div>
        <p class="forms-control-count" id="forms-control-count" aria-live="polite">{{ $entries->count() }} forms</p>
      </div>
      <table class="forms-control-table">
        <caption>Latest schedule per form · Open forms first · Bangkok time (UTC+7)<small class="forms-control-th" lang="th">แสดงกำหนดเวลาล่าสุดของแต่ละฟอร์ม เรียงฟอร์มที่เปิดรับสมัครก่อน โดยใช้เวลาไทย</small></caption>
        <thead>
          <tr>
            <th scope="col" class="forms-control-form-column">Form<small class="forms-control-th" lang="th">ฟอร์มสมัคร</small></th>
            <th scope="col" class="forms-control-url-column">URL<small class="forms-control-th" lang="th">ลิงก์ลงทะเบียน</small></th>
            <th scope="col" class="forms-control-status-column">Status<small class="forms-control-th" lang="th">สถานะ</small></th>
            <th scope="col" class="forms-control-date-column">Opens at<small class="forms-control-th" lang="th">วันและเวลาเปิดรับสมัคร</small></th>
            <th scope="col" class="forms-control-date-column">Closes at<small class="forms-control-th" lang="th">วันและเวลาปิดรับสมัคร</small></th>
            <th scope="col" class="forms-control-actions-column">Actions<small class="forms-control-th" lang="th">จัดการ</small></th>
          </tr>
        </thead>
        <tbody>
          @foreach ($entries as $entry)
            <tr data-form-entry data-state="{{ $entry['state'] }}" data-search="{{ $entry['name'] . ' ' . $entry['route'] . ' ' . ($entry['public_url'] ?? '') }}">
              <td class="forms-control-name">
                <strong>{{ $entry['name'] }}</strong>
                @if ($entry['comments'])
                  <p class="forms-control-note">{{ $entry['comments'] }}</p>
                @endif
                @if ($entry['history']->isNotEmpty())
                  <details class="forms-control-history">
                    <summary>Schedule history ({{ $entry['history']->count() }})<small class="forms-control-th" lang="th">ประวัติการกำหนดเวลา</small></summary>
                    <ul>
                      @foreach ($entry['history'] as $previous)
                        <li>{{ \Carbon\Carbon::parse($previous->opening_time)->format('d/m/Y H:i') }} – {{ \Carbon\Carbon::parse($previous->closing_time)->format('d/m/Y H:i') }}@if ($previous->comments)<br />{{ $previous->comments }}@endif</li>
                      @endforeach
                    </ul>
                  </details>
                @endif
              </td>
              <td class="forms-control-url-cell">
                <span class="forms-control-mobile-label">URL<small class="forms-control-th" lang="th">ลิงก์ลงทะเบียน</small></span>
                @if ($entry['public_url'])
                  <a class="forms-control-public-link" href="{{ $entry['public_url'] }}" target="_blank" rel="noopener noreferrer">{{ $entry['public_url'] }}</a>
                @else
                  <span class="forms-control-muted">Not linked<small class="forms-control-th" lang="th">ไม่พบหน้าลงทะเบียนที่เชื่อมโยง</small></span>
                  <code class="forms-control-route">Route: {{ $entry['route'] }}</code>
                @endif
              </td>
              <td class="forms-control-status-cell">
                <span class="forms-control-mobile-label">Status</span>
                <span class="forms-control-status forms-control-status-{{ $entry['state'] }}">{{ $stateLabels[$entry['state']] }}</span>
                <small class="forms-control-th" lang="th">{{ $stateDescriptions[$entry['state']] }}</small>
              </td>
              <td>
                <span class="forms-control-mobile-label">Opens at<small class="forms-control-th" lang="th">เปิดรับสมัคร</small></span>
                <time datetime="{{ $entry['opening']->toIso8601String() }}">{{ $entry['opening']->format('d/m/Y') }}<small>{{ $entry['opening']->format('H:i') }}</small></time>
              </td>
              <td>
                <span class="forms-control-mobile-label">Closes at<small class="forms-control-th" lang="th">ปิดรับสมัคร</small></span>
                <time datetime="{{ $entry['closing']->toIso8601String() }}">{{ $entry['closing']->format('d/m/Y') }}<small>{{ $entry['closing']->format('H:i') }}</small></time>
              </td>
              <td class="forms-control-actions-cell">
                @if ($canManageForms && $entry['form'])
                  <nav class="forms-control-row-actions" aria-label="Actions for {{ $entry['name'] }}">
                    <a href="{{ route('create-form', ['id' => $entry['form']->id]) }}"><span>Manage Form<small class="forms-control-th" lang="th">จัดการฟอร์ม</small></span></a>
                    @if (filled($entry['form']->sfield))
                      <a href="{{ route('receipts_form', ['sfield' => $entry['form']->sfield]) }}"><span>Applicants<small class="forms-control-th" lang="th">ดูผู้สมัคร</small></span></a>
                      <a href="{{ route('receipts', ['sfield' => $entry['form']->sfield]) }}"><span>Receipts<small class="forms-control-th" lang="th">จัดการใบเสร็จ</small></span></a>
                    @endif
                  </nav>
                @else
                  <span class="forms-control-muted">—</span>
                @endif
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
      <div class="forms-control-empty" id="forms-control-empty" @if ($entries->isNotEmpty()) hidden @endif>
        <strong>{{ $entries->isEmpty() ? 'No registration schedules yet' : 'No matching forms' }}</strong>
        <p>{{ $entries->isEmpty() ? 'Create a form, then set its opening and closing times.' : 'Try another search or select a different status.' }}</p>
        <small class="forms-control-th" lang="th">{{ $entries->isEmpty() ? 'เริ่มจากสร้างฟอร์ม แล้วกำหนดเวลาเปิด–ปิดรับสมัคร' : 'ไม่พบรายการ ลองเปลี่ยนคำค้นหาหรือสถานะ' }}</small>
      </div>
    </div>
  </section>
@endsection
