@extends('layouts.main_template')

@section('style')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js" type="text/javascript"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script src="https://malsup.github.io/jquery.blockUI.js"></script>
    <script src="/assets/plugins/parsleyjs/dist/parsley.min.js"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
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
                        <i class="pe-7s-users icon-gradient bg-tempting-azure"></i>
                    </div>
                    <div>Students Bonus
                        <div class="page-title-subheading">META Knowledge Student Data</div>
                    </div>
                </div>
                <div class="page-title-actions">
                    <div class="d-inline-block dropdown">


                        <a href="#" class="btn btn-success"
                            onclick="formModalBonus('{{ route('studentBonus.create') }}')" data-bs-toggle="tooltip"
                            data-bs-trigger="hover" data-bs-container="body" data-bs-title="Add Bonus">
                            <i class="fa fa-plus"></i> Add Bonus
                        </a>

                        {{-- <a class="btn btn-success" data-toggle="modal" data-target=".bd-example-modal-lg"
                            id="CreateButton"><i class="fa fa-plus"></i> Create New Student</a> --}}

                    </div>
                </div>
            </div>
        </div>
        <div class="main-card mb-3 card " id="x_content">
            <div class="card-body">
                {{-- <form action="{{ route('search_rect') }}" method="GET" data-parsley-validate="true">
                    @csrf
                    <div class="row mb-3">

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="col-lg-3">
                            <div class="row">
                                <label for="month" class="col-lg-3">พนักงาน :</label>
                                <div class="col-lg-9">
                                    <select name="user_id" class="select2 select2_single form-control" multiple="multiple" required>
                                        <option value="">เลือกผนักงาน</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="row">
                                <label for="month" class="col-sm-4">เดือน<span class="text-danger">*</span> : </label>
                                <div class="col-sm-8">
                                    <select name="month" id="selectMonth" class="form-select form-control"
                                        data-parsley-required="true" data-parsley-required-message="เลือกเดือน">
                                        <option value="">เลือกเดือน</option>
                                        @for ($i = 1; $i <= 12; $i++)
                                            <option value="{{ $i }}">
                                                {{ date('F', mktime(0, 0, 0, $i, 1)) }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="row">
                                <label for="year" class="col-lg-2">ปี : </label>
                                <div class="col-lg-9">
                                    <select name="year" id="selectYear" class="form-select form-control"
                                        data-parsley-required="true" data-parsley-required-message="เลือกปี">
                                        @php
                                            $currentYear = date('Y');
                                            for ($i = $currentYear; $i >= $currentYear - 5; $i--) {
                                                echo "<option value='$i'>$i</option>";
                                            }
                                        @endphp
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <button class="btn btn-primary" type="submit">ค้นหา</button>
                        </div>
                    </div>
                </form> --}}
                <table style="width: 100%;" id="Listview"
                    class="table table-striped table-hover table-bordered responsive-utilities jambo_table bulk_action">
                    <thead>
                        <tr>
                            {{-- <th width="10px"><input type="checkbox" id="check-all" class="flat"></th> --}}
                            <th width="1%" align="center">#</th>
                            <th width="1%" align="center">Code</th>
                            <th data-orderable="false">Name</th>
                            <th data-orderable="false">Nick Name</th>
                            <th data-orderable="false">ระยะเวลา</th>
                            <th data-orderable="false">subject</th>

                            <th width="1%" data-orderable="false">bonus</th>


                            <th>หมายเหตุ</th>
                            <th>ผู้บันทึก</th>
                            <th class="nowrap" data-orderable="false">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bonus as $key => $record)
                            <tr>
                                <td align="center"> {{ $key + 1 }}</td>
                                <td align="center"> {{ $record->student->code }}</td>
                                <td> {{ $record->student->full_name }}</td>
                                <td> {{ $record->student->nick_name }}</td>
                                <td> {{ $record->school_p->period }}</td>
                                <td> {{ $record->school_p->school_sub->title }}</td>
                                <td> {{ $record->bonus }} ครั้ง</td>
                                <td> {{ $record->detail }} </td>
                                <td> {{ $record->user->name }} </td>
                                <td>
                                    <!-- delete btn $record->id -->
                                    <form action="{{ route('studentBonus.destroy', $record->id) }}" method="post" onsubmit="return confirm('Are you sure you want to delete this record?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
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
        $(document).ready(function() {

            $(".select2_single").select2({
                maximumSelectionLength: 1,
                allowClear: true
            });

            $(".select3_single").select2({
                maximumSelectionLength: 1,
                // allowClear: true
            });

            $(".select2_single2").select2({
                maximumSelectionLength: 2,
                //placeholder: "With Max Selection limit 4",
                allowClear: true
            });

            //$.noConflict();
            var token = ''
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(document).on('change', '#Bstudent_id', function(e) {
                e.preventDefault();
                var id = $('#Bstudent_id').val();

                console.log(id);
                $.ajax({
                    url: "studentBonus/schpid/" + id,
                    method: 'get',
                    data: {
                        _token: token,
                    },
                    success: function(result) {
                        // console.log(result);
                        $('#Bschoolp_id').html(result.studentsub);
                    }
                });
            });

            $(document).on('change', '#Bstudent_id', function(e) {
                e.preventDefault();
                var id = $('#Bstudent_id').val();

                console.log(id);
                $.ajax({
                    url: "studentBonus/detailrec/" + id,
                    method: 'get',
                    data: {
                        _token: token,
                    },
                    success: function(result) {
                        // console.log(result);
                        $('#Bschoolp_id').html(result.studentsub);
                    }
                });
            });

            var successMessage = "{{ session('success') }}";

            if (successMessage) {
                document.getElementById('successAlert').style.display = 'block';
            }
            var table = $('#Listview').DataTable({
                // serverSide: true,
                // processing: true,
                lengthMenu: [31, 75, 100],
            });
        })
    </script>
@endsection
