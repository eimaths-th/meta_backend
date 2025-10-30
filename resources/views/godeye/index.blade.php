@extends('layouts.main_template')

@section('style')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js" type="text/javascript"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script src="https://malsup.github.io/jquery.blockUI.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
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
                        <i class="fas fa-eye icon-gradient bg-tempting-azure"></i>
                    </div>
                    <div>God Eye META Knowledge
                        <div class="page-title-subheading">META Knowledge SetTime Forms Data</div>
                    </div>
                </div>
                <div class="page-title-actions">
                    <div class="d-inline-block dropdown">


                        <a href="#" class="btn btn-success" onclick="formModal('{{ route('Godeye.create') }}')"
                            data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-container="body"
                            data-bs-title="Create New Student">
                            <i class="fas fa-user-plus"></i> Add God
                        </a>
                        {{-- <a class="btn btn-info" data-toggle="modal" data-target=".bd-example-modal-lg" id="ImportButton"><i
                                class="fa fa-file-excel"></i> Import Excel
                        </a>
                        <a class="btn btn-success" data-toggle="modal" data-target=".bd-example-modal-lg"
                            id="CreateButton"><i class="fa fa-plus"></i> Create New Student</a>

                        <a class="btn btn-danger delete_all_button" href="#"><i class="fa fa-trash"></i> Delete
                            All</a> --}}

                    </div>
                </div>
            </div>
        </div>
        <div class="main-card mb-3 card " id="x_content">
            <div class="card-body">
                <form method="post" action="#" name="delete_all" id="delete_all">
                    @csrf

                    <table style="width: 100%;" id="Listview"
                        class="table table-striped table-hover table-bordered responsive-utilities jambo_table bulk_action">
                        <thead>
                            <tr>
                                {{-- <th width="10px"><input type="checkbox" id="check-all" class="flat"></th> --}}
                                <th width="1%" align="center">#</th>
                                <th>name</th>
                                <th>email</th>
                                <th>Level</th>
                                <th>Explain</th>

                                <th>Precursor</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($godeyes as $key => $godeye)
                                <tr>
                                    <td align="center"> {{ $key + 1 }}</td>

                                    <td> {{ $godeye->nextGod->name }} </td>
                                    <td> {{ $godeye->nextGod->email }} </td>
                                    <td>

                                        @php
                                            $ltext = '';
                                            $level = $godeye->nextGod;
                                            if ($godeye->nextGod->level == 1) {
                                                $ltext = 'Admin';
                                            } elseif ($level->level == 2) {
                                                $ltext = 'Teacher';
                                            } elseif ($level->level == 3) {
                                                $ltext = 'Account';
                                            } elseif ($level->level == 0) {
                                                $ltext = 'Owner';
                                            } else {
                                                $ltext = 'Normal';
                                            }
                                        @endphp
                                        {{ $ltext }}
                                    </td>
                                    <td>{{ $godeye->explain }}</td>
                                    <td> {{ $godeye->precursor->name }}  </td>

                                    <td>
                                        <form action="{{ route('Godeye.destroy', $godeye->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-xs btn-danger btn-delete"
                                                onclick="return confirm('Are you sure you want to delete this God?')"><i
                                                    class="fa fa-trash"></i> Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </form>
            </div>
        </div>

    </div>

    <div class="body-block-example-2" style="display:none" id="loder_bar">
        <br>
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
        <br>
    </div>
@endsection

@section('script')
    <script>
        var table = $('#Listview').DataTable({
            // serverSide: true,
            // processing: true,
            lengthMenu: [10, 20, 50, 75, 100],
        });

        // $(document).on('click', '.f5', function(e) {
        //     e.preventDefault();
        //     window.open(event.target.href);
        //     window.location.reload();
        //     event.preventDefault();
        //     console.log(window.location);
        // });
    </script>
@endsection
