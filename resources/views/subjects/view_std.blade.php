@extends('layouts.main_template')

@section('style')
  <script
    src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"
    type="text/javascript"
  ></script>
  <script
    src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"
    type="text/javascript"
  ></script>
  <link
    rel="stylesheet"
    href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css"
  />
@endsection

@section('content')
  <div class="row">
    @if ($message = Session::get('success'))
      <div class="alert alert-success">
        <p>{{ $message }}</p>
      </div>
    @endif

    <div class="app-page-title">
      <div class="page-title-wrapper">
        <div class="page-title-heading">
          <div class="page-title-icon">
            <i class="pe-7s-study icon-gradient bg-tempting-azure"></i>
          </div>
          <div>
            Subject / รายชื่อนักเรียนในรายวิชา
            <div class="page-title-subheading">META Knowledge Subject Data</div>
          </div>
        </div>
      </div>
    </div>
    <div class="main-card card mb-3" id="x_content">
      <div class="card-body">
        <form
          action="{{ route('searchsubSTD') }}"
          method="GET"
          name="searchsubSTD"
          id="searchsubSTD"
        >
          @csrf
          <div class="row">
            <div class="col-lg-2">
              <div class="form-group mb-3">
                <select
                  class="select form-control"
                  name="subject"
                  id="subject"
                  required
                >
                  <option value="">select subject</option>
                  @foreach ($subj as $subj)
                    <option value="{{ $subj->id }}">
                      {{ $subj->title }}
                    </option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="col-lg-2">
              <div class="row">
                <div class="form-group mb-3">
                  <select
                    class="select form-control"
                    name="month"
                    id="month"
                    required
                  >
                    @php
                      $curentmonth = date('m');
                    @endphp

                    @if ($curentmonth)
                      <option value="{{ $curentmonth }}">
                        {{ $curentmonth }}
                      </option>
                    @endif

                    <option value="">select month</option>

                    @for ($i = 1; $i <= 12; $i++)
                      @php
                        $month = str_pad($i, 2, '0', STR_PAD_LEFT);
                      @endphp

                      <option value="{{ $month }}">{{ $month }}</option>
                    @endfor
                  </select>
                </div>
              </div>
            </div>

            <div class="col-lg-2">
              <div class="row">
                <div class="form-group mb-3">
                  <select
                    class="select form-control"
                    name="year"
                    id="year"
                    required
                  >
                    {{-- <option value=""> select year </option> --}}
                    @php
                      $currentYear = date('Y');
                      $startYear = $currentYear - 4;
                    @endphp

                    @for ($year = $currentYear; $year >= $startYear; $year--)
                      <option value="{{ $year }}">{{ $year }}</option>
                    @endfor
                  </select>
                </div>
              </div>
            </div>
            <div class="col-lg-2">
              <div class="form-group mb-3">
                <button class="btn btn-primary" type="submit">search</button>
              </div>
            </div>
          </div>
        </form>

        <table
          style="width: 100%"
          id="Listview"
          class="table-striped table-hover table-bordered responsive-utilities jambo_table bulk_action table"
        >
          <thead>
            <tr>
              <th>No.</th>
              <th>code</th>
              <th>Subject Name</th>
              <th>Name</th>
              <th>Nick Name</th>
            </tr>
          </thead>
          <tbody>
            @php
              $i = 1;
            @endphp

            @if (! empty($std))
              @foreach ($std as $std)
                <tr>
                  <td>{{ $i }}</td>
                  <td>{{ $std->student->code }}</td>
                  <td>{{ $std->subject->title }}</td>
                  <td>{{ $std->student->full_name }}</td>
                  <td>{{ $std->student->nick_name }}</td>
                </tr>
                @php
                  $i++;
                @endphp
              @endforeach
            @endif
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection

@section('script')
  <script>
    $(document).ready(function () {
      //$.noConflict();
      var token = '';
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      var table = $('#Listview').DataTable({
        lengthMenu: [10, 20, 50, 75, 100],
        columnDefs: [
          {
            orderable: false,
            targets: 0
          }
        ]
      });
    });
  </script>
@endsection
