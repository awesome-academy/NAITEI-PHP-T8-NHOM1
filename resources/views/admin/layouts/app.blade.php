<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Furniro Admin Panel</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    @vite(['resources/css/admin.css', 'resources/js/admin.js', 'resources/css/pagination.css'])
</head>
<body>
    @include('admin.components.sidebar')

    <!-- Main Content -->
    <div class="main-content">
        @include('admin.components.header')

        <!-- Content Sections -->
        <div id="content-area">
            @yield('content')
        </div>
    </div>

    <!-- Modals -->
    <div id="modal-area">
        @yield('modals')
        @include('admin.components.modals')
    </div>

    @yield('scripts')
    @stack('scripts')
</body>
</html>
