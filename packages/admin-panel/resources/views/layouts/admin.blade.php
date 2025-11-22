<!DOCTYPE html>
<html direction="rtl" dir="rtl" style="direction: rtl" lang="fa">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'پنل مدیریت')</title>
    
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700"/>
    
    <!-- CSS Files -->
    <link href="{{ asset('adminassets/plugins/global/plugins.bundle.rtl.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('adminassets/plugins/custom/prismjs/prismjs.bundle.rtl.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('adminassets/css/style.bundle.rtl.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('adminassets/css/themes/layout/header/base/light.rtl.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('adminassets/css/themes/layout/header/menu/light.rtl.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('adminassets/css/themes/layout/brand/light.rtl.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('adminassets/css/themes/layout/aside/light.rtl.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{ asset('adminassets/js/fontawesome-pro-6.1.1-web/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminassets/kamadatepicker/kamadatepicker.min.css') }}">
    
    @stack('styles')
</head>
<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">
    
    <!-- Main Content -->
    <div class="d-flex flex-column flex-root">
        <div class="d-flex flex-row flex-column-fluid page">
            
            <!-- Aside (Sidebar) -->
            <div class="aside aside-left aside-fixed d-flex flex-column flex-row-auto" id="kt_aside">
                <div class="brand flex-column-auto" id="kt_brand">
                    <div class="brand-logo">
                        <a href="{{ url('/admin/dashboard') }}">
                            <h3 class="text-white">پنل مدیریت</h3>
                        </a>
                    </div>
                </div>
                
                <!-- Aside Menu -->
                <div class="aside-menu-wrapper flex-column-fluid" id="kt_aside_menu_wrapper">
                    <div id="kt_aside_menu" class="aside-menu my-4" data-menu-vertical="1">
                        <ul class="menu-nav">
                            <li class="menu-item {{ request()->is('admin/dashboard') ? 'menu-item-active' : '' }}">
                                <a href="{{ url('/admin/dashboard') }}" class="menu-link">
                                    <span class="svg-icon menu-icon">
                                        <i class="fas fa-home"></i>
                                    </span>
                                    <span class="menu-text">داشبورد</span>
                                </a>
                            </li>
                            <!-- Add more menu items here -->
                        </ul>
                    </div>
                </div>
            </div>
            
            <!-- Main Wrapper -->
            <div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
                
                <!-- Header -->
                <div id="kt_header" class="header header-fixed">
                    <div class="container-fluid d-flex align-items-stretch justify-content-between">
                        <div class="header-menu-wrapper header-menu-wrapper-left" id="kt_header_menu_wrapper">
                            <div class="header-menu header-menu-mobile header-menu-layout-default">
                                <h4 class="text-dark mt-5">پنل مدیریت دکتر حنا سبزاده</h4>
                            </div>
                        </div>
                        
                        <div class="topbar">
                            <div class="dropdown">
                                <div class="topbar-item">
                                    <div class="btn btn-icon btn-icon-mobile w-auto btn-clean d-flex align-items-center btn-lg px-2">
                                        <span class="text-muted font-weight-bold font-size-base d-none d-md-inline mr-1">مدیر</span>
                                        <span class="text-dark-50 font-weight-bolder font-size-base d-none d-md-inline mr-3">سلام،</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Content -->
                <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
                        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                            <div class="d-flex align-items-center flex-wrap mr-2">
                                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">@yield('page-title', 'داشبورد')</h5>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex flex-column-fluid">
                        <div class="container">
                            @yield('content')
                        </div>
                    </div>
                </div>
                
                <!-- Footer -->
                <div class="footer bg-white py-4 d-flex flex-lg-column" id="kt_footer">
                    <div class="container-fluid d-flex flex-column flex-md-row align-items-center justify-content-between">
                        <div class="text-dark order-2 order-md-1">
                            <span class="text-muted font-weight-bold mr-2">{{ date('Y') }}©</span>
                            <a href="#" class="text-dark-75 text-hover-primary">پنل مدیریت</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- JS Scripts -->
    <script src="{{ asset('adminassets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('adminassets/plugins/custom/prismjs/prismjs.bundle.js') }}"></script>
    <script src="{{ asset('adminassets/js/scripts.bundle.js') }}"></script>
    <script src="{{ asset('adminassets/kamadatepicker/kamadatepicker.min.js') }}"></script>
    <script src="{{ asset('adminassets/kamadatepicker/kamadatepicker.holidays.js') }}"></script>
    
    @stack('scripts')
</body>
</html>
