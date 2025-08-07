<!-- Sidebar -->
<div class="sidebar">
    <div class="sidebar-header">
        <a href="#" class="logo">
            <i class="fas fa-couch"></i>
            <span>Furniro</span>
        </a>
        <div class="admin-label">Admin Panel</div>
    </div>

    <nav class="sidebar-menu">
        <a href="{{ route('admin.dashboard') }}" class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fas fa-chart-pie"></i>
            <span>Dashboard</span>
        </a>
        <a href="{{ route('admin.users') }}" class="menu-item {{ request()->routeIs('admin.users') ? 'active' : '' }}">
            <i class="fas fa-users"></i>
            <span>User Management</span>
        </a>
        <a href="{{ route('admin.categories') }}" class="menu-item {{ request()->routeIs('admin.categories') ? 'active' : '' }}">
            <i class="fas fa-tags"></i>
            <span>Category Management</span>
        </a>
        <a href="{{ route('admin.products') }}" class="menu-item {{ request()->routeIs('admin.products') ? 'active' : '' }}">
            <i class="fas fa-box"></i>
            <span>Product Management</span>
        </a>
        <a href="{{ route('admin.orders') }}" class="menu-item {{ request()->routeIs('admin.orders') ? 'active' : '' }}">
            <i class="fas fa-shopping-cart"></i>
            <span>Order Management</span>
        </a>
        <a href="{{ route('admin.feedbacks') }}" class="menu-item {{ request()->routeIs('admin.feedbacks') ? 'active' : '' }}">
            <i class="fas fa-star"></i>
            <span>Feedbacks</span>
        </a>
    </nav>
</div>
