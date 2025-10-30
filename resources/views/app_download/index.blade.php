@extends('layouts.main_template')

@section('style')
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js" type="text/javascript"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">
@endsection

@section('content')
    <div class="row">



        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="fa fa-mobile-screen-button icon-gradient bg-tempting-azure"></i>
                    </div>
                    <div>META Knowledge App
                        <div class="page-title-subheading">META Knowledge App Data</div>
                    </div>
                </div>
                <div class="page-title-actions">
                    <div class="d-inline-block dropdown">
                        {{-- <a class="btn btn-success" data-toggle="modal" data-target=".bd-example-modal-lg"
                            id="CreateButton"><i class="fa fa-plus"></i> Create New
                            User</a>
                        <a class="btn btn-danger delete_all_button" href="#"><i class="fa fa-trash"></i> Delete
                            All</a> --}}
                        @if (auth()->user()->id == 16 || auth()->user()->id < 3)
                            <a href="#" class="btn btn-success"
                                onclick="formModal_app('{{ route('app-down-load.create') }}')">
                                <i class="fa fa-upload"></i> Upload App
                            </a>
                        @endif


                    </div>
                </div>
            </div>
        </div>
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif
        @if ($message = Session::get('error'))
            <div class="alert alert-danger">
                <p>{{ $message }}</p>
            </div>
        @endif
        <div class="main-card mb-3 card " id="x_content">
            <div class="card-body">

                <table style="width: 100%;" id="Listview"
                    class="table table-striped table-hover table-bordered responsive-utilities jambo_table bulk_action">
                    <thead>
                        <tr>
                            {{-- <th width="10px"><input type="checkbox" id="check-all" class="flat"></th> --}}
                            <th>No</th>
                            <th>Name</th>
                            <th>File Name</th>
                            <th>Version</th>
                            <th>Type</th>
                            <th>Upload By</th>
                            <th>Date</th>
                            <th width="280px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($apps as $key => $app)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $app->name }}</td>
                                <td>{{ $app->file_name }}</td>
                                <td>{{ $app->version }}</td>
                                <td>{{ $app->type }}</td>
                                <td>{{ $app->upload_by }}</td>
                                <td>{{ $app->updated_at->format('Y-m-d') }}</td>
                                <td>
                                    <a href="{{ asset('app_download/' . $app->file_name) }}" class="btn btn-primary"><i
                                            class="fa fa-download"></i> Download App</a>
                                    {{-- Delete btn --}}

                                    @if (auth()->user()->id == 16 || auth()->user()->id < 3)
                                        <form action="{{ route('app-down-load.destroy', $app->id) }}" method="POST"
                                            style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger"
                                                onclick="return confirm('Are you sure you want to delete this file?')">Delete</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>

    </div>
@endsection

@section('script')
    @include('app_download.script')
@endsection
