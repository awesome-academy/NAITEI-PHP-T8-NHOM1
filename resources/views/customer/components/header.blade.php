<header class="header">
    <div class="header-container">
        <a href="{{ route('customer.categories') }}" class="logo">
            <i class="fas fa-couch"></i>
            Furniro
        </a>
        
        <nav class="nav-menu">
            <a href="{{ route('customer.categories') }}" class="{{ request()->routeIs('customer.categories') ? 'active' : '' }}">Shop</a>
            <a href="#">About</a>
            <a href="#">Contact</a>
        </nav>
        
        <div class="header-icons">
            <div class="user-dropdown">
                <a href="#" id="userDropdown">
                    <i class="fas fa-user"></i>
                </a>
                <div class="dropdown-menu" id="userMenu" style="display: none;">
                    <a href="{{ route('profile.edit') }}">Profile</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit">Logout</button>
                    </form>
                </div>
            </div>
            <a href="#"><i class="fas fa-search"></i></a>
            <a href="#"><i class="fas fa-heart"></i></a>
            <a href="#"><i class="fas fa-shopping-cart"></i></a>
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
    min-width: 120px;
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
