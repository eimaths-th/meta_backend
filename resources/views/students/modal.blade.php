<div
  class="fade modal"
  tabindex="-1"
  role="dialog"
  aria-labelledby="myLargeModalLabel"
  aria-hidden="true"
  id="EditModal"
>
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">
          Check Record of Receipt
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
          <strong>Success!</strong>
          Users was edit successfully.
          <button
            type="button"
            class="btn-close"
            data-dismiss="alert"
            aria-label="Close"
          >
            <span aria-hidden="true"></span>
          </button>
        </div>
        <div id="EditModalBody"></div>
      </div>
      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-success" id="SubmitEditForm">
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
    </div>
  </div>
</div>
