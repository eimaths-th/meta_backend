<form class="form" action="" method="POST">
  @csrf
  <div class="modal-header">
    <h5 class="modal-title" id="exampleModalLongTitle">Add Student</h5>
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
      <label for="Parent">Name Parent:</label>
      <br />
      <select
        style="width: 100%"
        class="select2test form-control"
        id="AddParent"
        name="name_parent"
        multiple="multiple"
      >
        <!-- <option value="" selected>Select Student</option>
                                                                                                                                                        <option value="" selected>Select Parent</option>-->
        @foreach ($data4 as $key2)
          <option value="{{ $key2->id }}">
            {{ $key2->code }} {{ $key2->name_parent }}
          </option>
        @endforeach
      </select>
    </div>
    <div class="form-group my-3">
      <label for="Name">Code: {{ $newStudentCode }}</label>
      <input
        type="hidden"
        class="form-control"
        name="code"
        id="AddCode"
        value=""
      />
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
      <label for="Name">Lastname:</label>
      <input
        type="text"
        class="form-control"
        name="lastname"
        id="AddLastname"
        value=""
      />
    </div>
    <div class="form-group">
      <label for="Name">Nickname:</label>
      <input
        type="text"
        class="form-control"
        name="nick_name"
        id="AddNickname"
        value=""
      />
    </div>
    <div class="form-group">
      <label for="Name">Mobile:</label>
      <input
        type="text"
        class="form-control"
        name="mobile"
        id="AddMobile"
        value=""
      />
    </div>
    <div class="form-group">
      <label for="Name">Grade:</label>
      <input
        type="text"
        class="form-control"
        name="grade"
        id="AddGrade"
        value=""
      />
    </div>
  </div>
  <!-- Modal footer -->
  <div class="modal-footer">
    <button type="button" class="btn btn-success" id="SubmitCreateForm">
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
