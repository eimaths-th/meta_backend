<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="@yield('body_class')">
<head>
  <meta charset="utf-8" />
  <meta
    name="viewport"
    content="width=device-width, initial-scale=1, maximum-scale=5, user-scalable=yes"
  />
  <meta name="mobile-web-app-capable" content="yes" />
  <meta name="apple-mobile-web-app-capable" content="yes" />
  <meta name="apple-mobile-web-app-status-bar-style" content="default" />

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}" />

  <title>Meta Knowledge - Educational Excellence</title>
  <meta
    name="description"
    content="Meta Knowledge - ศูนย์รวมความรู้และการพัฒนาทักษะสำหรับนักเรียนและผู้ปกครอง"
  />
  <link
    rel="icon"
    type="image/png"
    href="{{ asset('images/logo_meta.png') }}"
  />

  @php
    $shouldLoadGoogleTagManager = request()->routeIs(
      'form.show',
      'form.store',
      'form.store1',
      'form.storeFormManage',
      'form.complete',
      'form.completed',
      'form.complete1',
      'parentregister',
      'parentregister.store',
      'parentregister.complete'
    );
  @endphp

  @if ($shouldLoadGoogleTagManager)
    <!-- Google Tag Manager -->
    <script>
      (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
      new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
      j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
      'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
      })(window,document,'script','dataLayer','GTM-5KB2W4L7');
    </script>
    <!-- End Google Tag Manager -->
  @endif

  <script
    src="{{ asset('assets/plugins/jquery/dist/jquery.min.js') }}"
    type="text/javascript"
  ></script>
  <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.21.0/dist/jquery.validate.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/inputmask@5.0.8/dist/jquery.inputmask.min.js"></script>
  <script src="{{ asset('assets/plugins/dropzone/dist/min/dropzone.min.js') }}"></script>
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
  <!-- Fonts -->
  <link rel="dns-prefetch" href="//fonts.gstatic.com" />
  <link
    href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600;700&family=Sarabun:wght@300;400;500;600;700&display=swap"
    rel="stylesheet"
  />
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css"
  />
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
  />
  <link
    href="{{ asset('assets/plugins/dropzone/dist/min/dropzone.min.css') }}"
    rel="stylesheet"
    type="text/css"
  />
  <link
    href="{{ asset('assets/plugins/select2/dist/css/select2.min.css') }}"
    rel="stylesheet"
  />
  <script src="{{ asset('assets/plugins/select2/dist/js/select2.min.js') }}"></script>
  @yield ('style')
  <style>
    /* Global Layout Styles - Orange Theme */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Sarabun', 'Kanit', sans-serif;
      background: linear-gradient(
        135deg,
        #ffb835 0%,
        #ff8c42 50%,
        #ffa500 100%
      );
      min-height: 100vh;
      overflow-x: hidden;
    }

    main {
      position: relative;
      z-index: 1;
    }

    .custom-image {
      width: 100%;
      height: auto;
      border-radius: 15px;
      box-shadow: 0 5px 20px rgba(255, 107, 53, 0.2);
    }

    .custom-image2 {
      width: 50%;
      height: auto;
      border-radius: 10px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    /* Scrollbar Styling */
    ::-webkit-scrollbar {
      width: 12px;
    }

    ::-webkit-scrollbar-track {
      background: #ffe0b2;
    }

    ::-webkit-scrollbar-thumb {
      background: linear-gradient(135deg, #ff6b35 0%, #ff8c42 100%);
      border-radius: 6px;
    }

    ::-webkit-scrollbar-thumb:hover {
      background: linear-gradient(135deg, #ff8c42 0%, #ffa500 100%);
    }

    /* Loading Animation */
    @keyframes pulse {
      0%,
      100% {
        opacity: 1;
      }
      50% {
        opacity: 0.5;
      }
    }

    /* Mobile Responsive Styles */
    @media (max-width: 767px) {
      body {
        font-size: 14px;
        overflow-x: hidden;
      }

      .custom-image {
        width: 100%;
        height: auto;
      }

      .custom-image2 {
        width: 90%;
        height: auto;
      }

      .container {
        max-width: 100%;
        padding-left: 10px;
        padding-right: 10px;
      }

      /* Prevent horizontal scroll */
      html,
      body {
        max-width: 100%;
        overflow-x: hidden;
      }

      /* Touch-friendly elements */
      button,
      a,
      input,
      select,
      textarea {
        -webkit-tap-highlight-color: rgba(255, 107, 53, 0.2);
      }

      /* Improve touch targets */
      button,
      .btn {
        min-height: 44px;
        min-width: 44px;
      }

      input,
      select,
      textarea {
        min-height: 44px;
      }
    }

    /* Extra small devices */
    @media (max-width: 575px) {
      body {
        font-size: 13px;
      }

      .custom-image2 {
        width: 100%;
      }

      .container {
        padding-left: 5px;
        padding-right: 5px;
      }
    }

    /* Prevent zoom on input focus for iOS */
    @media screen and (max-width: 768px) {
      input[type='text'],
      input[type='email'],
      input[type='tel'],
      input[type='number'],
      input[type='date'],
      select,
      textarea {
        font-size: 16px !important;
      }
    }
  </style>
</head>

<body class="@yield('body_class')">
  @if ($shouldLoadGoogleTagManager)
    <!-- Google Tag Manager (noscript) -->
    <noscript>
      <iframe
        src="https://www.googletagmanager.com/ns.html?id=GTM-5KB2W4L7"
        height="0"
        width="0"
        style="display:none;visibility:hidden"
      ></iframe>
    </noscript>
    <!-- End Google Tag Manager (noscript) -->
  @endif

  <main class="">
    @yield ('content')
  </main>
</body>
</html>
