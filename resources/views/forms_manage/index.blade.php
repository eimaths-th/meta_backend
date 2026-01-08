@extends('layouts.main_template')

@section('style')
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js" type="text/javascript"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">
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
                    <div>Forms Management
                        <div class="page-title-subheading">META Knowledge Forms Management Data</div>
                    </div>
                </div>
                <div class="page-title-actions">
                    <div class="d-inline-block dropdown">
                        {{-- <a class="btn btn-success" href="{{ route('form-manage.create') }}"><i class="fa fa-plus"></i> Create New
                            Form</a> --}}
                            <a href="#" class="btn btn-success" onclick="formModal('{{ route('select_route') }}')"
                            data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-container="body"
                            data-bs-title="Create New Student">
                            <i class="fas fa-clock"></i> Create New Form
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="main-card mb-3 card " id="x_content">
            <div class="card-body">
                <form method="post" action="{{ route('users.destroy_all') }}" name="delete_all" id="delete_all">
                    @csrf
                    @method('DELETE')
                    <table style="width: 100%;" id="Listview"
                        class="table table-striped table-hover table-bordered responsive-utilities jambo_table bulk_action">
                        <thead>
                            <tr>
                                <th width="10px"><input type="checkbox" id="check-all" class="flat"></th>
                                <th>No</th>
                                <th>Form Name</th>
                                <th>Form Route</th>
                                <th width="280px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key => $item)
                                <tr>
                                    <td><input type="checkbox" class="flat" name="table_records[]" value="{{ $item->id }}"></td>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $item->form_name }}</td>
                                    <td>{{ $item->form_route }}</td>
                                    <td>
                                        <a href="{{ route('form-manage.view', $item->id) }}" class="btn btn-primary btn-sm" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('create-form', ['id' => $item->id]) }}" class="btn btn-warning btn-sm" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-info btn-sm duplicate-btn" data-id="{{ $item->id }}" title="Duplicate">
                                            <i class="fas fa-copy"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger btn-sm delete-btn" data-id="{{ $item->id }}" title="Delete">
                                            <i class="fas fa-trash"></i>
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

@endsection

@section('script')
    @include('forms_manage.script')
    <script>
        $(document).ready(function() {
            // delete btn
            $('.delete-btn').click(function() {
                var id = $(this).data('id');
                if (confirm("Are you sure you want to delete this form?")) {
                    $.ajax({
                        url: "{{ route('form-manage.destroy') }}",
                        method: 'POST',
                        data: {
                            id: id,
                            _token: '{{ csrf_token() }}',
                        },
                        success: function(result) {
                            if (result.status === 'success') {
                                toastr.success(result.message, {
                                    timeOut: 2000
                                });

                                setTimeout(() => {
                                    window.location.href =
                                        "{{ route('form-manage.index') }}";
                                }, 2000);
                            }
                        },
                        error: function(xhr) {
                            let message = 'เกิดข้อผิดพลาดในการลบฟอร์ม';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                message = xhr.responseJSON.message;
                            }
                            toastr.error(message, {
                                timeOut: 2000
                            });
                        }
                    });
                }
            });

            // duplicate btn
            $('.duplicate-btn').click(function() {
                var id = $(this).data('id');
                var $btn = $(this);
                
                if (confirm("Are you sure you want to duplicate this form?")) {
                    $btn.prop('disabled', true);
                    $btn.find('i').removeClass('fa-copy').addClass('fa-spinner fa-spin');
                    
                    $.ajax({
                        url: "{{ route('form-manage.duplicate') }}",
                        method: 'POST',
                        data: {
                            id: id,
                            _token: '{{ csrf_token() }}',
                        },
                        success: function(result) {
                            if (result.status === 'success') {
                                toastr.success(result.message, {
                                    timeOut: 2000
                                });

                                setTimeout(() => {
                                    window.location.href = "{{ route('form-manage.index') }}";
                                }, 2000);
                            } else {
                                toastr.error(result.message || 'เกิดข้อผิดพลาด', {
                                    timeOut: 2000
                                });
                                $btn.prop('disabled', false);
                                $btn.find('i').removeClass('fa-spinner fa-spin').addClass('fa-copy');
                            }
                        },
                        error: function(xhr) {
                            let message = 'เกิดข้อผิดพลาดในการ Duplicate ฟอร์ม';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                message = xhr.responseJSON.message;
                            }
                            toastr.error(message, {
                                timeOut: 2000
                            });
                            $btn.prop('disabled', false);
                            $btn.find('i').removeClass('fa-spinner fa-spin').addClass('fa-copy');
                        }
                    });
                }
            });
        });
    </script>
@endsection
