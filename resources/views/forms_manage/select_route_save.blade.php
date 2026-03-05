<form id="select-route-form" action="{{ route('create-form') }}" method="post">
  @csrf
  <div class="modal-header">
    <h5 class="modal-title" id="exampleModalLongTitle">Generate URL</h5>
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
          <label for="Parent">Route :</label>
          <br />
          <select
            style="width: 100%"
            class="form-control"
            id="route"
            name="route"
          >
            <option value="">Select Route</option>
            <option value="gmec">gmec</option>
            <option value="olpcs">olpcs</option>
            <option value="asiarope">asiarope</option>
            <option value="gelosea">gelosea</option>
            <option value="imocsea">imocsea</option>
            <option value="imocsea_special">imocsea_special</option>
            <option value="isocsea">isocsea</option>
            <option value="imocsea+isocsea">imocsea+isocsea</option>
            <option value="cambridge">cambridge</option>
            <option value="huaxiacup">huaxiacup</option>
            <option value="huaxiacup-ii">huaxiacup-II</option>
            <option value="mathleague">mathleague</option>
            <option value="mathleague-ii">mathleague-II</option>
            <option value="reward">reward</option>
            <option value="test_field">test_field</option>
            <option value="neos">neo-science-olympiad</option>
            <option value="neos-2">neo-science-school</option>
            <option value="huaxiacup-final-round">
              China-Mathematical-Olympiad-Final
            </option>
            <option value="ihcmi">
              international-hope-cup-mathematic-invitational
            </option>
            <option value="isc">International STEM competitions</option>
            <option value="seacso">seacso</option>
            <option value="copernicus">COPERNICUS OLYMPIAD</option>
            <option value="coding-olympics">CODING OLYMPICS</option>
            <option value="stemco_science">stemco_science</option>
            <option value="advance_english_grammar">
              advance_english_grammar
            </option>
            <option value="admin-test-field">admin-test-field</option>
            <option value="award-ceremony-isocsea">
              award-ceremony-isocsea
            </option>
            <option value="imocsea-national-round">
              imocsea-national-round
            </option>
            <option value="spelling-bee-islo">spelling-bee-islo</option>
          </select>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="form-group">
          <label for="Parent">Form Name :</label>
          <br />
          <input
            type="text"
            class="form-control"
            id="form_name"
            name="form_name"
          />
        </div>
      </div>
    </div>
  </div>
  <!-- Modal footer -->
  <div class="modal-footer">
    <button type="submit" class="btn btn-success" id="select-route-submit">
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

<script>
  (function () {
    const formSelector = '#select-route-form';

    $(document)
      .off('submit', formSelector)
      .on('submit', formSelector, function (e) {
        e.preventDefault();

        const $form = $(this);
        const $submit = $('#select-route-submit');

        $submit.prop('disabled', true);

        $.ajax({
          url: $form.attr('action'),
          type: 'POST',
          data: $form.serialize(),
          headers: {
            Accept: 'application/json'
          }
        })
          .done(function (resp) {
            if (resp?.status === 'success') {
              toastr.success(resp.message || 'สร้างฟอร์มสำเร็จ');
              setTimeout(function () {
                window.location.href =
                  resp.redirect || '{{ route('form-manage.index') }}';
              }, 1200);
              return;
            }

            toastr.error('ไม่สามารถสร้างฟอร์มได้ กรุณาลองใหม่อีกครั้ง');
          })
          .fail(function (xhr) {
            if (xhr.status === 422 && xhr.responseJSON?.errors) {
              $.each(xhr.responseJSON.errors, function (field, messages) {
                if (messages?.length) {
                  toastr.error(messages[0]);
                }
              });
              return;
            }

            toastr.error('เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง');
          })
          .always(function () {
            $submit.prop('disabled', false);
          });
      });
  })();
</script>
