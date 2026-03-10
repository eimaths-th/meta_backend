@extends ('layouts.main_template')

@section ('style')
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

@section ('content')
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
            {{-- {{ $title }} --}}
            <div class="page-title-subheading">
              META Knowledge SetTime Forms Data
            </div>
          </div>
        </div>
        <div class="page-title-actions">
          <div class="d-inline-block dropdown">
            {{--
              <a href="#" class="btn btn-success" onclick="formModal('{{ route('formsTimes') }}')"
              data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-container="body"
              data-bs-title="Create New Student">
              <i class="fas fa-clock"></i> down load
              </a>
            --}}
            @php
              // $listArray = $lists->toArray();
              // // dd($listArray);
              // $listIds = array_column($listArray, 'id');
              $routeParameters = [
                'type' => 'print',
                'group' => $selectGroup,
                // 'month' => $month,
                // 'year' => $year,
                // 'ids' => $listIds,
                // 'title' => $title,
              ];
            @endphp

            <a
              href="#"
              onclick="export_report()"
              class="btn btn-success"
              data-bs-toggle="tooltip"
              data-bs-trigger="hover"
              data-bs-container="body"
              data-bs-title="print"
            >
              <i class="fa fa-print"></i>
              print
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
      <div class="card-header-tab card-header-tab-animation card-header">
        <div class="card-header-title">
          <i class="header-icon lnr-apartment icon-gradient bg-love-kiss"></i>
          RESULT EXPIRE STUDENT {{ $currentMonthf }} - {{ $currentYear }}
        </div>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-lg-3">
            <form action="{{ route('students.expire') }}" method="GET">
              @csrf
              <div class="row">
                <label for="selectGroup" class="col-lg-2">group:</label>
                <div class="col-lg-8 mb-3">
                  <select
                    name="group"
                    id="selectGroup"
                    class="form-control"
                    required
                  >
                    <option value="">Select Group</option>
                    @foreach ($groups as $group => $rec)
                      <option value="{{ $group }}">{{ $group }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-lg-2">
                  <button type="submit" class="btn btn-primary">ค้นหา</button>
                </div>
              </div>
            </form>
          </div>
        </div>

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
                <th align="center">ระยะเวลา</th>
                <th width="1%" align="center">Code</th>
                <th>ชื่อ-นามสกุล</th>
                <th>ผู้ปกครอง</th>
                <th>เบอร์ ผู้ปกครอง</th>
                <th width="1%" align="center">Group</th>
                {{-- <th class="text-center">Status</th> --}}
              </tr>
            </thead>
            <tbody id="first">
              @foreach ($StudentExpireCurrentMonth as $key => $list)
                <tr>
                  <td>{{ $key + 1 }}</td>
                  <td>{{ $list->period }}</td>

                  <td>
                    {{
                      $list->std
                        ->code
                    }}
                  </td>
                  <td>
                    <a
                      target="_blank"
                      class="text-dark"
                      href="{{ route('students.show', $list->std->id) }}"
                    >
                      {{ $list->std->full_name }} ( {{ $list->std->nick_name }} )
                    </a>
                  </td>
                  <td>
                    {{
                      $list->std->parent
                        ->name_parent
                    }}
                  </td>
                  <td>
                    {{
                      $list->std->parent
                        ->mobile
                    }}
                  </td>
                  <td>{{ $list->group }}</td>
                  {{-- <td align="center">{{ $list->status }}</td> --}}
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
@endsection

@section ('script')
  <script>
    // Get a reference to the select element
    // $('#selectGroup').change(function() {
    //     // Get the selected value (month)
    //     const selectedMonth = $(this).val();

    //     // Make an AJAX call to the Laravel route
    //     $.ajax({
    //         url: '{{
      route(
        'students.expire',
      )
    }}', // Route URL
    //         type: 'GET', // Request type
    //         data: {
    //             group: selectedMonth
    //         }, // Data to send (if needed)
    //         success: function(response) {
    //             // Handle the response from the server
    //             console.log(response);
    //         },
    //         error: function(xhr, status, error) {
    //             // Handle errors
    //             console.error(xhr.responseText);
    //         }
    //     });
    // });
  </script>
  <script>
    var table = $('#Listview').DataTable({
      // serverSide: true,
      // processing: true,
      lengthMenu: [20, 50, 75, 100]
    });

    function export_report() {
      url = '{{ route('students.expire', $routeParameters) }}';

      window.open(url.replace(/&amp;/g, '&'));
    }
  </script>
@endsection
