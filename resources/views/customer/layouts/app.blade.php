<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Furniro - Premium Furniture')</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #fff;
        }
        
        /* Header Styles */
        .header {
            background: #fff;
            padding: 20px 0;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .header-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 24px;
            font-weight: 700;
            color: #B88E2F;
            text-decoration: none;
        }
        
        .logo i {
            font-size: 32px;
        }
        
        .nav-menu {
            display: flex;
            gap: 40px;
            list-style: none;
        }
        
        .nav-menu a {
            text-decoration: none;
            color: #333;
            font-weight: 500;
            font-size: 16px;
            transition: color 0.3s;
        }
        
        .nav-menu a:hover,
        .nav-menu a.active {
            color: #B88E2F;
        }
        
        .header-icons {
            display: flex;
            gap: 20px;
            align-items: center;
        }
        
        .header-icons a {
            color: #333;
            font-size: 18px;
            text-decoration: none;
            transition: color 0.3s;
        }
        
        .header-icons a:hover {
            color: #B88E2F;
        }
        
        /* Hero Section */
        .hero-section {
            background: url('/images/hero-bg.jpg') center/cover;
            height: 316px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }
        
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.7);
        }
        
        .hero-content {
            text-align: center;
            position: relative;
            z-index: 2;
        }
        
        .hero-content h1 {
            font-size: 48px;
            font-weight: 600;
            color: #333;
            margin-bottom: 10px;
        }
        
        .breadcrumb {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            color: #666;
            font-size: 16px;
        }
        
        .breadcrumb a {
            color: #333;
            text-decoration: none;
            font-weight: 500;
        }
        
        .breadcrumb i {
            font-size: 12px;
        }
        
        /* Main Content */
        .main-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px;
        }
        
        /* Filter Bar */
        .filter-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            background: #F9F1E7;
            margin-bottom: 40px;
        }
        
        .filter-left {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        .filter-btn {
            display: flex;
            align-items: center;
            gap: 10px;
            background: none;
            border: none;
            color: #333;
            font-size: 16px;
            cursor: pointer;
        }
        
        .view-options {
            display: flex;
            gap: 10px;
        }
        
        .view-btn {
            width: 32px;
            height: 32px;
            border: 1px solid #ddd;
            background: #fff;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .view-btn.active {
            background: #B88E2F;
            color: #fff;
            border-color: #B88E2F;
        }
        
        .filter-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        .showing-text {
            color: #666;
        }
        
        .sort-select, .show-select {
            padding: 8px 12px;
            border: 1px solid #ddd;
            background: #fff;
            color: #333;
        }
    </style>
    @stack('styles')
</head>
<body>
    @include('customer.components.header')
    
    @yield('hero')
    
    <main class="main-content">
        @yield('content')
    </main>
    
    @include('customer.components.footer')
    
    @stack('scripts')
</body>
</html>
