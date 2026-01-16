// Main JavaScript for Nuts & Berries Dry Fruits Store

// Global State
const AppState = {
    theme: 'light',
    cartCount: 0,
    wishlistCount: 0
};

// Initialize application
function initializeApp() {
    initializeTheme();
    setupEventListeners();
    setupScrollListener();
    updateBadgeCounts();
}

// Theme Management
function initializeTheme() {
    const savedTheme = localStorage.getItem('theme');
    const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    
    AppState.theme = savedTheme || (systemPrefersDark ? 'dark' : 'light');
    document.documentElement.setAttribute('data-theme', AppState.theme);
    
    // Update toggle button icon
    const themeToggle = document.getElementById('themeToggle');
    if (themeToggle) {
        themeToggle.innerHTML = AppState.theme === 'dark' 
            ? '<i class="fas fa-moon"></i>' 
            : '<i class="fas fa-sun"></i>';
    }
}

function toggleTheme() {
    AppState.theme = AppState.theme === 'dark' ? 'light' : 'dark';
    document.documentElement.setAttribute('data-theme', AppState.theme);
    localStorage.setItem('theme', AppState.theme);
    
    // Update toggle button
    const themeToggle = document.getElementById('themeToggle');
    if (themeToggle) {
        themeToggle.innerHTML = AppState.theme === 'dark' 
            ? '<i class="fas fa-moon"></i>' 
            : '<i class="fas fa-sun"></i>';
    }
}

// Update badge counts from session
function updateBadgeCounts() {
    // Update cart count from data attribute if available
    const cartCountElement = document.querySelector('.cart-count');
    if (cartCountElement) {
        const count = cartCountElement.textContent;
        AppState.cartCount = parseInt(count) || 0;
    }
}

// Scroll handling
function setupScrollListener() {
    const header = document.getElementById('mainHeader');
    const backToTop = document.getElementById('backToTop');
    
    if (header) {
        window.addEventListener('scroll', () => {
            if (window.pageYOffset > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
            
            if (backToTop) {
                if (window.pageYOffset > 300) {
                    backToTop.classList.add('visible');
                } else {
                    backToTop.classList.remove('visible');
                }
            }
        });
    }
    
    if (backToTop) {
        backToTop.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }
}

// Toast notification function
function showToast(message, type = 'info') {
    const container = document.getElementById('toastContainer');
    if (!container) return;
    
    const toast = document.createElement('div');
    toast.className = `toast show align-items-center text-white bg-${type === 'error' ? 'danger' : type} border-0`;
    toast.setAttribute('role', 'alert');
    toast.setAttribute('aria-live', 'assertive');
    toast.setAttribute('aria-atomic', 'true');
    
    toast.innerHTML = `
        <div class="d-flex">
            <div class="toast-body">
                <i class="fas ${getToastIcon(type)} me-2"></i>
                ${message}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    `;
    
    container.appendChild(toast);
    
    // Initialize Bootstrap toast
    const bsToast = new bootstrap.Toast(toast, { delay: 3000 });
    bsToast.show();
    
    // Remove toast after it hides
    toast.addEventListener('hidden.bs.toast', () => {
        toast.remove();
    });
}

function getToastIcon(type) {
    switch (type) {
        case 'success': return 'fa-check-circle';
        case 'error': return 'fa-exclamation-circle';
        case 'warning': return 'fa-exclamation-triangle';
        default: return 'fa-info-circle';
    }
}

// Event Listeners
function setupEventListeners() {
    // Theme toggle
    const themeToggle = document.getElementById('themeToggle');
    if (themeToggle) {
        themeToggle.addEventListener('click', toggleTheme);
    }
    
    // Mobile navigation
    const mobileToggle = document.getElementById('mobileToggle');
    const mobileClose = document.getElementById('mobileClose');
    
    if (mobileToggle) {
        mobileToggle.addEventListener('click', () => {
            document.getElementById('navMain').classList.add('active');
            document.body.style.overflow = 'hidden';
        });
    }
    
    if (mobileClose) {
        mobileClose.addEventListener('click', () => {
            document.getElementById('navMain').classList.remove('active');
            document.body.style.overflow = '';
        });
    }
    
    // Mobile search
    const searchToggle = document.getElementById('searchToggle');
    const searchClose = document.getElementById('mobileSearchClose');
    
    if (searchToggle) {
        searchToggle.addEventListener('click', () => {
            document.getElementById('mobileSearchOverlay').classList.add('active');
        });
    }
    
    if (searchClose) {
        searchClose.addEventListener('click', () => {
            document.getElementById('mobileSearchOverlay').classList.remove('active');
        });
    }
    
    // Handle window resize
    window.addEventListener('resize', () => {
        if (window.innerWidth >= 992) {
            document.getElementById('navMain').classList.remove('active');
            document.body.style.overflow = '';
        }
    });
    
    // Handle escape key
    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            document.getElementById('navMain').classList.remove('active');
            document.getElementById('mobileSearchOverlay').classList.remove('active');
            document.body.style.overflow = '';
        }
    });
    
    // Close mobile menu when clicking outside
    document.addEventListener('click', function(event) {
        const navMain = document.getElementById('navMain');
        const mobileToggle = document.getElementById('mobileToggle');
        
        if (navMain && navMain.classList.contains('active') &&
            !navMain.contains(event.target) &&
            !mobileToggle.contains(event.target)) {
            navMain.classList.remove('active');
            document.body.style.overflow = '';
        }
    });
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', initializeApp);