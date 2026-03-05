<form class="form" action="" method="POST">
  @csrf
  <div class="modal-header">
    <h5 class="modal-title" id="exampleModalLongTitle">
      น้อง {{ $std->nick_name }}
    </h5>
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

    @foreach ($rec_sch as $key => $rec)
      @php
        $matchingRecords = $school_pice->where('rid', $rec->id);
      @endphp

      @if ($matchingRecords->isNotEmpty())
        @php
          // dd($matchingRecords);
        @endphp

        <div class="row mb-5">
          <label for="Name">ใบเสร็จลำดับที่ {{ $key + 1 }}.</label>

          <div class="col-lg-4">
            <div class="form-group">
              <label for="Name">
                Date Submission: {{ $rec->submission_date }}
              </label>
              <br />
              @foreach ($matchingRecords as $record)
                <label for="Name">Group: {{ $record->group }}</label>
                <br />
              @endforeach
            </div>
          </div>
          <div class="col-lg-4">
            <div class="form-group">
              <label for="Name">
                Receipt Number: {{ $rec->receipt_number }}
              </label>
              <br />
              @foreach ($matchingRecords as $record)
                <label for="Name">ระยะเวลา {{ $record->period }}</label>
                <br />
              @endforeach
            </div>
          </div>
          <div class="col-lg-4">
            <div class="form-group">
              <label for="Name">จำนวนเดือนที่สมัคร</label>
              <br />
              @foreach ($matchingRecords as $record)
                <label for="Name">{{ $record->qty }} เดือน</label>
                <br />
              @endforeach
            </div>
          </div>
        </div>
      @endif
    @endforeach

    {{--
      <div class="form-group">
      <label for="Name">Name:</label>
      <input type="text" class="form-control" name="name" id="AddName" value="">
      </div>
      <div class="form-group">
      <label for="Name">Lastname:</label>
      <input type="text" class="form-control" name="lastname" id="AddLastname" value="">
      </div>
      <div class="form-group">
      <label for="Name">Nickname:</label>
      <input type="text" class="form-control" name="nick_name" id="AddNickname" value="">
      </div>
      <div class="form-group">
      <label for="Name">Mobile:</label>
      <input type="text" class="form-control" name="mobile" id="AddMobile" value="">
      </div>
      <div class="form-group">
      <label for="Name">Grade:</label>
      <input type="text" class="form-control" name="grade" id="AddGrade" value="">
      </div>
    --}}
  </div>
  <!-- Modal footer -->
  <div class="modal-footer">
    {{-- <button type="button" class="btn btn-success" id="SubmitCreateForm">Save</button> --}}
    <button
      type="button"
      class="btn btn-danger modelClose"
      data-bs-dismiss="modal"
    >
      Close
    </button>
  </div>
</form>
