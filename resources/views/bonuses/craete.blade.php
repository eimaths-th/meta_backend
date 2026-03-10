<form action="{{ route('studentBonus.store') }}" method="post">
  @csrf
  <div class="modal-header">
    <h5 class="modal-title" id="exampleModalLongTitle">Add Bonus Student</h5>
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
      <div class="col-lg-6 mb-3">
        <div class="form-group">
          <label for="Student">Student :</label>
          <br />
          <select
            style="width: 100%"
            id="Bstudent_id"
            name="student_id"
            class="select2 select2_single form-control"
            multiple="multiple"
            required
          >
            @foreach ($students as $students)
              <option value="{{ $students->id }}">
                {{ $students->code }} {{ $students->full_name }} ({{ $students->nick_name }})
              </option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="col-lg-6 mb-3">
        <div class="form-group">
          <label for="Name">Reciept Details:</label>
          {{-- <input type="datetime-local" class="form-control" name="stime" id="stime" required> --}}
          <div class="input-group">
            <select
              style="width: 100%"
              class="select2 select2_single form-control"
              id="Bschoolp_id"
              name="schoolp_id"
              multiple="multiple"
              required
            >
              <option value="">Select User</option>
              {{--
                @foreach ($students as $studentss)
                <option value="{{ $studentss->id }}">{{ $studentss->code }} {{ $studentss->full_name }}
                ({{ $studentss->nick_name }})</option>
                @endforeach
              --}}
            </select>
          </div>
        </div>
      </div>

      <div class="col-lg-4 mb-3">
        <div class="form-group">
          <label for="Name">Bonus</label>
          <input type="number" class="form-control" name="bonus" id="bonus" />
        </div>
      </div>
    </div>
    {{--  --}}
    <textarea
      name="detail"
      id="detail"
      cols="30"
      rows="5"
      class="form-control"
      placeholder="หมายเหตุ"
    ></textarea>
    {{--
      <div class="form-group mt-3">
      <label for="Parent">Explain :</label><br>
      <textarea name="explain" class="form-control" id="explain" rows="5"></textarea>
      
      </div>
    --}}
    {{-- <input type="hidden" name="precursor_id" id="precursor_id" value="{{ auth()->user()->id }}"> --}}
  </div>
  <!-- Modal footer -->
  <div class="modal-footer">
    <button
      type="submit"
      class="btn btn-success"
      {{-- onclick="return confirm('Are you sure you want to delete this God?')" --}}
    >
      Save
    </button>
    <button
      type="button"
      class="btn btn-danger modelClose"
      data-bs-dismiss="modal"
    >
      Close
    </button>
  </div>
</form>
