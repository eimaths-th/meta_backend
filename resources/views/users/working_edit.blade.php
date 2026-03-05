<form action="{{ route('recordtime.update', [$rect->id]) }}" method="post">
  @method('PUT')
  @csrf
  <div class="modal-header">
    <h5 class="modal-title" id="exampleModalLongTitle">Add Record Time</h5>
    <button
      type="button"
      class="btn-close"
      data-bs-dismiss="modal"
      aria-label="Close"
    ></button>
  </div>
  <!-- Modal body -->
  <div class="modal-body">
    <div
      class="alert alert-danger alert-dismissible fade show"
      role="alert"
      style="display: none"
    >
      <button
        type="button"
        class="btn-close"
        data-dismiss="alert"
        aria-label="Close"
      >
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div
      class="alert alert-success alert-dismissible fade show"
      role="alert"
      style="display: none"
    >
      <button
        type="button"
        class="btn-close"
        data-dismiss="alert"
        aria-label="Close"
      >
        <span aria-hidden="true"></span>
      </button>
    </div>

    <div class="row">
      <div class="col-lg-4 mb-3">
        <div class="form-group">
          <label for="Parent">User :</label>
          <br />
          <input
            type="text"
            class="form-control"
            value="{{ $rect->user->name }}"
            disabled
          />
          {{--
            <input type="hidden" id="user_id" name="user_id" class="form-control" value="{{ $rect->user->id }}">
            <input type="hidden" id="approv_id" name="approv_id" class="form-control" value="{{ auth()->user()->id }}">
          --}}
        </div>
      </div>
      <div class="col-lg-4 mb-3">
        <div class="form-group">
          <label for="Name">Date:</label>
          {{-- <input type="datetime-local" class="form-control" name="stime" id="stime" required> --}}
          <div class="input-group">
            <input
              type="text"
              name="date"
              autocomplete="off"
              class="form-control"
              id="datepicker-autoClose"
              value="{{ $rect->date }}"
            />
            <span class="input-group-text input-group-addon">
              <i class="fa fa-calendar"></i>
            </span>
          </div>
        </div>
      </div>

      <div class="col-lg-4 mb-3">
        <div class="form-group">
          <label for="Name">Status</label>
          <select name="status" id="status" class="form-control" required>
            <option value="{{ $rect->status }}">
              {{ $rect->status_name }}
            </option>
            <option value="">เลือก สถานะการมาทำงาน</option>

            <option value="1">ปกติ</option>
            <option value="2">ลาป่วย</option>
            <option value="3">ลาพักร้อน</option>
            <option value="4">ลากิจ</option>
            <option value="10">วันหยุด</option>
            <option value="11">OT</option>
            <option value="12">ชดเชย</option>
            <option value="13">ขาดงาน</option>
          </select>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-6 mb-3">
        <div class="form-group">
          <label for="Name">Start Time:</label>
          {{-- <input type="datetime-local" class="form-control" name="stime" id="stime" required> --}}
          <div class="input-group bootstrap-timepicker">
            <input
              id="stime"
              name="stime"
              type="text"
              class="form-control timepicker"
              value="{{ $rect->stime }}"
            />
            <span class="input-group-text input-group-addon">
              <i class="fa fa-clock"></i>
            </span>
          </div>
        </div>
      </div>
      <div class="col-lg-6 mb-3">
        <div class="form-group">
          <label for="Name">End Time:</label>
          <div class="input-group bootstrap-timepicker">
            <input
              id="etime"
              name="etime"
              type="text"
              class="form-control timepicker"
              value="{{ $rect->etime }}"
            />
            <span class="input-group-text input-group-addon">
              <i class="fa fa-clock"></i>
            </span>
          </div>
        </div>
      </div>
    </div>
    <textarea
      name="explain"
      id="explain"
      cols="30"
      rows="5"
      class="form-control"
      placeholder="หมายเหตุ"
    >
{{ $rect->explain }}</textarea
    >
  </div>
  <!-- Modal footer -->
  <div class="modal-footer">
    <button type="submit" class="btn btn-success">Save</button>
    <button
      type="button"
      class="btn btn-danger modelClose"
      data-bs-dismiss="modal"
    >
      Close
    </button>
  </div>
</form>
