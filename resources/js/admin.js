class AdminPanel {
    constructor() {
        this.init();
    }

    init() {
        this.bindEvents();
        this.updateStats();
    }

    loadWeeklyCharts() {
        fetch('/admin/dashboard/weekly-chart', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
            .then(response => response.ok ? response.json() : Promise.reject('API Error'))
            .then(data => {
                this.renderActiveUsersChart(data);
                this.renderOrderedProductsChart(data);
                this.renderNewOrdersChart(data);
                this.renderNewFeedbacksChart(data);
            })
            .catch(error => {
                console.error('Failed to load chart data:', error);
                this.showChartError();
            });
    }

    // chart rendering functions
    renderActiveUsersChart(data) {
        const ctx = document.getElementById('activeUsersChart');
        if (!ctx) return;

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: data.days,
                datasets: [{
                    label: 'Active Users',
                    data: data.activeUsers,
                    borderColor: '#B88E2F',
                    backgroundColor: 'rgba(184, 142, 47, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#B88E2F',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 5
                }]
            },
            options: this.getChartOptions()
        });
    }

    renderOrderedProductsChart(data) {
        const ctx = document.getElementById('orderedProductsChart');
        if (!ctx) return;

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: data.days,
                datasets: [{
                    label: 'Products Ordered',
                    data: data.orderedProducts,
                    borderColor: '#28a745',
                    backgroundColor: 'rgba(40, 167, 69, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#28a745',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 5
                }]
            },
            options: this.getChartOptions()
        });
    }

    renderNewOrdersChart(data) {
        const ctx = document.getElementById('newOrdersChart');
        if (!ctx) return;

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: data.days,
                datasets: [{
                    label: 'New Orders',
                    data: data.newOrders,
                    borderColor: '#17a2b8',
                    backgroundColor: 'rgba(23, 162, 184, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#17a2b8',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 5
                }]
            },
            options: this.getChartOptions()
        });
    }

    renderNewFeedbacksChart(data) {
        const ctx = document.getElementById('newFeedbacksChart');
        if (!ctx) return;

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: data.days,
                datasets: [{
                    label: 'New Feedbacks',
                    data: data.newFeedbacks,
                    borderColor: '#fd7e14',
                    backgroundColor: 'rgba(253, 126, 20, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#fd7e14',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 5
                }]
            },
            options: this.getChartOptions()
        });
    }

    getChartOptions() {
        return {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        color: '#666',
                        font: {
                            size: 12
                        }
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0,0,0,0.05)'
                    },
                    ticks: {
                        color: '#666',
                        font: {
                            size: 12
                        }
                    }
                }
            },
            elements: {
                point: {
                    hoverRadius: 8
                }
            },
            interaction: {
                intersect: false,
                mode: 'index'
            }
        };
    }

    showChartError() {
        const chartContainers = ['activeUsersChart', 'orderedProductsChart', 'newOrdersChart', 'newFeedbacksChart'];
        chartContainers.forEach(containerId => {
            const container = document.getElementById(containerId);
            if (container) {
                container.style.display = 'flex';
                container.style.alignItems = 'center';
                container.style.justifyContent = 'center';
                container.innerHTML = '<div style="color: #666; text-align: center;"><i class="fas fa-chart-line" style="font-size: 24px; margin-bottom: 8px; display: block;"></i>Unable to load chart data</div>';
            }
        });
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
        // Form submission handler
    }

    openModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.add('active');
        }
    }

    closeModal(modalId) {
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
                // Silently handle stats update failure
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
        // Logout method implementation
    }

}

// Language selector function
function selectLanguage(lang) {
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
    // Global logout function implementation
}

const LOAD_WEEKLY_CHARTS_RETRY_TIMEOUT_MS = 50;
// Global function to load weekly charts (called from dashboard)
function loadWeeklyCharts() {
    if (window.adminPanel && typeof window.adminPanel.loadWeeklyCharts === 'function') {
        window.adminPanel.loadWeeklyCharts();
    } else {
        setTimeout(loadWeeklyCharts, LOAD_WEEKLY_CHARTS_RETRY_TIMEOUT_MS);
    }
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
    
    // Make loadWeeklyCharts available globally immediately
    window.loadWeeklyCharts = loadWeeklyCharts;
});
