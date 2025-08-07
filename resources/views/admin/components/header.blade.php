<!-- Header -->
<header class="header">
    <h1 id="page-title">Dashboard</h1>
    <div class="header-actions">
        <div class="user-dropdown">
            <div class="user-avatar">
                <i class="fas fa-user"></i>
            </div>
            <div>
                <div style="font-weight: 600;"><?php echo e(auth()->user()->name); ?></div>
                <div style="font-size: 12px; color: #666;">Administrator</div>
            </div>
            <i class="fas fa-chevron-down" style="margin-left: 10px; font-size: 12px;"></i>
            
            <div class="dropdown-menu">
                <div class="dropdown-item language-selector">
                    <i class="fas fa-globe"></i>
                    Language
                    <div class="language-submenu">
                        <a href="#" class="lang-option" data-lang="en">
                            <i class="fas fa-flag-usa"></i> English
                        </a>
                        <a href="#" class="lang-option" data-lang="vi">
                            <i class="fas fa-flag"></i> Tiếng Việt
                        </a>
                        <a href="#" class="lang-option" data-lang="ja">
                            <i class="fas fa-flag"></i> 日本語
                        </a>
                    </div>
                </div>
                <div class="dropdown-divider"></div>
                <form method="POST" action="{{ route('admin.logout') }}" style="margin: 0;">
                    @csrf
                    <button type="submit" class="dropdown-item logout-btn" style="border: none; background: none; width: 100%; text-align: left; cursor: pointer;">
                        <i class="fas fa-sign-out-alt"></i>
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>
