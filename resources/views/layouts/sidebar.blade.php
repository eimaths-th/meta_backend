@php
  use App\Models\Subject;
  use App\Models\SubjectPrice;
  use App\Models\Godeye;
  use App\Models\FormManage;
  $formManages = FormManage::all();
@endphp

<div class="app-sidebar sidebar-shadow">
  <div class="app-header__logo">
    <div class="logo-src"></div>
    <div class="header__pane ms-auto">
      <div>
        <button
          type="button"
          class="hamburger close-sidebar-btn hamburger--elastic"
          data-class="closed-sidebar"
        >
          <span class="hamburger-box">
            <span class="hamburger-inner"></span>
          </span>
        </button>
      </div>
    </div>
  </div>
  <div class="app-header__mobile-menu">
    <div>
      <button
        type="button"
        class="hamburger hamburger--elastic mobile-toggle-nav"
      >
        <span class="hamburger-box">
          <span class="hamburger-inner"></span>
        </span>
      </button>
    </div>
  </div>
  <div class="app-header__menu">
    <span>
      <button
        type="button"
        class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav"
      >
        <span class="btn-icon-wrapper">
          <i class="fa fa-ellipsis-v fa-w-6"></i>
        </span>
      </button>
    </span>
  </div>
  <div class="scrollbar-sidebar">
    <div class="app-sidebar__inner">
      <ul class="vertical-nav-menu">
        @if (Auth::user()->level == 3 ||
          Auth::user()->level == 1 ||
          Auth::user()->level == 0)
          <li class="app-sidebar__heading">สนามสอบ</li>
          <li>
            <a href="{{ route('formsControl') }}">
              <i class="metismenu-icon pe-7s-clock"></i>
              SetTime
            </a>
          </li>
          <li>
            <a href="#">
              <i class="metismenu-icon pe-7s-network"></i>
              Referent
              <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
            </a>
            <ul>
              <li>
                <a href="{{ route('referent_url') }}">
                  <i class="metismenu-icon"></i>
                  Referent URL
                </a>
              </li>
              <li>
                <a href="{{ route('referent_code') }}">
                  <i class="metismenu-icon"></i>
                  Referent Code
                </a>
              </li>
            </ul>
          </li>
          @if (Auth::user()->level == 3 ||
            Auth::user()->level == 1 ||
            Auth::user()->level == 0)
            <li>
              <a href="#">
                {{-- find icon for forms management --}}
                <i class="metismenu-icon pe-7s-display2"></i>
                Forms Management
                <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
              </a>
              <ul>
                <li>
                  <a href="{{ route('form-manage.index') }}">
                    <i class="metismenu-icon"></i>
                    Forms Management
                  </a>
                </li>
                <li>
                  <a href="{{ route('form-manage.index') }}">
                    <i class="metismenu-icon"></i>
                    Package Management
                  </a>
                </li>
                <li>
                  <a href="{{ route('form-manage.index') }}">
                    <i class="metismenu-icon"></i>
                    Grade Management
                  </a>
                </li>
              </ul>
            </li>
          @endif
          <li>
            <a href="#">
              <i class="metismenu-icon pe-7s-note2"></i>
              ข้อมูลจาก Online Form
              <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
            </a>
            <!-- ข้อมูลจาก Online Form -->
            <!--
                        <ul>
                            <li>
                                <a href="{{ route('receipts_form_all') }}">
                                    <i class="metismenu-icon"></i>
                                    All
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('receipts_form', ['sfield' => '2']) }}">
                                    <i class="metismenu-icon"></i>
                                    GMEC
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('receipts_form', ['sfield' => '4']) }}">
                                    <i class="metismenu-icon"></i>
                                    IMOCSEA
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('receipts_form', ['sfield' => '5']) }}">
                                    <i class="metismenu-icon"></i>
                                    INFINITE Spelling Bee
                                    {{-- no data --}}
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('receipts_form', ['sfield' => '6']) }}">
                                    <i class="metismenu-icon"></i>
                                    GELOSEA
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('receipts_form', ['sfield' => '7']) }}">
                                    <i class="metismenu-icon"></i>
                                    LIMOC
                                    {{-- no data --}}
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('receipts_form', ['sfield' => '8']) }}">
                                    <i class="metismenu-icon"></i>
                                    STEM
                                    {{-- no data --}}
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('receipts_form', ['sfield' => '9']) }}">
                                    <i class="metismenu-icon"></i>
                                    OLPCS
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('receipts_form', ['sfield' => '10']) }}">
                                    <i class="metismenu-icon"></i>
                                    ASIAROPE
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('receipts_form', ['sfield' => '11']) }}">
                                    <i class="metismenu-icon"></i>
                                    Cambridge
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('receipts_form', ['sfield' => '13']) }}">
                                    <i class="metismenu-icon"></i>
                                    ISOCSEA
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('receipts_form', ['sfield' => '14']) }}">
                                    <i class="metismenu-icon"></i>
                                    IMOCSEA+ISOCSEA
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('receipts_form', ['sfield' => '15']) }}">
                                    <i class="metismenu-icon"></i>
                                    Huaxiacup
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('receipts_form', ['sfield' => '16']) }}">
                                    <i class="metismenu-icon"></i>
                                    Mathleague
                                    {{-- <!-- ml -->
            --}}
            </a>
          </li>
          <li>
            <a href="{{ route('receipts_form', ['sfield' => '17']) }}">
              <i class="metismenu-icon"></i>
              Test Field
            </a>
          </li>
          <li>
            <a href="{{ route('receipts_form', ['sfield' => '18']) }}">
              <i class="metismenu-icon"></i>
              Mathleague-II
              {{-- <!-- ml --> --}}
            </a>
          </li>
          <li>
            <a href="{{ route('receipts_form', ['sfield' => '19']) }}">
              <i class="metismenu-icon"></i>
              Huaxiacup-II
            </a>
          </li>
          <li>
            <a href="{{ route('receipts_form', ['sfield' => '20']) }}">
              <i class="metismenu-icon"></i>
              Neo science
            </a>
          </li>
          <li>
            <a href="{{ route('receipts_form', ['sfield' => '21']) }}">
              <i class="metismenu-icon"></i>
              Neo science - School
            </a>
          </li>
          <li>
            <a href="{{ route('receipts_form', ['sfield' => '22']) }}">
              <i class="metismenu-icon"></i>
              China-Final
            </a>
          </li>
          <li>
            <a href="{{ route('receipts_form', ['sfield' => '23']) }}">
              <i class="metismenu-icon"></i>
              International hope
            </a>
          </li>
          <li>
            <a href="{{ route('receipts_form', ['sfield' => '24']) }}">
              <i class="metismenu-icon"></i>
              International STEM
            </a>
          </li>
          <li>
            <a href="{{ route('receipts_form', ['sfield' => '25']) }}">
              <i class="metismenu-icon"></i>
              SEACSO
            </a>
          </li>
          <li>
            <a href="{{ route('receipts_form', ['sfield' => '26']) }}">
              <i class="metismenu-icon"></i>
              Copernicus
            </a>
          </li>
          <li>
            <a href="{{ route('receipts_form', ['sfield' => '27']) }}">
              <i class="metismenu-icon"></i>
              CODING OLYMPICS
            </a>
          </li>
          <li>
            <a href="{{ route('receipts_form', ['sfield' => '28']) }}">
              <i class="metismenu-icon"></i>
              IMOCSEA SPECIAL
            </a>
          </li>
          <li>
            <a href="{{ route('receipts_form', ['sfield' => '29']) }}">
              <i class="metismenu-icon"></i>
              STEMCO Science
            </a>
          </li>
          <li>
            <a href="{{ route('receipts_form', ['sfield' => '30']) }}">
              <i class="metismenu-icon"></i>
              Advance English Grammar
            </a>
          </li>
          <li>
            <a href="{{ route('receipts_form', ['sfield' => '32']) }}">
              <i class="metismenu-icon"></i>
              Award Ceremony ISOCSEA
            </a>
          </li>
          <li>
            <a href="{{ route('receipts_form', ['sfield' => '33']) }}">
              <i class="metismenu-icon"></i>
              IMOCSEA National Round
            </a>
          </li>
          <li>
            <a href="{{ route('receipts_form', ['sfield' => '0']) }}">
              <i class="metismenu-icon"></i>
              Img Reward
            </a>
          </li>
      </ul>
      -->

      <ul>
        <li>
          <a href="{{ route('receipts_form_all') }}">
            <i class="metismenu-icon"></i>
            All
          </a>
        </li>
        <li>
          <a href="{{ route('receipts_form', ['sfield' => '31']) }}">
            <i class="metismenu-icon"></i>
            (มา) ISOCSEA IMOCSEA National Round 2025
          </a>
        </li>
        <li>
          <a href="{{ route('receipts_form', ['sfield' => '32']) }}">
            <i class="metismenu-icon"></i>
            (ไม่มา) ISOCSEA IMOCSEA National Round
          </a>
        </li>
        @foreach ($formManages as $formManage)
          <li>
            <a
              href="{{ route('receipts_form', ['sfield' => $formManage->sfield]) }}"
            >
              <i class="metismenu-icon"></i>
              {{ $formManage->form_name }}
            </a>
          </li>
        @endforeach
      </ul>
      </li>
      <li>
        <a href="#">
          <i class="metismenu-icon pe-7s-note2"></i>
          Receipt (ค่าสมัครสอบ)
          <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
        </a>

        {{--
              <ul>
              <li>
              <a href="{{ route('receipts_all') }}">
              <i class="metismenu-icon"></i>
              All
              </a>
              </li>
              <li>
              <a href="{{ route('receipts', ['sfield' => '9']) }}">
              <i class="metismenu-icon"></i>
              OLPCS
              </a>
              </li>
              <li>
              <a href="{{ route('receipts', ['sfield' => '10']) }}">
              <i class="metismenu-icon"></i>
              ASIAROPE
              </a>
              </li>
              <li>
              <a href="{{ route('receipts', ['sfield' => '11']) }}">
              <i class="metismenu-icon"></i>
              Cambridge
              </a>
              </li>
              <li>
              <a href="{{ route('receipts', ['sfield' => '2']) }}">
              <i class="metismenu-icon"></i>
              GMEC
              </a>
              </li>
              <li>
              <a href="{{ route('receipts', ['sfield' => '4']) }}">
              <i class="metismenu-icon"></i>
              IMOCSEA
              </a>
              </li>
              <li>
              <a href="{{ route('receipts', ['sfield' => '28']) }}">
              <i class="metismenu-icon"></i>
              IMOCSEA SPECIAL
              </a>
              </li>
              <li>
              <a href="{{ route('receipts', ['sfield' => '13']) }}">
              <i class="metismenu-icon"></i>
              ISOCSEA
              </a>
              </li>
              <li>
              <a href="{{ route('receipts', ['sfield' => '14']) }}">
              <i class="metismenu-icon"></i>
              IMOCSEA+ISOCSEA
              </a>
              </li>
              <li>
              <a href="{{ route('receipts', ['sfield' => '5']) }}">
              <i class="metismenu-icon"></i>
              INFINITE Spelling Bee
              </a>
              </li>
              <li>
              <a href="{{ route('receipts', ['sfield' => '6']) }}">
              <i class="metismenu-icon"></i>
              GELOSEA
              </a>
              </li>
              <li>
              <a href="{{ route('receipts', ['sfield' => '7']) }}">
              <i class="metismenu-icon"></i>
              LIMOC
              </a>
              </li>
              <li>
              <a href="{{ route('receipts', ['sfield' => '8']) }}">
              <i class="metismenu-icon"></i>
              STEM
              </a>
              </li>
              <li>
              <a href="{{ route('receipts', ['sfield' => '15']) }}">
              <i class="metismenu-icon"></i>
              Huaxiacup
              </a>
              </li>
              <li>
              <a href="{{ route('receipts', ['sfield' => '19']) }}">
              <i class="metismenu-icon"></i>
              Huaxiacup-II
              </a>
              </li>
              <li>
              <a href="{{ route('receipts', ['sfield' => '16']) }}">
              <i class="metismenu-icon"></i>
              Mathleague
              <!-- ml -->
              </a>
              </li>
              <li>
              <a href="{{ route('receipts', ['sfield' => '18']) }}">
              <i class="metismenu-icon"></i>
              Mathleague-II
              <!-- ml -->
              </a>
              </li>
              <li>
              <a href="{{ route('receipts', ['sfield' => '0']) }}">
              <i class="metismenu-icon"></i>
              Img Reward
              </a>
              </li>
              <li>
              <a href="{{ route('receipts', ['sfield' => '17']) }}">
              <i class="metismenu-icon"></i>
              Test Field
              </a>
              </li>
              <li>
              <a href="{{ route('receipts', ['sfield' => '20']) }}">
              <i class="metismenu-icon"></i>
              Neo science
              </a>
              </li>
              <li>
              <a href="{{ route('receipts', ['sfield' => '21']) }}">
              <i class="metismenu-icon"></i>
              Neo science - School
              </a>
              </li>
              <li>
              <a href="{{ route('receipts', ['sfield' => '22']) }}">
              <i class="metismenu-icon"></i>
              China-Final
              </a>
              </li>
              <li>
              <a href="{{ route('receipts', ['sfield' => '24']) }}">
              <i class="metismenu-icon"></i>
              International STEM
              </a>
              </li>
              <li>
              <a href="{{ route('receipts', ['sfield' => '25']) }}">
              <i class="metismenu-icon"></i>
              SEACSO
              </a>
              </li>
              <li>
              <a href="{{ route('receipts', ['sfield' => '26']) }}">
              <i class="metismenu-icon"></i>
              Copernicus
              </a>
              </li>
              <li>
              <a href="{{ route('receipts', ['sfield' => '27']) }}">
              <i class="metismenu-icon"></i>
              CODING OLYMPICS
              </a>
              </li>
              <li>
              <a href="{{ route('receipts', ['sfield' => '29']) }}">
              <i class="metismenu-icon"></i>
              STEMCO Science
              </a>
              </li>
              <li>
              <a href="{{ route('receipts', ['sfield' => '30']) }}">
              <i class="metismenu-icon"></i>
              Advance English Grammar
              </a>
              </li>
              </ul>
            --}}
        <ul>
          <li>
            <a href="{{ route('receipts_all') }}">
              <i class="metismenu-icon"></i>
              All
            </a>
          </li>

          <li>
            <a href="{{ route('receipts', ['sfield' => '31']) }}">
              <i class="metismenu-icon"></i>
              (มา) ISOCSEA IMOCSEA National Round 2025
            </a>
          </li>
          <li>
            <a href="{{ route('receipts', ['sfield' => '32']) }}">
              <i class="metismenu-icon"></i>
              (ไม่มา) ISOCSEA IMOCSEA National Round
            </a>
          </li>
          @foreach ($formManages as $formManage)
            <li>
              <a
                href="{{ route('receipts', ['sfield' => $formManage->sfield]) }}"
              >
                <i class="metismenu-icon"></i>
                {{ $formManage->form_name }}
              </a>
            </li>
          @endforeach
        </ul>
      </li>

      <li>
        @php
          $ymonth = date('Y-m');
          $pmd = date('Y');
        @endphp

        <a href="#">
          <i class="metismenu-icon pe-7s-graph2"></i>
          Receipt Report
          <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
        </a>
        <ul>
          <li>
            <a
              href="{{ route('receipts.print_month', ['pmsfield' => '9', 'type' => 'report_view', 'print_month' => $ymonth, 'Pmdescription' => 'ค่าสมัคร OLPCS รอบแรก ' . $pmd]) }}"
            >
              <i class="metismenu-icon"></i>
              OLPCS
            </a>
          </li>
          <li>
            <a
              href="{{ route('receipts.print_month', ['pmsfield' => '10', 'type' => 'report_view', 'print_month' => $ymonth, 'Pmdescription' => 'ค่าสมัคร ASIAROPE รอบแรก ' . $pmd]) }}"
            >
              <i class="metismenu-icon"></i>
              ASIAROPE
            </a>
          </li>
          <li>
            <a
              href="{{ route('receipts.print_month', ['pmsfield' => '11', 'type' => 'report_view', 'print_month' => $ymonth, 'Pmdescription' => 'ค่าสมัคร Cambridge รอบแรก ' . $pmd]) }}"
            >
              <i class="metismenu-icon"></i>
              Cambridge
            </a>
          </li>
          <li>
            <a
              href="{{ route('receipts.print_month', ['pmsfield' => '2', 'type' => 'report_view', 'print_month' => $ymonth, 'Pmdescription' => 'ค่าสมัคร GMEC รอบแรก ' . $pmd]) }}"
            >
              <i class="metismenu-icon"></i>
              GMEC
            </a>
          </li>
          <li>
            <a
              href="{{ route('receipts.print_month', ['pmsfield' => '4', 'type' => 'report_view', 'print_month' => $ymonth, 'Pmdescription' => 'ค่าสมัคร IMOCSEA รอบแรก ' . $pmd]) }}"
            >
              <i class="metismenu-icon"></i>
              IMOCSEA
            </a>
          </li>
          <li>
            <a
              href="{{ route('receipts.print_month', ['pmsfield' => '28', 'type' => 'report_view', 'print_month' => $ymonth, 'Pmdescription' => 'ค่าสมัคร IMOCSEA รอบแรก ' . $pmd]) }}"
            >
              <i class="metismenu-icon"></i>
              IMOCSEA SPECIAL
            </a>
          </li>
          <li>
            <a
              href="{{ route('receipts.print_month', ['pmsfield' => '5', 'type' => 'report_view', 'print_month' => $ymonth, 'Pmdescription' => 'ค่าสมัคร INFINITE Spelling Bee รอบแรก ' . $pmd]) }}"
            >
              <i class="metismenu-icon"></i>
              INFINITE Spelling Bee
            </a>
          </li>
          <li>
            <a
              href="{{ route('receipts.print_month', ['pmsfield' => '6', 'type' => 'report_view', 'print_month' => $ymonth, 'Pmdescription' => 'ค่าสมัคร GELOSEA รอบแรก ' . $pmd]) }}"
            >
              <i class="metismenu-icon"></i>
              GELOSEA
            </a>
          </li>
          <li>
            <a
              href="{{ route('receipts.print_month', ['pmsfield' => '7', 'type' => 'report_view', 'print_month' => $ymonth, 'Pmdescription' => 'ค่าสมัคร LIMOC รอบแรก ' . $pmd]) }}"
            >
              <i class="metismenu-icon"></i>
              LIMOC
            </a>
          </li>
          <li>
            <a
              href="{{ route('receipts.print_month', ['pmsfield' => '8', 'type' => 'report_view', 'print_month' => $ymonth, 'Pmdescription' => 'ค่าสมัคร STEM รอบแรก ' . $pmd]) }}"
            >
              <i class="metismenu-icon"></i>
              STEM
            </a>
          </li>
          <li>
            <a
              href="{{ route('receipts.print_month', ['pmsfield' => '29', 'type' => 'report_view', 'print_month' => $ymonth, 'Pmdescription' => 'ค่าสมัคร STEMCO Science รอบแรก ' . $pmd]) }}"
            >
              <i class="metismenu-icon"></i>
              STEMCO Science
            </a>
          </li>
          <li>
            <a
              href="{{ route('receipts.print_month', ['pmsfield' => '30', 'type' => 'report_view', 'print_month' => $ymonth, 'Pmdescription' => 'ค่าสมัคร Advance English Grammar รอบแรก ' . $pmd]) }}"
            >
              <i class="metismenu-icon"></i>
              Advance English Grammar
            </a>
          </li>
        </ul>
      </li>
      @endif

      @if (Auth::user()->level != 3)
        <li class="app-sidebar__heading">พนักงาน</li>
        <li>
          <a href="{{ route('home2') }}">
            <i class="metismenu-icon pe-7s-home"></i>
            Home
          </a>
        </li>
      @endif

      @if (Auth::user()->level == 1 ||
        Auth::user()->level == 0 ||
        Auth::user()->level == 4)
        <li class="app-sidebar__heading">ผู้ดูแลระบบ</li>
        <li>
          <a href="#">
            <i class="metismenu-icon pe-7s-user"></i>
            พนักงาน
            <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
          </a>

          @if (Auth::user()->level == 1 || Auth::user()->level == 0)
            <ul>
              <li>
                <a href="{{ route('users') }}">
                  <i class="metismenu-icon"></i>
                  รายชื่อพนักงาน
                </a>
              </li>
            </ul>
          @endif
        </li>
        <li>
          <a href="{{ route('email-audit-logs.index') }}">
            <i class="metismenu-icon pe-7s-mail"></i>
            Email Audit Logs
          </a>
        </li>
      @endif
      </ul>
    </div>
  </div>
</div>
