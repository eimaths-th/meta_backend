@extends('layouts.main_template')

@section('style')
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js" type="text/javascript"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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
                        <i class="pe-7s-network icon-gradient bg-tempting-azure"></i>
                    </div>
                    <div>
                        Study Course
                        <div class="page-title-subheading">META Knowledge Study Course Data</div>
                    </div>
                </div>
                <div class="page-title-actions">
                    <div class="d-inline-block dropdown">
                        <a href="{{ route('course.simulate', ['type' => 'view', 'lang' => 'th', 'student' => $student, 'subject' => $subject, 'book' => $book, 'level' => $level, 'date' => $date, 'grade' => $grade]) }}"
                            class="btn btn-info" data-toggle="modal" data-target=".bd-example-modal-lg" id="LangButtonth"><i
                                class="fa fa-eye"></i> Thai</a>
                        <a href="{{ route('course.simulate', ['type' => 'view', 'lang' => 'en', 'student' => $student, 'subject' => $subject, 'book' => $book, 'level' => $level, 'date' => $date, 'grade' => $grade]) }}"
                            class="btn btn-info" data-toggle="modal" data-target=".bd-example-modal-lg" id="LangButtonen"><i
                                class="fa fa-eye"></i> Eng</a>
                        <a class="btn btn-warning " href="#" onclick="export_report();"><i class="fa fa-print"></i>
                            Print</a>
                        <a href="{{ route('course') }}" class="btn btn-success" data-toggle="modal"
                            data-target=".bd-example-modal-lg" id="CreateButton"><i class="fa fa-backward"></i> Back
                            Study Course</a>


                    </div>
                </div>
            </div>
        </div>

        <div class="main-card mb-3 card " id="x_content">
            <div class="card-body">
                <div style="float: right; padding-right: 250px;">
                    <b>Name:</b> ({{ $student }})
                    {{-- $course[0]->student_lastname --}} <b>School Grade:</b> ( {{ $grade }} ) <b>
                        Book Start:</b> ( {{ $book }} )
                </div>
                <table style="width: 100%;" id="Listview"
                    class="table table-striped table-bordered responsive-utilities jambo_table bulk_action">
                    <thead>
                        <tr>
                            <th>School Grade</th>
                            <th class="text-center">Level</th>
                            <th colspan="12" class="text-center">( {{ $grade }} )</th>

                        </tr>
                    </thead>
                    <tbody>

                        {!! $levels !!}


                    </tbody>

                    <tfoot>
                        <tr>
                            <td colspan="2" align="center">Year</td>
                            @for ($i = $year; $i <= $last_year; $i++)
                                <td align="center" colspan="{{ $year_span[$i] }}">{{ $i }}</td>
                            @endfor

                        </tr>
                        <tr>
                            <td colspan="2" align="center">Month</td>

                            @foreach ($months as $key)
                                <td align="center">{{ $key }}</td>
                            @endforeach
                        </tr>
                    </tfoot>

                </table>

            </div>
        </div>

    </div>
@endsection

@section('script')
    <script>
        function export_report() {
            url =
                '{{ route('course.simulate', ['type' => 'print', 'lang' => $lang, 'student' => $student, 'subject' => $subject, 'book' => $book, 'level' => $level, 'date' => $date, 'grade' => $grade]) }}';
            window.open(
                url.replace(/&amp;/g, "&")
            );
        }
    </script>
@endsection
