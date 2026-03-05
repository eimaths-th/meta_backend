{{--
  <!DOCTYPE html>
  <html>
  <head>
  <title>Route Control</title>
  </head>
  <body>
  <h1>Route Control Page</h1>
  
  <form action="{{ route('save_times') }}" method="post">
  @csrf
  
  <label for="route">Route:</label>
  <select name="route" id="route">
  <!-- Populate options with your route names -->
  <option value="gmec">gmec</option>
  <option value="olpcs">olpcs</option>
  <option value="asiarope">asiarope</option>
  <option value="gelosea">gelosea</option>
  <option value="imocsea">imocsea</option>
  <option value="isocsea">isocsea</option>
  <option value="imocsea+isocsea">imocsea+isocsea</option>
  <option value="cambridge">cambridge</option>
  
  </select>
  
  <label for="opening_time">Opening Time:</label>
  <input type="datetime-local" name="opening_time" id="opening_time">
  
  <label for="closing_time">Closing Time:</label>
  <input type="datetime-local" name="closing_time" id="closing_time">
  
  <button type="submit">Set Times</button>
  </form>
  </body>
  </html>
--}}
<form action="{{ route('Godeye.store') }}" method="post">
  @csrf
  <div class="modal-header">
    <h5 class="modal-title" id="exampleModalLongTitle">Select God</h5>
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
      <div class="col-lg-4">
        <div class="form-group">
          <label for="Parent">Next God :</label>
          <br />
          <select
            style="width: 100%"
            class="form-control"
            id="user_id"
            name="user_id"
            required
          >
            <option value="">Select God</option>
            @foreach ($users as $user)
              <option value="{{ $user->id }}">{{ $user->name }}</option>
            @endforeach
          </select>
        </div>
      </div>
    </div>
    <div class="form-group mt-3">
      <label for="Parent">Explain :</label>
      <br />
      <textarea
        name="explain"
        class="form-control"
        id="explain"
        rows="5"
      ></textarea>
    </div>
    <input
      type="hidden"
      name="precursor_id"
      id="precursor_id"
      value="{{ auth()->user()->id }}"
    />
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
