<form action="#" method="post">
  @csrf
  <div class="modal-header">
    <h5 class="modal-title" id="exampleModalLongTitle">Generate Code</h5>
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
      <div class="col-lg-6">
        <div class="form-group">
          <label for="Name">Referent Name:</label>
          <input
            type="text"
            class="form-control"
            name="referent_name"
            id="Addreferent_name"
            required
          />

          <small class="form-text text-danger">
            * ตัวอย่าง : นายสมชาย สมสิงห์
          </small>
        </div>
      </div>
    </div>
    <div class="form-group mt-3">
      <label for="Parent">Explain :</label>
      <br />
      <textarea
        name="comments"
        class="form-control"
        id="Addcomments"
        rows="5"
      ></textarea>
    </div>
    <input
      type="hidden"
      name="user_id"
      id="user_id"
      value="{{ auth()->user()->id }}"
    />
  </div>
  <!-- Modal footer -->
  <div class="modal-footer">
    <button type="button" onclick="referent_codeSave()" class="btn btn-success">
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
