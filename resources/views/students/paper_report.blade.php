<form class="form" action="{{ route('stdlog.store') }}" method="POST">
  @csrf
  <div class="modal-header">
    @php
      $timestamp = strtotime(date('F'));
      $formattedDate = thaidate('F', $timestamp);
    @endphp

    <h5 class="modal-title" id="exampleModalLongTitle">
      เพิ่มใบปะหน้า เดือน {{ $formattedDate }} {{ date('Y') }}
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

    <div class="form-group">
      <div class="row">
        <div class="col-lg-2">
          <label for="Name">เลขใบปะหน้า:</label>
        </div>
        <div class="col-lg-4">
          <input
            type="text"
            class="form-control"
            name="no_paper_report"
            id="no_paper_report"
            value=""
          />
        </div>
      </div>
    </div>
    <div class="form-group">
      <label for="Parent">Name student:</label>
      <br />
      <select
        style="width: 100%"
        class="select2 select2_single_paper form-control"
        name="std_receipt[]"
        multiple="multiple"
      >
        <!-- <option value="" selected>Select Student</option>
                    <option value="" selected>Select Parent</option>-->
        @foreach ($reportMonth_schoolPrice as $studentId => $groupedData)
          @foreach ($groupedData as $key => $data)
            <option
              value="{{ $data->std->id }},{{ $data->rec_school->id }},{{ $data->id }},{{ $data->rec_school->receipt_number }},{{ $data->rec_school->submission_date }}"
            >
              {{
                $data->std->code ??
                  'Null'
              }} {{
                $data->std->nick_name ??
                  'Null'
              }} | RecNo. : {{
                $data->rec_school
                  ->receipt_number
              }} | Group : {{ $data->group }}
            </option>
          @endforeach
        @endforeach
      </select>
    </div>
    {{--
      <div class="form-group my-3">
      <label for="Name">Code:
      {{ $newStudentCode }}
      </label>
      <input type="hidden" class="form-control" name="code" id="AddCode" value="">
      </div>
    --}}
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
