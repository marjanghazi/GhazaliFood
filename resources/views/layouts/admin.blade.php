<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard - Ghazali Food')</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    
    <!-- Admin Custom CSS -->
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
    
    @stack('styles')
</head>
<body class="bg-light">
    <!-- Admin Wrapper -->
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div class="border-end bg-white" id="sidebar-wrapper">
            <div class="sidebar-heading border-bottom bg-success text-white p-3">
                <div class="d-flex align-items-center">
                    <i class="fas fa-utensils fa-2x me-2"></i>
                    <div>
                        <h4 class="mb-0">Ghazali Food</h4>
                        <small class="opacity-75">Admin Panel</small>
                    </div>
                </div>
            </div>
            <div class="list-group list-group-flush">
                <!-- Dashboard -->
                <a href="{{ route('admin.dashboard') }}" 
                   class="list-group-item list-group-item-action py-3 {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                </a>
                
                <!-- Products -->
                <a href="#productsSubmenu" data-bs-toggle="collapse" 
                   class="list-group-item list-group-item-action py-3">
                    <i class="fas fa-box me-2"></i> Products
                    <i class="fas fa-angle-down ms-auto"></i>
                </a>
                <div class="collapse {{ request()->is('admin/products*') ? 'show' : '' }}" id="productsSubmenu">
                    <a href="{{ route('admin.products.index') }}" 
                       class="list-group-item list-group-item-action py-2 ps-5 {{ request()->routeIs('admin.products.index') ? 'active' : '' }}">
                        <i class="fas fa-list me-2"></i> All Products
                    </a>
                    <a href="{{ route('admin.products.create') }}" 
                       class="list-group-item list-group-item-action py-2 ps-5 {{ request()->routeIs('admin.products.create') ? 'active' : '' }}">
                        <i class="fas fa-plus me-2"></i> Add New
                    </a>
                    <a href="{{ route('admin.categories.index') }}" 
                       class="list-group-item list-group-item-action py-2 ps-5 {{ request()->routeIs('admin.categories*') ? 'active' : '' }}">
                        <i class="fas fa-tags me-2"></i> Categories
                    </a>
                </div>
                
                <!-- Orders -->
                <a href="{{ route('admin.orders.index') }}" 
                   class="list-group-item list-group-item-action py-3 {{ request()->routeIs('admin.orders*') ? 'active' : '' }}">
                    <i class="fas fa-shopping-cart me-2"></i> Orders
                    <span class="badge bg-danger float-end">0</span>
                </a>
                
                <!-- Customers -->
                <a href="{{ route('admin.customers.index') }}" 
                   class="list-group-item list-group-item-action py-3 {{ request()->routeIs('admin.customers*') ? 'active' : '' }}">
                    <i class="fas fa-users me-2"></i> Customers
                </a>
                
                <!-- Content -->
                <a href="#contentSubmenu" data-bs-toggle="collapse" 
                   class="list-group-item list-group-item-action py-3">
                    <i class="fas fa-newspaper me-2"></i> Content
                    <i class="fas fa-angle-down ms-auto"></i>
                </a>
                <div class="collapse {{ request()->is('admin/blogs*') || request()->is('admin/banners*') || request()->is('admin/announcements*') ? 'show' : '' }}" id="contentSubmenu">
                    <a href="{{ route('admin.blogs.index') }}" 
                       class="list-group-item list-group-item-action py-2 ps-5 {{ request()->routeIs('admin.blogs*') ? 'active' : '' }}">
                        <i class="fas fa-blog me-2"></i> Blogs
                    </a>
                    <a href="{{ route('admin.banners.index') }}" 
                       class="list-group-item list-group-item-action py-2 ps-5 {{ request()->routeIs('admin.banners*') ? 'active' : '' }}">
                        <i class="fas fa-image me-2"></i> Banners
                    </a>
                    <a href="{{ route('admin.announcements.index') }}" 
                       class="list-group-item list-group-item-action py-2 ps-5 {{ request()->routeIs('admin.announcements*') ? 'active' : '' }}">
                        <i class="fas fa-bullhorn me-2"></i> Announcements
                    </a>
                </div>
                
                <!-- Marketing -->
                <a href="#marketingSubmenu" data-bs-toggle="collapse" 
                   class="list-group-item list-group-item-action py-3">
                    <i class="fas fa-bullhorn me-2"></i> Marketing
                    <i class="fas fa-angle-down ms-auto"></i>
                </a>
                <div class="collapse {{ request()->is('admin/coupons*') ? 'show' : '' }}" id="marketingSubmenu">
                    <a href="{{ route('admin.coupons.index') }}" 
                       class="list-group-item list-group-item-action py-2 ps-5 {{ request()->routeIs('admin.coupons*') ? 'active' : '' }}">
                        <i class="fas fa-ticket-alt me-2"></i> Coupons
                    </a>
                </div>
                
                <!-- Support -->
                <a href="{{ route('admin.feedback.index') }}" 
                   class="list-group-item list-group-item-action py-3 {{ request()->routeIs('admin.feedback*') ? 'active' : '' }}">
                    <i class="fas fa-headset me-2"></i> Support
                    <span class="badge bg-danger float-end">{{ \App\Models\Feedback::where('status', 'new')->count() }}</span>
                </a>
                
                <!-- Reviews -->
                <a href="{{ route('admin.reviews.index') }}" 
                   class="list-group-item list-group-item-action py-3 {{ request()->routeIs('admin.reviews*') ? 'active' : '' }}">
                    <i class="fas fa-star me-2"></i> Reviews
                    <span class="badge bg-warning float-end">{{ \App\Models\Review::where('status', 'pending')->count() }}</span>
                </a>
                
                <!-- Reports -->
                <a href="{{ route('admin.reports.index') }}" 
                   class="list-group-item list-group-item-action py-3 {{ request()->routeIs('admin.reports*') ? 'active' : '' }}">
                    <i class="fas fa-chart-bar me-2"></i> Reports
                </a>
                
                <!-- Settings -->
                <a href="{{ route('admin.settings.index') }}" 
                   class="list-group-item list-group-item-action py-3 {{ request()->routeIs('admin.settings*') ? 'active' : '' }}">
                    <i class="fas fa-cog me-2"></i> Settings
                </a>
                
                <!-- Back to Website -->
                <a href="{{ url('/') }}" target="_blank" 
                   class="list-group-item list-group-item-action py-3 text-success">
                    <i class="fas fa-external-link-alt me-2"></i> View Website
                </a>
                
                <!-- Logout -->
                <form action="{{ route('logout') }}" method="POST" class="list-group-item">
                    @csrf
                    <button type="submit" class="btn btn-link text-danger p-0 w-100 text-start">
                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                    </button>
                </form>
            </div>
        </div>
        
        <!-- Page Content -->
        <div id="page-content-wrapper">
            <!-- Top Navigation -->
            <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
                <div class="container-fluid">
                    <button class="btn btn-success" id="sidebarToggle">
                        <i class="fas fa-bars"></i>
                    </button>
                    
                    <div class="navbar-nav ms-auto">
                        <div class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" 
                               id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                                <div class="me-2">
                                    <strong>{{ Auth::user()->name }}</strong><br>
                                    <small class="text-muted">{{ Auth::user()->role->name }}</small>
                                </div>
                                <i class="fas fa-user-circle fa-2x"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="#">
                                    <i class="fas fa-user me-2"></i> Profile
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="fas fa-sign-out-alt me-2"></i> Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>
            
            <!-- Main Content -->
            <div class="container-fluid px-4 py-3">
                <!-- Page Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h1 class="h3 mb-0">@yield('page_title', 'Dashboard')</h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active">@yield('breadcrumb', 'Overview')</li>
                            </ol>
                        </nav>
                    </div>
                    <div>
                        @yield('page_actions')
                    </div>
                </div>
                
                <!-- Alerts -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                
                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                
                <!-- Page Content -->
                @yield('content')
            </div>
            
            <!-- Footer -->
            <footer class="footer mt-auto py-3 bg-white border-top">
                <div class="container-fluid">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <span class="text-muted">
                                &copy; {{ date('Y') }} Ghazali Food. Admin Panel v1.0
                            </span>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <span class="text-muted">
                                Server Time: {{ now()->format('Y-m-d H:i:s') }}
                            </span>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    
    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    
    <!-- Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    
    <!-- Tinymce Editor -->
    <script src="https://cdn.tiny.cloud/1/YOUR_API_KEY/tinymce/6/tinymce.min.js"></script>
    
    <!-- Admin Custom JS -->
    <script src="{{ asset('js/admin.js') }}"></script>
    
    @stack('scripts')
    
    <script>
        // Sidebar Toggle
        $("#sidebarToggle").click(function(e) {
            e.preventDefault();
            $("#wrapper").toggleClass("toggled");
        });
        
        // Initialize DataTables
        $(document).ready(function() {
            $('.data-table').DataTable({
                pageLength: 25,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search..."
                }
            });
            
            // Initialize Select2
            $('.select2').select2({
                theme: 'bootstrap-5'
            });
            
            // Initialize TinyMCE
            if (typeof tinymce !== 'undefined') {
                tinymce.init({
                    selector: '.tinymce-editor',
                    height: 400,
                    menubar: false,
                    plugins: 'link image lists media table code',
                    toolbar: 'undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist | link image media table | code',
                    content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
                });
            }
            
            // Confirm delete
            $('.confirm-delete').click(function(e) {
                e.preventDefault();
                const form = $(this).closest('form');
                const itemName = $(this).data('item-name') || 'this item';
                
                if (confirm(`Are you sure you want to delete ${itemName}? This action cannot be undone.`)) {
                    form.submit();
                }
            });
            
            // Status toggle
            $('.status-toggle').click(function(e) {
                e.preventDefault();
                const url = $(this).data('url');
                const csrf = $('meta[name="csrf-token"]').attr('content');
                
                $.ajax({
                    url: url,
                    method: 'POST',
                    data: {
                        _token: csrf,
                        _method: 'PATCH'
                    },
                    success: function(response) {
                        location.reload();
                    },
                    error: function(xhr) {
                        alert('Error updating status');
                    }
                });
            });
        });
    </script>
</body>
</html>