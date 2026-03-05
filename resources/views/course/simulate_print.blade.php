<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <style>
      th,
      td {
        border: solid #000 !important;
        border-width: 0 1px 1px 0 !important;
      }
    </style>
  </head>

  <body>
    <div class="row">
      <div class="logo-src">
        <img
          src="{{ asset('images/eye_logo.jpg') }}"
          alt="..."
          height="26"
          style="padding-bottom: 5px"
        />
        Eye Level Progress Projection Chart
      </div>
      <div style="padding-bottom: 10px"></div>
      <div class="main-card card mb-3" id="x_content">
        <div class="card-body">
          <div style="float: right; padding-right: 250px">
            <b>Name:</b>
            ({{ $student }})
            {{-- $course[0]->student_lastname --}}
            <b>School Grade:</b>
            ( {{ $grade }} )
            <b>Book Start:</b>
            ( {{ $book }} )
          </div>
          <table
            cellpadding="0"
            cellspacing="0"
            style="
              width: 100%;
              border: solid #000 !important;
              border-width: 1px 0 0 1px !important;
            "
            id="Listview"
            class="main"
          >
            <thead>
              <tr>
                <th>School Grade</th>
                <th>Level</th>
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
                  <td align="center" colspan="{{ $year_span[$i] }}">
                    {{ $i }}
                  </td>
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
  </body>

  <script>
    function printrep() {
      window.print();
    }
    printrep();
    setTimeout(function () {
      window.close();
    }, 2000);
  </script>
</html>
