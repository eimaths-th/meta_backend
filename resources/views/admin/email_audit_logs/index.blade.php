@extends('layouts.main_template')

@section('style')
  <style>
    .email-status {
      display: inline-block;
      min-width: 125px;
      padding: 0.35rem 0.55rem;
      border-radius: 0.35rem;
      font-size: 0.78rem;
      font-weight: 600;
      text-align: center;
    }

    .email-status.sent {
      color: #146c43;
      background: #d1e7dd;
    }

    .email-status.pending {
      color: #856404;
      background: #fff3cd;
    }

    .email-status.invalid {
      color: #842029;
      background: #f8d7da;
    }

    .email-status.na {
      color: #41464b;
      background: #e2e3e5;
    }

    .summary-card .card-body {
      min-height: 105px;
    }

    .summary-number {
      font-size: 1.65rem;
      font-weight: 700;
    }

    .audit-detail {
      max-width: 520px;
    }

    .audit-detail pre {
      max-height: 220px;
      margin: 0.5rem 0 0;
      padding: 0.75rem;
      overflow: auto;
      border-radius: 0.35rem;
      background: #f8f9fa;
      font-size: 0.75rem;
    }
  </style>
@endsection

@section('content')
  <div class="row">
    <div class="app-page-title">
      <div class="page-title-wrapper">
        <div class="page-title-heading">
          <div class="page-title-icon">
            <i class="pe-7s-mail icon-gradient bg-tempting-azure"></i>
          </div>
          <div>
            Email Audit Logs
            <div class="page-title-subheading">
              ตรวจสอบประวัติการส่งอีเมลยืนยันจากใบสมัคร
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row mb-3">
      <div class="col-md-4">
        <div class="main-card mb-3 card summary-card">
          <div class="card-body">
            <div class="text-muted">ใบสมัครทั้งหมด</div>
            <div class="summary-number">{{ number_format($summary['total']) }}</div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="main-card mb-3 card summary-card border-success">
          <div class="card-body">
            <div class="text-muted">มีประวัติส่งอีเมล</div>
            <div class="summary-number text-success">{{ number_format($summary['sent']) }}</div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="main-card mb-3 card summary-card border-warning">
          <div class="card-body">
            <div class="text-muted">ยังไม่มีประวัติส่ง</div>
            <div class="summary-number text-warning">{{ number_format($summary['without_send_log']) }}</div>
          </div>
        </div>
      </div>
    </div>

    <div class="main-card mb-3 card">
      <div class="card-body">
        <form method="GET" action="{{ route('email-audit-logs.index') }}">
          <div class="row g-2 align-items-end">
            <div class="col-md-3">
              <label for="search" class="form-label">ค้นหา</label>
              <input
                type="text"
                name="search"
                id="search"
                class="form-control"
                value="{{ request('search') }}"
                placeholder="ชื่อ, อีเมล หรือ ID ใบสมัคร"
              />
            </div>
            <div class="col-md-2">
              <label for="status" class="form-label">สถานะ</label>
              <select name="status" id="status" class="form-control">
                <option value="">ทั้งหมด</option>
                <option value="sent" @selected(request('status') === 'sent')>ส่งแล้ว</option>
                <option value="not_sent" @selected(request('status') === 'not_sent')>ยังไม่มีประวัติส่ง</option>
              </select>
            </div>
            <div class="col-md-2">
              <label for="sfield" class="form-label">ฟอร์ม</label>
              <select name="sfield" id="sfield" class="form-control">
                <option value="">ทุกฟอร์ม</option>
                @foreach ($formManages as $formManage)
                  <option value="{{ $formManage->sfield }}" @selected((string) request('sfield') === (string) $formManage->sfield)>
                    {{ $formManage->form_name }}
                  </option>
                @endforeach
              </select>
            </div>
            <div class="col-md-2">
              <label for="action" class="form-label">Action</label>
              <select name="action" id="action" class="form-control">
                <option value="">ทุก Action</option>
                @foreach ($actions as $action)
                  <option value="{{ $action }}" @selected(request('action') === $action)>{{ $action }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-1">
              <label for="from" class="form-label">จากวันที่</label>
              <input type="date" name="from" id="from" class="form-control" value="{{ request('from') }}" />
            </div>
            <div class="col-md-1">
              <label for="to" class="form-label">ถึงวันที่</label>
              <input type="date" name="to" id="to" class="form-control" value="{{ request('to') }}" />
            </div>
            <div class="col-md-1">
              <button type="submit" class="btn btn-primary w-100">
                <i class="fa fa-search"></i>
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>

    <div class="main-card mb-3 card">
      <div class="card-body">
        <div class="alert alert-info">
          <i class="fa fa-info-circle"></i>
          สถานะ “ส่งแล้ว” หมายถึงระบบเรียกส่งอีเมลสำเร็จและมี audit log แล้ว
          แต่หน้านี้ยังไม่ใช่การยืนยันว่าอีเมลเข้ากล่องผู้รับแล้วจริง ๆ
        </div>

        <div id="email-resend-feedback" role="status" aria-live="polite" hidden></div>

        <div class="table-responsive">
          <table class="table table-striped table-hover table-bordered align-middle">
            <thead>
              <tr>
                <th>สถานะ</th>
                <th>ใบสมัคร</th>
                <th>ผู้สมัคร</th>
                <th>ฟอร์ม</th>
                <th>อีเมลผู้รับ</th>
                <th>ส่งล่าสุด</th>
                <th>Action ล่าสุด</th>
                <th>รายละเอียด</th>
                <th>ส่งอีเมล</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($forms as $form)
                @php
                  $sendAudit = $form->last_email_send_audit;
                  $latestAudit = $form->latest_email_audit;
                  $isExcluded = in_array((string) $form->sfield, ['0', '17'], true);
                  $hasValidEmail = filter_var($form->email, FILTER_VALIDATE_EMAIL) !== false;
                  $status = $sendAudit ? 'sent' : ($isExcluded ? 'na' : (!$hasValidEmail ? 'invalid' : 'pending'));
                  $resendDisabledReason = null;

                  if (!in_array((int) auth()->user()->level, [0, 1, 3], true)) {
                    $resendDisabledReason = 'ไม่มีสิทธิ์ส่งอีเมล';
                  } elseif (optional($form->receipt)->cancle) {
                    $resendDisabledReason = 'ใบเสร็จถูกยกเลิกแล้ว';
                  } elseif ($isExcluded) {
                    $resendDisabledReason = 'ฟอร์มนี้ไม่รองรับการส่งซ้ำ';
                  } elseif (!$hasValidEmail) {
                    $resendDisabledReason = empty($form->email) ? 'ไม่มีอีเมลผู้รับ' : 'อีเมลผู้รับไม่ถูกต้อง';
                  }
                @endphp
                <tr>
                  <td>
                    @if ($status === 'sent')
                      <span class="email-status sent"><i class="fa fa-check-circle"></i> ส่งแล้ว</span>
                    @elseif ($status === 'na')
                      <span class="email-status na"><i class="fa fa-minus-circle"></i> ไม่เข้าเงื่อนไข</span>
                    @elseif ($status === 'invalid')
                      <span class="email-status invalid"><i class="fa fa-exclamation-circle"></i> {{ empty($form->email) ? 'ไม่มีอีเมล' : 'อีเมลไม่ถูกต้อง' }}</span>
                    @else
                      <span class="email-status pending"><i class="fa fa-clock"></i> ยังไม่มี log ส่ง</span>
                    @endif
                  </td>
                  <td>#{{ $form->id }}</td>
                  <td>{{ trim($form->first_name . ' ' . $form->last_name) }}</td>
                  <td>{{ optional($form->formManage)->form_name ?: 'sfield ' . $form->sfield }}</td>
                  <td>{{ $form->email ?: '-' }}</td>
                  <td>
                    @if ($sendAudit)
                      {{ optional($sendAudit->created_at)->format('d/m/Y H:i:s') }}
                      <div class="small text-muted">{{ $sendAudit->action }}</div>
                    @else
                      -
                    @endif
                  </td>
                  <td>
                    @if ($latestAudit)
                      <span class="badge bg-secondary">{{ $latestAudit->action }}</span>
                      <div class="small text-muted">{{ optional($latestAudit->created_at)->format('d/m/Y H:i:s') }}</div>
                    @else
                      -
                    @endif
                  </td>
                  <td>
                    @if ($form->emailAudits->isNotEmpty())
                      <details class="audit-detail">
                        <summary class="btn btn-sm btn-outline-primary">ดูประวัติ {{ $form->emailAudits->count() }} รายการ</summary>
                        <div class="mt-2">
                          @foreach ($form->emailAudits as $audit)
                            <div class="border rounded p-2 mb-2">
                              <strong>{{ $audit->action }}</strong>
                              <span class="text-muted">{{ optional($audit->created_at)->format('d/m/Y H:i:s') }}</span>
                              <br />
                              <span>{{ $audit->old_email ?: '-' }} &rarr; {{ $audit->new_email ?: '-' }}</span>
                              <br />
                              <span class="small text-muted">โดย {{ $audit->changed_by_name ?: 'Public User' }} | IP {{ $audit->ip_address ?: '-' }}</span>
                              @if ($audit->metadata)
                                <pre>{{ json_encode(json_decode($audit->metadata, true) ?: $audit->metadata, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                              @endif
                            </div>
                          @endforeach
                        </div>
                      </details>
                    @else
                      <span class="text-muted">ยังไม่มี Email Audit Log</span>
                    @endif
                  </td>
                  <td>
                    <button
                      type="button"
                      class="btn btn-sm btn-outline-primary text-nowrap email-resend-button"
                      data-url="{{ route('receipts_form.resend_mail', $form->id) }}"
                      data-form-id="{{ $form->id }}"
                      data-email="{{ $form->email }}"
                      data-has-sent="{{ $sendAudit ? '1' : '0' }}"
                      @disabled($resendDisabledReason !== null)
                    >
                      <i class="fa fa-envelope" aria-hidden="true"></i> ส่งอีเมลอีกครั้ง
                    </button>
                    @if ($resendDisabledReason)
                      <div class="small text-muted mt-1">{{ $resendDisabledReason }}</div>
                    @endif
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="9" class="text-center text-muted">ไม่พบข้อมูล</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        <div class="mt-3">
          {{ $forms->links() }}
        </div>
      </div>
    </div>
  </div>
@endsection

@section('script')
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const feedback = document.getElementById('email-resend-feedback');
      const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
      let sending = false;

      function showFeedback(message, type) {
        feedback.className = 'alert alert-' + type;
        feedback.textContent = message;
        feedback.hidden = false;
        feedback.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
      }

      document.querySelectorAll('.email-resend-button').forEach(function (button) {
        button.addEventListener('click', async function () {
          if (button.disabled || sending) return;

          const formId = button.dataset.formId;
          const email = button.dataset.email;
          const sentNotice = button.dataset.hasSent === '1'
            ? 'ใบสมัครนี้มีประวัติส่งอีเมลแล้ว ผู้รับจะได้รับอีเมลอีกฉบับ\n\n'
            : '';

          if (!window.confirm(sentNotice + 'ยืนยันส่งอีเมลใบสมัคร #' + formId + ' ไปยัง ' + email + ' อีกครั้ง?')) {
            return;
          }

          const originalContent = button.innerHTML;
          const enabledButtons = document.querySelectorAll('.email-resend-button:not(:disabled)');
          let sent = false;
          sending = true;
          enabledButtons.forEach(function (enabledButton) { enabledButton.disabled = true; });
          button.setAttribute('aria-busy', 'true');
          button.innerHTML = '<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> กำลังส่ง...';
          feedback.hidden = true;

          try {
            const response = await fetch(button.dataset.url, {
              method: 'POST',
              credentials: 'same-origin',
              headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': csrfToken
              }
            });
            const result = await response.json().catch(function () { return null; });

            if (response.status === 401 || response.status === 419) {
              throw new Error('เซสชันหมดอายุ กรุณารีเฟรชหน้าและเข้าสู่ระบบอีกครั้ง');
            }
            if (response.status === 403) {
              throw new Error('คุณไม่มีสิทธิ์ส่งอีเมลรายการนี้');
            }
            if (!response.ok || !result || result.status !== 'success') {
              throw new Error(result && result.message
                ? result.message
                : 'ตรวจสอบสถานะการส่งไม่ได้ กรุณารีเฟรชหน้าเพื่อตรวจประวัติก่อนส่งอีกครั้ง');
            }

            sent = true;
            showFeedback('ส่งอีเมลใบสมัคร #' + formId + ' ไปยัง ' + email + ' สำเร็จ กำลังอัปเดตประวัติ...', 'success');
            window.setTimeout(function () { window.location.reload(); }, 1500);
          } catch (error) {
            showFeedback(error instanceof TypeError
              ? 'การเชื่อมต่อขัดข้อง กรุณารีเฟรชหน้าเพื่อตรวจประวัติก่อนส่งอีกครั้ง'
              : error.message, 'danger');
          } finally {
            if (!sent) {
              sending = false;
              enabledButtons.forEach(function (enabledButton) { enabledButton.disabled = false; });
              button.removeAttribute('aria-busy');
              button.innerHTML = originalContent;
            }
          }
        });
      });
    });
  </script>
@endsection
