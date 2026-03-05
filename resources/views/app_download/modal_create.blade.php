<form
  class="form"
  action="{{ route('app-down-load.store') }}"
  method="POST"
  enctype="multipart/form-data"
>
  @csrf
  <div class="modal-header">
    <h5 class="modal-title" id="exampleModalLongTitle">Add New App</h5>
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
      <label for="file">Upload File:</label>
      <input type="file" class="form-control" id="file" name="file" />
    </div>

    <div class="form-group">
      <label for="Name">Name:</label>
      <input
        type="text"
        class="form-control"
        name="name"
        id="AddName"
        value=""
      />
    </div>
    <div class="form-group">
      <label for="Name">Version:</label>
      <input
        type="text"
        class="form-control"
        name="version"
        id="AddLastname"
        value=""
      />
    </div>
    <div class="form-group">
      <label for="Name">Type:</label>
      <input
        type="text"
        class="form-control"
        name="type"
        id="AddNickname"
        value=""
      />
    </div>
  </div>
  <!-- Modal footer -->
  <div class="modal-footer">
    <button type="submit" class="btn btn-success" id="SubmitCreateForm">
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
