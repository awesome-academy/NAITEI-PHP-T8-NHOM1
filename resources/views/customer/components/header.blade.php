<header class="header">
    <div class="header-container">
        <a href="{{ route('customer.categories') }}" class="logo">
            <i class="fas fa-couch"></i>
            Furniro
        </a>
        
        <nav class="nav-menu">
            <a href="{{ route('customer.categories') }}" class="{{ request()->routeIs('customer.categories') ? 'active' : '' }}">{{ __('Shop') }}</a>
            <a href="{{ route('customer.about') }}" class="{{ request()->routeIs('customer.about') ? 'active' : '' }}">{{ __('About') }}</a>
            <a href="{{ route('customer.contact') }}" class="{{ request()->routeIs('customer.contact') ? 'active' : '' }}">{{ __('Contact') }}</a>
        </nav>
        
        <div class="header-icons">
            @php
                $cart = session('cart', []);
                $cartCount = 0;
                foreach ($cart as $it) {
                    $cartCount += (int) ($it['quantity'] ?? 0);
                }
            @endphp
            <div class="user-dropdown">
                <a href="#" id="userDropdown">
                    <i class="fas fa-user"></i>
                </a>
                <div class="dropdown-menu" id="userMenu" style="display: none;">
                    <a href="{{ route('profile.edit') }}" class="dropdown-item">
                        <i class="fas fa-user"></i>
                        {{ __('Profile') }}
                    </a>
                    
                    <div class="dropdown-item language-selector">
                        <i class="fas fa-globe"></i>
                        {{ __('Language') }}
                        <div class="language-submenu">
                            <a href="{{ route('locale', 'en') }}" class="lang-option" data-lang="en">
                                <i class="fas fa-flag-usa"></i> English
                            </a>
                            <a href="{{ route('locale', 'vi') }}" class="lang-option" data-lang="vi">
                                <i class="fas fa-flag"></i> Tiếng Việt
                            </a>
                            <a href="{{ route('locale', 'ja') }}" class="lang-option" data-lang="ja">
                                <i class="fas fa-flag"></i> 日本語
                            </a>
                        </div>
                    </div>
                    
                    <div class="dropdown-divider"></div>
                    <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                        @csrf
                        <button type="submit" class="dropdown-item logout-btn">
                            <i class="fas fa-sign-out-alt"></i>
                            {{ __('Logout') }}
                        </button>
                    </form>
                </div>
            </div>
            <a href="#"><i class="fas fa-search"></i></a>
            <a href="#"><i class="fas fa-heart"></i></a>
            <a href="{{ route('customer.cart.index') }}" class="cart-link">
                <i class="fas fa-shopping-cart"></i>
                @if($cartCount > 0)
                <span class="cart-count">{{ $cartCount }}</span>
                @endif
            </a>
        </div>
    </div>
</header>

<style>
.user-dropdown {
    position: relative;
}

.dropdown-menu {
    position: absolute;
    top: 100%;
    right: 0;
    background: white;
    border: 1px solid #ddd;
    border-radius: 4px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    min-width: 140px;
    z-index: 1000;
}

.dropdown-menu a, .dropdown-menu button {
    display: block;
    padding: 10px 15px;
    text-decoration: none;
    color: #333;
    border: none;
    background: none;
    width: 100%;
    text-align: left;
    cursor: pointer;
}

.dropdown-menu a:hover, .dropdown-menu button:hover {
    background: #f5f5f5;
}

.dropdown-item {
    display: flex;
    align-items: center;
    padding: 10px 15px;
    text-decoration: none;
    color: #333;
    border: none;
    background: none;
    width: 100%;
    text-align: left;
    cursor: pointer;
    white-space: nowrap;
}

.dropdown-item i {
    margin-right: 8px;
    width: 16px;
}

.dropdown-divider {
    height: 1px;
    background: #eee;
    margin: 8px 0;
}

/* Language Selector */
.language-selector {
    position: relative;
    cursor: pointer;
}

.language-submenu {
    position: absolute;
    right: 100%;
    top: 0;
    background: white;
    border-radius: 8px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.15);
    padding: 8px 0;
    min-width: 150px;
    opacity: 0;
    visibility: hidden;
    transform: translateX(10px);
    transition: all 0.3s ease;
    z-index: 1000;
    border: 1px solid #ddd;
}

.language-selector:hover .language-submenu {
    opacity: 1;
    visibility: visible;
    transform: translateX(0);
}

.lang-option {
    display: flex;
    align-items: center;
    padding: 10px 15px;
    color: #333;
    text-decoration: none;
    transition: background 0.3s ease;
    font-size: 14px;
}

.lang-option:hover {
    background: #f8f9fa;
}

.lang-option i {
    margin-right: 8px;
    width: 16px;
    font-size: 12px;
}

.dropdown-item.language-selector:hover {
    background: #f8f9fa;
}

.logout-btn {
    border: none;
    background: none;
    width: 100%;
    text-align: left;
    cursor: pointer;
}

/* Cart icon badge */
.cart-link {
    position: relative;
    display: inline-block;
}
.cart-count {
    position: absolute;
    top: -6px;
    right: -10px;
    background: #E97171;
    color: #fff;
    border-radius: 999px;
    font-size: 12px;
    line-height: 1;
    padding: 2px 6px;
    min-width: 18px;
    text-align: center;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const userDropdown = document.getElementById('userDropdown');
    const userMenu = document.getElementById('userMenu');
    
    userDropdown.addEventListener('click', function(e) {
        e.preventDefault();
        userMenu.style.display = userMenu.style.display === 'none' ? 'block' : 'none';
    });
    
    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        if (!userDropdown.contains(e.target)) {
            userMenu.style.display = 'none';
        }
    });
});
</script>
