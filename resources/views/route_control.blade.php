<form action="{{ route('save_times') }}" method="post" data-schedule-form>
  @csrf
  <div class="modal-header">
    <h5 class="modal-title">Set Time<small class="d-block text-muted" lang="th">กำหนดเวลาเปิด–ปิดรับสมัคร</small></h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
  </div>
  <div class="modal-body">
    <div class="alert alert-danger" role="alert" tabindex="-1" data-schedule-errors hidden>
      <strong>Please check the schedule.</strong>
      <small class="d-block" lang="th">ยังไม่ได้บันทึก กรุณาตรวจสอบข้อมูลด้านล่างแล้วลองอีกครั้ง</small>
      <ul class="mb-0 mt-2" data-schedule-error-list></ul>
    </div>
    <div class="row">
      <div class="col-lg-4">
        <div class="form-group">
          <label for="route">Form</label>
          <select class="form-control" id="route" name="route" required>
            <option value="">Select a form</option>
            <option value="spelling-bee-islo">spelling-bee-islo</option>
            <option value="advance_english_grammar">advance_english_grammar</option>
            <option value="admin-test-field">admin-test-field</option>
            <option value="isocsea-imocsea-national-round">isocsea-imocsea-national-round</option>
            <option value="isocsea-imocsea-national-round-2025">isocsea-imocsea-national-round-2025</option>
            @foreach ($formRoutes as $formRoute)
              <option value="{{ $formRoute->slug }}" @selected(old('route') === $formRoute->slug)>{{ $formRoute->form_name }}</option>
            @endforeach
          </select>
          <small class="form-text text-muted" lang="th">เลือกฟอร์มที่ต้องการกำหนดเวลา</small>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="form-group">
          <label for="opening_time">Opening Time</label>
          <input type="datetime-local" class="form-control" name="opening_time" id="opening_time" value="{{ old('opening_time') }}" required />
          <small class="form-text text-muted" lang="th">วันและเวลาเริ่มรับสมัคร ตามเวลาไทย</small>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="form-group">
          <label for="closing_time">Closing Time</label>
          <input type="datetime-local" class="form-control" name="closing_time" id="closing_time" value="{{ old('closing_time') }}" min="{{ old('opening_time') }}" required aria-describedby="closing-time-help" />
          <small class="form-text text-muted" id="closing-time-help" lang="th">วันและเวลาปิดรับสมัคร ต้องไม่อยู่ก่อนเวลาเปิด</small>
        </div>
      </div>
    </div>
    <div class="form-group mt-3">
      <label for="comments">Notes<small class="d-block text-muted" lang="th">คำอธิบายเพิ่มเติม (ถ้ามี)</small></label>
      <textarea name="comments" class="form-control" id="comments" rows="3">{{ old('comments') }}</textarea>
    </div>
  </div>
  <div class="modal-footer">
    <button type="submit" class="btn btn-success">Save</button>
    <button type="button" class="btn btn-danger modelClose" data-bs-dismiss="modal">Close</button>
  </div>
</form>
