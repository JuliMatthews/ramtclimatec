<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title', 'Ramtclimatec')</title>
    
    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('admin/assets/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendors/jvectormap/jquery-jvectormap.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendors/owl-carousel-2/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendors/owl-carousel-2/owl.theme.default.min.css') }}">
    
    <!-- Layout styles -->
    <link rel="stylesheet" href="{{ asset('admin/assets/css/style.css') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.png') }}" />
    
    <style>
    /* Sobrescribir estilos de paginación del template */
    .pagination, .pagination *, 
    .dataTables_paginate, .dataTables_paginate *,
    .paginator, .paginator *,
    div[role="navigation"] { 
        all: initial !important;
        font-family: inherit !important;
        box-sizing: border-box !important;
    }
    .pagination { 
        display: flex !important;
        flex-wrap: wrap !important;
        justify-content: center !important;
        gap: 3px !important;
        padding: 10px !important;
        margin: 15px 0 !important;
        list-style: none !important;
        width: 100% !important;
    }
    .pagination li { 
        display: inline-block !important;
        margin: 0 2px !important;
    }
    .pagination li a, 
    .pagination li span { 
        display: inline-block !important;
        padding: 5px 10px !important;
        border: 1px solid #ccc !important;
        border-radius: 3px !important;
        text-decoration: none !important;
        color: #333 !important;
        background: #fff !important;
        font-size: 12px !important;
        min-width: 28px !important;
        height: 28px !important;
        line-height: 16px !important;
        text-align: center !important;
    }
    .pagination li.active span { 
        background: #007bff !important; 
        color: #fff !important; 
        border-color: #007bff !important;
    }
    .pagination li.disabled span { 
        color: #999 !important; 
        background: #f0f0f0 !important; 
    }
    .pagination li a:hover { 
        background: #e0e0e0 !important;
        cursor: pointer !important;
    }
    </style>
    
    @stack('styles')
</head>
<body>
    <div class="container-scroller">
        <!-- Sidebar -->
        @include('admin.partials.sidebar')
        
        <!-- Navbar -->
        @include('admin.partials.navbar')
        
        <!-- Main content -->
        <div class="main-panel">
            <div class="content-wrapper">
                @yield('content')
            </div>
            
            <!-- Footer -->
            @include('admin.partials.footer')
        </div>
    </div>

    <!-- Vendors JS -->
    <script src="{{ asset('admin/assets/vendors/js/vendor.bundle.base.js') }}"></script>
    <script src="{{ asset('admin/assets/vendors/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('admin/assets/vendors/progressbar.js/progressbar.min.js') }}"></script>
    <script src="{{ asset('admin/assets/vendors/jvectormap/jquery-jvectormap.min.js') }}"></script>
    <script src="{{ asset('admin/assets/vendors/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
    <script src="{{ asset('admin/assets/vendors/owl-carousel-2/owl.carousel.min.js') }}"></script>
    
    <!-- Custom JS -->
    <script src="{{ asset('admin/assets/js/off-canvas.js') }}"></script>
    <script src="{{ asset('admin/assets/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('admin/assets/js/misc.js') }}"></script>
    <script src="{{ asset('admin/assets/js/settings.js') }}"></script>
    <script src="{{ asset('admin/assets/js/todolist.js') }}"></script>
    <script src="{{ asset('admin/assets/js/dashboard.js') }}"></script>
    
    @stack('scripts')
</body>
</html>