<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta http-equiv="Content-Language" content="en" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Meta Knowledge</title>
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no"
    />
    <meta
      name="description"
      content="This is an example dashboard created using build-in elements and components."
    />
    <meta name="msapplication-tap-highlight" content="no" />

    {{-- <meta name="viewport" content="width=device-width, initial-scale=1"> --}}
    <!--
    =========================================================
    * ArchitectUI HTML Theme Dashboard - v1.0.0
    =========================================================
    * Product Page: https://dashboardpack.com
    * Copyright 2019 DashboardPack (https://dashboardpack.com)
    * Licensed under MIT (https://github.com/DashboardPack/architectui-html-theme-free/blob/master/LICENSE)
    =========================================================
    * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
    -->
    <link rel="icon" type="image/png" href="../images/logo_meta.png" />

    <script
      defer
      src="{{ asset('architectui/assets/scripts/main.js') }}"
    ></script>
    <script
      src="https://code.jquery.com/jquery-3.5.1.js"
      type="text/javascript"
    ></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script
      src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
      integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
      integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF"
      crossorigin="anonymous"
    ></script>
    @yield('style')
    <script
      defer
      src="{{ asset('architectui/assets/scripts/demo.js') }}"
    ></script>
    <script
      defer
      src="{{ asset('architectui/assets/scripts/toastr.js') }}"
    ></script>
    <script
      defer
      src="{{ asset('architectui/assets/scripts/scrollbar.js') }}"
    ></script>
    <script
      defer
      src="{{ asset('architectui/assets/scripts/fullcalendar.js') }}"
    ></script>
    <script
      defer
      src="{{ asset('architectui/assets/scripts/maps.js') }}"
    ></script>
    <script
      defer
      src="{{ asset('architectui/assets/scripts/chart_js.js') }}"
    ></script>
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <script src="/js/app.js?v=1"></script>
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

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link
      href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"
      rel="stylesheet"
    />

    <link
      rel="stylesheet"
      href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css"
    />

    <script src="/assets/plugins/sweetalert/dist/sweetalert.min.js"></script>

    <!-- Scripts
      @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    -->
    <link
      rel="stylesheet"
      href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css"
      type="text/css"
    />

    <link href="../assets/css/app.minn.css" rel="stylesheet" />

    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css"
    />
    <link rel="stylesheet" href="{{ asset('css/infinite.css') }}" />

    <style>
      .form-row {
        display: flex;
        flex-wrap: wrap;
        margin-right: -5px;
        margin-left: -5px;
      }

      .form-row > .col,
      .form-row > [class*='col-'] {
        padding-right: 5px;
        padding-left: 5px;
      }

      .example {
        width: 50%;
        /* 50% of the parent container's width */
        font-size: 2em;
        /* 2 times the default font size */
      }

      /* @media screen and (max-width: 400px) {
            .screen-auto {
                max-width: 100%;
                height: auto;
            }
        }

        .screen-auto {
            max-width: 800;
            height: 200;
        } */
    </style>

    {{--
      <link href="/assets/plugins/select2/dist/css/select2.min.css" rel="stylesheet"/>
      <script src="../assets/plugins/select2/dist/js/select2.min.js"></script>
    --}}
  </head>

  <body>
    <div class="app-container app-theme-white body-tabs-shadow fixed-header">
      <!-- Header -->
      @include('layouts.header')

      <!-- Theme Setting -->
      @include('layouts.theme_setting')

      <div class="app-main">
        <!-- Sidebar -->
        @include('layouts.sidebar')

        <div class="app-main__outer">
          <div class="app-main__inner">
            <!-- Your Page Content Here -->
            @yield('content')

            <!-- Edit User Modal -->
            <div
              class="fade modal bd-example-modal-lg"
              tabindex="-1"
              role="dialog"
              aria-labelledby="myLargeModalLabel"
              aria-hidden="true"
              id="EditUserModal"
            >
              <div class="modal-dialog modal-lg" role="document">
                <form class="form" action="" method="POST">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLongTitle">
                        Edit Users Data
                      </h5>
                      <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                      ></button>
                    </div>
                    <!-- Modal body -->
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
                      <div class="form-group">
                        <label for="Name">Name:</label>
                        <input
                          type="text"
                          class="form-control"
                          name="name"
                          id="EdituName"
                          value="{{ Auth::user()->name }}"
                        />
                      </div>
                      <div class="form-group">
                        <label for="Name">Email:</label>
                        <input
                          type="text"
                          class="form-control"
                          name="email"
                          id="EdituEmail"
                          value="{{ Auth::user()->email }}"
                        />
                      </div>
                      <div class="form-group">
                        <label for="Name">Password:</label>
                        <input
                          type="password"
                          class="form-control"
                          name="password"
                          required
                          autocomplete="new-password"
                          id="EdituPassword"
                        />
                      </div>
                      <div class="form-group">
                        <label for="Name">Confirm Password:</label>
                        <input
                          type="password"
                          class="form-control"
                          name="password_confirmation"
                          id="EdituPasswordC"
                          required
                          autocomplete="new-password"
                        />
                      </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                      <button
                        type="button"
                        class="btn btn-success"
                        id="SubmitUserEditForm"
                      >
                        Save
                      </button>
                      <button
                        type="button"
                        class="btn btn-danger modelClose"
                        data-bs-dismiss="modal"
                      >
                        Close
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </div>

            @include('layouts.modal-form')
          </div>
          <!-- Footer -->
          @include('layouts.footer')
        </div>
      </div>
    </div>

    @yield('script')
    <script>
      //ตัวนี้จะเอาไว้ set ค่าต่างๆ toastr
      toastr.options = {
        closeButton: true,
        debug: false,
        newestOnTop: false,
        progressBar: true,
        positionClass: 'toast-top-right',
        preventDuplicates: false,
        onclick: null,
        showDuration: '300',
        hideDuration: '1000',
        timeOut: '5000',
        extendedTimeOut: '1000',
        showEasing: 'swing',
        hideEasing: 'linear',
        showMethod: 'fadeIn',
        hideMethod: 'fadeOut'
      };
    </script>

    <script>
      $(document).ready(function () {
        $('#SubmitUserEditForm').click(function (e) {
          if (!confirm('Are you sure?')) return;
          e.preventDefault();

          $('.alert-danger').html('');
          $('.alert-danger').hide();
          $('.alert-success').html('');
          $('.alert-success').hide();

          let id = {{ Auth::user()->id }};
          $.ajax({
            url: 'users/msave/' + id,
            method: 'PUT',
            data: {
              name: $('#EdituName').val(),
              password: $('#EdituPassword').val(),
              password_confirmation: $('#EdituPasswordC').val(),
              email: $('#EdituEmail').val()
            },

            success: function (result) {
              console.log(result);
              if (result.errors) {
                $('.alert-danger').html('');
                $.each(result.errors, function (key, value) {
                  $('.alert-danger').show();
                  $('.alert-danger').append(
                    '<strong><li>' + value + '</li></strong>'
                  );
                });
              } else {
                $('.alert-danger').hide();
                $('.alert-success').show();
                $('.alert-success').append(
                  '<strong><li>' + result.success + '</li></strong>'
                );

                $('#EditModal').modal('hide');
              }
            }
          });
        });
      });
    </script>
  </body>
</html>
