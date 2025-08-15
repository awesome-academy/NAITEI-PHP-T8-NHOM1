class AdminPanel {
    constructor() {
        this.init();
    }

    init() {
        this.bindEvents();
        this.updateStats();
    }

    bindEvents() {
        // Modal trigger buttons
        document.addEventListener('click', (e) => {
            const button = e.target.closest('button[data-modal]');
            if (button) {
                e.preventDefault();
                const modalId = button.getAttribute('data-modal');
                this.openModal(modalId);
            }
        });

        // User dropdown events
        document.addEventListener('click', (e) => {
            const dropdown = document.querySelector('.user-dropdown');
            if (e.target.closest('.user-dropdown')) {
                if (dropdown) {
                    dropdown.classList.toggle('active');
                }
            } else {
                if (dropdown) {
                    dropdown.classList.remove('active');
                }
            }
        });

        // Modal events
        document.addEventListener('click', (e) => {
            if (e.target.classList.contains('modal')) {
                e.target.classList.remove('active');
            }
        });

        // Logout button
        document.addEventListener('click', (e) => {
            if (e.target.closest('.logout-btn')) {
                if (!confirm('Are you sure you want to log out?')) {
                    e.preventDefault();
                }
            }
        });

        // Form events
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', this.handleFormSubmit.bind(this));
        });

        // Auto-update stats every 30 seconds
        setInterval(() => this.updateStats(), 30000);
    }

    handleFormSubmit(e) {
        console.log('Form being submitted:', e.target);
    }

    openModal(modalId) {
        console.log('Opening modal:', modalId); // Debug log
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.add('active');
        } else {
            console.error('Modal not found:', modalId);
        }
    }

    closeModal(modalId) {
        console.log('Closing modal:', modalId); // Debug log
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.remove('active');
        }
    }

    updateStats() {
        // Only update stats if we're on dashboard page
        if (!window.location.pathname.includes('/admin') || window.location.pathname.includes('/users') || window.location.pathname.includes('/products')) {
            return;
        }

        // Fetch updated stats from server
        fetch('/admin/dashboard/stats')
            .then(response => response.json())
            .then(data => {
                // Update stat numbers with real data
                const statCards = document.querySelectorAll('.stat-card');
                if (statCards.length >= 6 && data) {
                    // Users
                    const usersStat = statCards[0].querySelector('.stat-number');
                    if (usersStat && data.total_users !== undefined) {
                        usersStat.textContent = data.total_users.toLocaleString();
                    }
                    
                    // Categories  
                    const categoriesStat = statCards[1].querySelector('.stat-number');
                    if (categoriesStat && data.total_categories !== undefined) {
                        categoriesStat.textContent = data.total_categories.toLocaleString();
                    }
                    
                    // Products
                    const productsStat = statCards[2].querySelector('.stat-number');
                    if (productsStat && data.total_products !== undefined) {
                        productsStat.textContent = data.total_products.toLocaleString();
                    }
                    
                    // Orders
                    const ordersStat = statCards[3].querySelector('.stat-number');
                    if (ordersStat && data.total_orders !== undefined) {
                        ordersStat.textContent = data.total_orders.toLocaleString();
                    }
                    
                    // Feedbacks
                    const feedbacksStat = statCards[4].querySelector('.stat-number');
                    if (feedbacksStat && data.total_feedbacks !== undefined) {
                        feedbacksStat.textContent = data.total_feedbacks.toLocaleString();
                    }
                }
            })
            .catch(error => {
                console.log('Stats update failed:', error);
                const statNumbers = document.querySelectorAll('.stat-number');
                statNumbers.forEach(stat => {
                    const currentValue = parseInt(stat.textContent.replace(/,/g, ''));
                    if (!isNaN(currentValue)) {
                        const change = Math.floor(Math.random() * 3) - 1;
                        const newValue = Math.max(0, currentValue + change);
                        stat.textContent = newValue.toLocaleString();
                    }
                });
            });
    }

    logout() {
        //console.log('Logout method called');
    }

}

// Language selector function
function selectLanguage(lang) {
    console.log('Language selected:', lang);

    window.location.href = `/language/${lang}`;
}

// Global functions for compatibility
function toggleDropdown() {
    const dropdown = document.querySelector('.user-dropdown');
    if (dropdown) {
        dropdown.classList.toggle('active');
    }
}

function logout() {
    //console.log('Global logout function called');
}

// Initialize admin panel
document.addEventListener('DOMContentLoaded', () => {
    // Bind language selector events
    document.querySelectorAll('.lang-option').forEach(option => {
        option.addEventListener('click', (e) => {
            e.preventDefault();
            const lang = e.target.closest('.lang-option').getAttribute('data-lang');
            selectLanguage(lang);
        });
    });

    // Initialize admin panel
    window.adminPanel = new AdminPanel();
});
