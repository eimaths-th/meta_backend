<!-- resources/views/admin/logs/index.blade.php -->

@extends('layouts.main_template')

@section('style')
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js" type="text/javascript"></script>
    <style>
        pre {
            background-color: #f8f9fa;
            padding: 1em;
            border-radius: 0.5em;
            max-height: 400px;
            overflow: auto;
        }
    </style>
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
                        <i class="pe-7s-user icon-gradient bg-tempting-azure"></i>
                    </div>
                    <div>Logs
                        <div class="page-title-subheading">META Knowledge Logs Data</div>
                    </div>
                </div>
                <div class="page-title-actions">
                    <div class="d-inline-block dropdown">

                    </div>
                </div>
            </div>
        </div>
        <div class="main-card mb-3 card " id="x_content">
            <div class="card-body">
                <form action="{{ route('logs.full.filter') }}" method="GET">
                    @csrf
                    <div class="row mb-4">
                        <div class="col-md-2">
                            <select name="user_id" id="user_id" class="form-control user_id" required>
                                <option value="">Select Name</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="action" id="action" class="form-control action">
                                <option value="">Select Action</option>
                                @foreach ($actions as $action)
                                    <option value="{{ $action }}">{{ $action }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="month" id="month" class="form-control" required>
                                <option value="">Select Month</option>
                                <option value="01">January</option>
                                <option value="02">February</option>
                                <option value="03">March</option>
                                <option value="04">April</option>
                                <option value="05">May</option>
                                <option value="06">June</option>
                                <option value="07">July</option>
                                <option value="08">August</option>
                                <option value="09">September</option>
                                <option value="10">October</option>
                                <option value="11">November</option>
                                <option value="12">December</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="year" id="year" class="form-control" required>
                                <option value="">Select Year</option>
                                @for ($i = 0; $i <= 4; $i++)
                                    <option value="{{ date('Y') - $i }}">{{ date('Y') - $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary">submit</button>
                        </div>
                    </div>
                </form>
                <form method="post" action="{{ route('users.destroy_all') }}" name="delete_all" id="delete_all">
                    @csrf
                    @method('DELETE')

                    <table style="width: 100%;" id="Listview"
                        class="table table-striped table-hover table-bordered responsive-utilities jambo_table bulk_action">
                        <thead>
                            <tr class="headings">
                                <th class="column-title">User</th>
                                <th class="column-title">Action</th>
                                <th class="column-title">Time</th>

                                {{-- <th class="column-title">Description</th> --}}
                                <th class="column-title">IP</th>
                                <th class="column-title">User Agent</th>
                                <th class="column-title">Detail</th>

                            </tr>
                        </thead>
                        <tbody class="listview-body" id="listview-body">
                            @if ($logs->isEmpty())
                                <tr>
                                    <td colspan="7" class="text-center">No logs found.</td>
                                </tr>
                            @endif

                            @foreach ($logs as $log)
                                <tr>
                                    <td>{{ $log->user->name ?? 'Guest' }}</td>
                                    <td>{{ $log->action }}</td>
                                    <td>{{ $log->created_at->format('d M Y H:i') }}</td>

                                    {{-- <td>{{ $log->description }}</td> --}}

                                    <td>{{ $log->ip_address }}</td>
                                    <td>{{ $log->user_agent }}</td>
                                    <td>
                                        <button type="button" class="btn btn-primary btn-view-logs" data-bs-toggle="modal"
                                            data-bs-target="#logDetailModal" data-before='@json($log->data_before)'
                                            data-after='@json($log->data_after)'>
                                            <i class="fa fa-eye"></i> View
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
    <!-- Modal -->
    <div class="fade modal bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="logDetailModalLabel"
        aria-hidden="true" id="logDetailModal">
        <div class="modal-dialog modal-lg ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="logDetailModalLabel">Log Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <strong>Before:</strong>
                    <pre id="log-before"></pre>

                    <strong>After:</strong>
                    <pre id="log-after"></pre>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.btn-view-logs').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    const before = JSON.parse(this.getAttribute('data-before') || '{}');
                    const after = JSON.parse(this.getAttribute('data-after') || '{}');

                    document.getElementById('log-before').textContent = JSON.stringify(
                        before, null, 2);
                    document.getElementById('log-after').textContent = JSON.stringify(
                        after, null, 2);
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            let _token = $('meta[name="csrf-token"]').attr('content');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': _token
                }
            });


            $('.delete_all_button').on('click', function(e) {
                e.preventDefault();
                if (confirm('Are you sure you want to delete all logs?')) {
                    $('#delete_all').submit();
                }
            });
            $('.user_id').on('change', function() {
                var userId = $(this).val();
                $.ajax({
                    url: "{{ route('logs.filter') }}",
                    type: "GET",
                    data: {
                        user_id: userId,
                        _token: _token
                    },
                    success: function(data) {

                        $('.listview-body').html(data.html);
                    }
                });
            });
            $('.action').on('change', function() {
                var action = $(this).val();
                $.ajax({
                    url: "{{ route('logs.filter') }}",
                    type: "GET",
                    data: {
                        action: action,
                        _token: _token
                    },
                    success: function(data) {

                        $('.listview-body').html(data.html);
                    }
                });
            });
        });
    </script>
@endsection
