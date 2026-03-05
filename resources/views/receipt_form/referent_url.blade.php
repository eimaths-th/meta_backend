@extends('layouts.main_template')

@section('style')
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script
    src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"
    type="text/javascript"
  ></script>
  <script
    src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"
    type="text/javascript"
  ></script>
  <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
  <script src="https://malsup.github.io/jquery.blockUI.js"></script>
  <link
    rel="stylesheet"
    href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css"
  />
  <link
    href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"
    rel="stylesheet"
  />
  <link
    rel="stylesheet"
    href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css"
  />
@endsection

@section('content')
  @if ($message = Session::get('error'))
    <div class="alert alert-danger mb-5">
      <p>{{ $message }}</p>
    </div>
  @endif

  <div class="row">
    <div class="app-page-title">
      <div class="page-title-wrapper">
        <div class="page-title-heading">
          <div class="page-title-icon">
            <i class="fas fa-mortar-board icon-gradient bg-tempting-azure"></i>
          </div>
          <div>
            Referent URL
            <div class="page-title-subheading">
              META Knowledge Referent URL Data
            </div>
          </div>
        </div>
        <div class="page-title-actions">
          <div class="d-inline-block dropdown">
            <button
              type="button"
              id="generate_code"
              onclick="formModal('{{ route('generate_code') }}')"
              class="btn btn-primary"
            >
              Generate code
            </button>
            <script>
              function referent_codeSave() {
                var route = $('#route').val();
                var referent_name = $('#referent_name').val();
                var comments = $('#comments').val();
                $.ajax({
                  url: '{{ route('referent_code.save') }}',
                  type: 'POST',
                  data: {
                    route: route,
                    referent_name: referent_name,
                    comments: comments,
                    _token: '{{ csrf_token() }}'
                  },
                  success: function (response) {
                    if (response.success) {
                      toastr.success(response.message, {
                        timeOut: 5000
                      });
                      setTimeout(function () {
                        window.location.reload();
                      }, 5000);
                    } else {
                      toastr.error(response.message, {
                        timeOut: 5000
                      });
                    }
                  },
                  error: function (xhr, status, error) {
                    console.log(error);
                  }
                });
              }
            </script>
            <a
              href="#"
              class="btn btn-success"
              onclick="formModal('{{ route('generate_url') }}')"
              data-bs-toggle="tooltip"
              data-bs-trigger="hover"
              data-bs-container="body"
              data-bs-title="Create New Student"
            >
              <i class="fas fa-clock"></i>
              Generate URL
            </a>

            {{--
              <a class="btn btn-info" data-toggle="modal" data-target=".bd-example-modal-lg" id="ImportButton"><i
              class="fa fa-file-excel"></i> Import Excel
              </a>
              <a class="btn btn-success" data-toggle="modal" data-target=".bd-example-modal-lg"
              id="CreateButton"><i class="fa fa-plus"></i> Create New Student</a>
              
              <a class="btn btn-danger delete_all_button" href="#"><i class="fa fa-trash"></i> Delete
              All</a>
            --}}
          </div>
        </div>
      </div>
    </div>
    <div class="main-card card mb-3" id="x_content">
      <div class="card-body">
        <form method="post" action="#" name="delete_all" id="delete_all">
          @csrf

          <table
            style="width: 100%"
            id="Listview"
            class="table-striped table-hover table-bordered responsive-utilities jambo_table bulk_action table"
          >
            <thead>
              <tr>
                {{-- <th width="10px"><input type="checkbox" id="check-all" class="flat"></th> --}}
                <th width="1%" align="center">#</th>
                <th>Url</th>
                <th>Name</th>
                <th>Code</th>
                <th>Explain</th>
                <th>User</th>
                <th>Created at</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($referent_url as $item)
                <tr>
                  <td>{{ $loop->iteration ?? 'N/A' }}</td>
                  <td>
                    <a
                      class="text-dark"
                      href="{{ $item->referent_url ?? 'N/A' }}"
                      target="_blank"
                    >
                      {{ $item->referent_url ?? 'N/A' }}
                    </a>
                  </td>
                  <td>{{ $item->code->referent_name ?? 'N/A' }}</td>
                  <td>{{ $item->referent_code ?? 'N/A' }}</td>
                  <td>{{ $item->comments ?? 'N/A' }}</td>
                  <td>{{ $item->user->name ?? 'N/A' }}</td>
                  <td>{{ $item->created_at ?? 'N/A' }}</td>
                  <td>
                    {{-- modal edit --}}
                    <button
                      type="button"
                      class="btn btn-primary btn-sm"
                      onclick="editReferentUrl({{ $item->id }})"
                    >
                      Edit
                    </button>
                    {{-- modal delete --}}
                    <button
                      type="button"
                      class="btn btn-danger btn-sm"
                      onclick="deleteReferentUrl({{ $item->id }})"
                    >
                      Delete
                    </button>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </form>
      </div>
    </div>
  </div>

  <div class="body-block-example-2" style="display: none" id="loder_bar">
    <br />
    <div class="loader" id="loder_bar_div">
      <div class="spinner-border text-primary" role="status">
        <span class="sr-only">Loading...</span>
      </div>
      <div class="spinner-border text-danger" role="status">
        <span class="sr-only">Loading...</span>
      </div>
      <div class="spinner-border text-warning" role="status">
        <span class="sr-only">Loading...</span>
      </div>
    </div>
    <br />
  </div>

  {{-- modal edit url --}}
  <div
    class="modal fade"
    id="editModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="editModalLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Edit Referent URL</h5>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
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
                  id="Editroute"
                  name="route"
                  required
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
                </select>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-group">
                <label for="Name">Referent Code:</label>
                {{-- <input type="text" class="form-control" name="referent_code" id="referent_code" required> --}}
                <select
                  name="referent_code"
                  id="Editreferent_code"
                  class="form-control"
                  required
                >
                  <option value="">Select Referent Code</option>
                  @foreach ($referent_code as $item)
                    <option value="{{ $item->referent_code }}">
                      {{ $item->referent_code }} —
                      ({{ $item->referent_name }})
                    </option>
                  @endforeach
                </select>
                <small class="form-text text-danger">
                  * ตัวอย่าง : 1234567890
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
              id="Editcomments"
              rows="5"
            ></textarea>
          </div>
          <input type="hidden" name="id" id="Editid" />
        </div>
        <div class="modal-footer">
          <button
            type="button"
            class="btn btn-secondary"
            data-bs-dismiss="modal"
          >
            Close
          </button>
          <button
            type="button"
            class="btn btn-primary"
            onclick="editReferentUrlSave()"
          >
            Save changes
          </button>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('script')
  <script>
    var table = $('#Listview').DataTable({
      // serverSide: true,
      // processing: true,
      lengthMenu: [10, 20, 50, 75, 100]
    });

    $(document).on('click', '.f5', function (e) {
      e.preventDefault();
      window.open(event.target.href);
      window.location.reload();
      event.preventDefault();
      console.log(window.location);
    });
  </script>
  <script>
    function editReferentUrl(id) {
      $.ajax({
        url: '{{ route('referent_url.edit') }}',
        type: 'GET',
        data: {
          id: id,
          _token: '{{ csrf_token() }}'
        },
        success: function (response) {
          if (response.success) {
            console.log(response);
            $('#Editid').val(response.referent_url.id);
            $('#Editreferent_code')
              .val(response.referent_url.referent_code)
              .trigger('change');
            $('#Editroute').val(response.referent_url.route).trigger('change');
            $('#Editcomments').val(response.referent_url.comments);
            $('#editModal').modal('show');
          } else {
            toastr.error(response.message, {
              timeOut: 5000
            });
          }
        },
        error: function (xhr, status, error) {
          console.log(error);
        }
      });
    }
    function editReferentUrlSave() {
      $.ajax({
        url: '{{ route('referent_url.edit.save') }}',
        type: 'POST',
        data: {
          id: $('#Editid').val(),
          referent_code: $('#Editreferent_code').val(),
          route: $('#Editroute').val(),
          comments: $('#Editcomments').val(),
          _token: '{{ csrf_token() }}'
        },
        success: function (response) {
          if (response.success) {
            toastr.success(response.message, {
              timeOut: 3000
            });
            $('#editModal').modal('hide');
            setTimeout(function () {
              window.location.reload();
            }, 5000);
            // $('#Listview').DataTable().ajax.reload();
          } else {
            toastr.error(response.message, {
              timeOut: 5000
            });
          }
        },
        error: function (xhr, status, error) {
          console.log(error);
        }
      });
    }

    function deleteReferentUrl(id) {
      $.ajax({
        url: '{{ route('referent_url.delete') }}',
        type: 'DELETE',
        data: {
          id: id,
          _token: '{{ csrf_token() }}'
        },
        success: function (response) {
          if (response.success) {
            toastr.success(response.message, {
              timeOut: 3000
            });
            setTimeout(function () {
              window.location.reload();
            }, 5000);
            // $('#Listview').DataTable().ajax.reload();
          } else {
            toastr.error(response.message, {
              timeOut: 5000
            });
          }
        },
        error: function (xhr, status, error) {
          console.log(error);
        }
      });
    }
  </script>
@endsection
