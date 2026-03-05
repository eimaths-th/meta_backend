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

    <div class="row g-3">
      <div class="col-lg-6">
        <div class="form-group">
          <label for="form_name">Form Name :</label>
          <br />
          <input
            type="text"
            class="form-control"
            id="form_name"
            name="form_name"
            placeholder="IMOCSEA 2025"
            autocomplete="off"
          />
          <small class="form-text text-muted">
            กรอกชื่อฟอร์ม ระบบจะสร้าง Slug ให้อัตโนมัติ
          </small>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="form-group">
          <label for="slug_preview">Slug (URL) :</label>
          <br />
          <input
            type="text"
            class="form-control"
            id="slug_preview"
            placeholder="slug จะถูกสร้างจากชื่อฟอร์ม"
            readonly
          />
          <small class="form-text text-muted">
            Slug ใช้ตัวอักษรพิมพ์เล็ก ตัวเลข และเครื่องหมาย - เท่านั้น
          </small>
        </div>
      </div>
    </div>
    <input type="hidden" id="slug" name="slug" />
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

    const formNameInput = $('#form_name');
    const slugInput = $('#slug');
    const slugPreview = $('#slug_preview');

    const generateSlug = (value = '') => {
      return value
        .toString()
        .trim()
        .toLowerCase()
        .replace(/[^a-z0-9\s-]/g, '')
        .replace(/\s+/g, '-')
        .replace(/-+/g, '-')
        .replace(/^-|-$/g, '');
    };

    const updateSlugPreview = () => {
      const slug = generateSlug(formNameInput.val());
      slugInput.val(slug || '');
      slugPreview.val(slug || '');
    };

    updateSlugPreview();

    formNameInput.on('input', updateSlugPreview);

    $(document)
      .off('submit', formSelector)
      .on('submit', formSelector, function (e) {
        e.preventDefault();

        const $form = $(this);
        const $submit = $('#select-route-submit');

        $submit.prop('disabled', true);

        updateSlugPreview();

        if (!slugInput.val()) {
          toastr.error('กรุณากรอกชื่อฟอร์มเพื่อสร้าง Slug');
          $submit.prop('disabled', false);
          return;
        }

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
