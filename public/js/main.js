// Main JavaScript for Nuts & Berries Dry Fruits Store

// Global State
const AppState = {
    theme: 'light',
    cartCount: 0,
    wishlistCount: 0,
    currency: 'USD',
    isLoading: false
};

// Initialize application
function initializeApp() {
    initializeTheme();
    initializeCart();
    initializeWishlist();
    setupEventListeners();
    setupIntersectionObservers();
    setupLoadingHandler();
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
    
    // Dispatch event for other components
    document.dispatchEvent(new CustomEvent('themeChanged', { 
        detail: { theme: AppState.theme } 
    }));
}

// Cart Management
async function initializeCart() {
    try {
        const response = await fetch('/api/cart/count');
        const data = await response.json();
        AppState.cartCount = data.count || 0;
        updateCartUI();
    } catch (error) {
        console.error('Failed to load cart:', error);
        AppState.cartCount = 0;
    }
}

async function addToCart(productId, quantity = 1) {
    if (AppState.isLoading) return;
    
    startLoading();
    
    try {
        const response = await fetch('/api/cart/add', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                product_id: productId,
                quantity: quantity
            })
        });
        
        const data = await response.json();
        
        if (data.success) {
            AppState.cartCount = data.cart_count;
            updateCartUI();
            showToast('Added to cart!', 'success');
            
            // Trigger cart updated event
            document.dispatchEvent(new CustomEvent('cartUpdated', {
                detail: { count: AppState.cartCount }
            }));
        } else {
            showToast(data.message || 'Failed to add to cart', 'error');
        }
    } catch (error) {
        console.error('Add to cart error:', error);
        showToast('Network error. Please try again.', 'error');
    } finally {
        stopLoading();
    }
}

async function updateCartItem(itemId, quantity) {
    // Similar implementation for updating cart items
}

async function removeFromCart(itemId) {
    // Similar implementation for removing cart items
}

function updateCartUI() {
    const cartCountElements = document.querySelectorAll('.cart-count, .badge-count');
    cartCountElements.forEach(element => {
        element.textContent = AppState.cartCount;
        element.style.display = AppState.cartCount > 0 ? 'flex' : 'none';
    });
}

// Wishlist Management
async function initializeWishlist() {
    try {
        const response = await fetch('/api/wishlist/count');
        const data = await response.json();
        AppState.wishlistCount = data.count || 0;
        updateWishlistUI();
    } catch (error) {
        console.error('Failed to load wishlist:', error);
        AppState.wishlistCount = 0;
    }
}

async function toggleWishlist(productId) {
    try {
        const response = await fetch(`/api/wishlist/toggle/${productId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });
        
        const data = await response.json();
        
        if (data.success) {
            AppState.wishlistCount = data.count;
            updateWishlistUI();
            showToast(data.message, data.inWishlist ? 'success' : 'info');
            
            // Update button state
            const button = document.querySelector(`[data-wishlist-id="${productId}"]`);
            if (button) {
                const icon = button.querySelector('i');
                if (data.inWishlist) {
                    icon.classList.remove('far');
                    icon.classList.add('fas', 'text-danger');
                } else {
                    icon.classList.remove('fas', 'text-danger');
                    icon.classList.add('far');
                }
            }
        }
    } catch (error) {
        console.error('Wishlist error:', error);
        showToast('Failed to update wishlist', 'error');
    }
}

function updateWishlistUI() {
    const wishlistElements = document.querySelectorAll('.wishlist-count');
    wishlistElements.forEach(element => {
        element.textContent = AppState.wishlistCount;
        element.style.display = AppState.wishlistCount > 0 ? 'inline' : 'none';
    });
}

// Toast Notifications
function showToast(message, type = 'info', duration = 3000) {
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
    const bsToast = new bootstrap.Toast(toast, { delay: duration });
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

// Loading Handler
function setupLoadingHandler() {
    // Show loading for all fetch requests
    const originalFetch = window.fetch;
    window.fetch = async function(...args) {
        startLoading();
        try {
            const response = await originalFetch.apply(this, args);
            return response;
        } finally {
            stopLoading();
        }
    };
}

function startLoading() {
    AppState.isLoading = true;
    const overlay = document.getElementById('loadingOverlay');
    if (overlay) {
        overlay.classList.add('active');
        document.body.style.overflow = 'hidden';
    }
}

function stopLoading() {
    AppState.isLoading = false;
    const overlay = document.getElementById('loadingOverlay');
    if (overlay) {
        overlay.classList.remove('active');
        document.body.style.overflow = '';
    }
}

// Intersection Observers for animations
function setupIntersectionObservers() {
    // Animate elements on scroll
    const animateElements = document.querySelectorAll('.animate-on-scroll');
    
    if ('IntersectionObserver' in window) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animated');
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '50px'
        });
        
        animateElements.forEach(el => observer.observe(el));
    }
}

// Product Interactions
function setupProductInteractions() {
    // Quick view
    document.querySelectorAll('.quick-view-btn').forEach(button => {
        button.addEventListener('click', async function(e) {
            e.preventDefault();
            const productId = this.dataset.productId;
            await showQuickView(productId);
        });
    });
    
    // Add to cart buttons
    document.querySelectorAll('.add-to-cart-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const productId = this.dataset.productId;
            const quantity = this.dataset.quantity || 1;
            addToCart(productId, quantity);
        });
    });
    
    // Wishlist buttons
    document.querySelectorAll('.wishlist-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const productId = this.dataset.productId;
            toggleWishlist(productId);
        });
    });
    
    // Quantity selectors
    document.querySelectorAll('.quantity-selector').forEach(selector => {
        const minusBtn = selector.querySelector('.quantity-minus');
        const plusBtn = selector.querySelector('.quantity-plus');
        const input = selector.querySelector('.quantity-input');
        
        minusBtn?.addEventListener('click', () => {
            const value = parseInt(input.value) || 1;
            if (value > 1) {
                input.value = value - 1;
                input.dispatchEvent(new Event('change'));
            }
        });
        
        plusBtn?.addEventListener('click', () => {
            const value = parseInt(input.value) || 1;
            const max = parseInt(input.max) || 99;
            if (value < max) {
                input.value = value + 1;
                input.dispatchEvent(new Event('change'));
            }
        });
    });
}

// Quick View Modal
async function showQuickView(productId) {
    try {
        const response = await fetch(`/api/products/${productId}/quick-view`);
        const data = await response.json();
        
        if (data.success) {
            const modal = new bootstrap.Modal(document.getElementById('quickViewModal'));
            const modalContent = document.getElementById('quickViewContent');
            
            modalContent.innerHTML = data.html;
            modal.show();
        }
    } catch (error) {
        console.error('Quick view error:', error);
        showToast('Failed to load product details', 'error');
    }
}

// Search functionality
function setupSearch() {
    const searchForm = document.querySelector('.search-form');
    const searchInput = document.querySelector('.search-input');
    
    if (searchForm && searchInput) {
        // Debounced search suggestions
        let timeoutId;
        searchInput.addEventListener('input', function() {
            clearTimeout(timeoutId);
            timeoutId = setTimeout(() => {
                if (this.value.length >= 2) {
                    fetchSearchSuggestions(this.value);
                }
            }, 300);
        });
        
        // Clear suggestions on blur
        searchInput.addEventListener('blur', () => {
            setTimeout(() => {
                hideSearchSuggestions();
            }, 200);
        });
    }
}

async function fetchSearchSuggestions(query) {
    try {
        const response = await fetch(`/api/search/suggestions?q=${encodeURIComponent(query)}`);
        const data = await response.json();
        
        if (data.suggestions && data.suggestions.length > 0) {
            showSearchSuggestions(data.suggestions);
        }
    } catch (error) {
        console.error('Search suggestions error:', error);
    }
}

function showSearchSuggestions(suggestions) {
    // Implementation for showing search suggestions dropdown
}

function hideSearchSuggestions() {
    // Implementation for hiding search suggestions
}

// Form validations
function setupFormValidations() {
    const forms = document.querySelectorAll('.needs-validation');
    
    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            
            form.classList.add('was-validated');
        }, false);
    });
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
    
    // Back to top
    const backToTop = document.getElementById('backToTop');
    if (backToTop) {
        window.addEventListener('scroll', () => {
            if (window.pageYOffset > 300) {
                backToTop.classList.add('visible');
            } else {
                backToTop.classList.remove('visible');
            }
        });
        
        backToTop.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }
    
    // Product interactions
    setupProductInteractions();
    
    // Search
    setupSearch();
    
    // Form validations
    setupFormValidations();
    
    // Close dropdowns when clicking outside
    document.addEventListener('click', (event) => {
        if (!event.target.matches('.dropdown-toggle')) {
            document.querySelectorAll('.dropdown').forEach(dropdown => {
                dropdown.classList.remove('open');
            });
        }
    });
    
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
}

// Currency formatting
function formatCurrency(amount, currency = AppState.currency) {
    const formatter = new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: currency,
        minimumFractionDigits: 2
    });
    
    return formatter.format(amount);
}

// Debounce utility
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Throttle utility
function throttle(func, limit) {
    let inThrottle;
    return function() {
        const args = arguments;
        const context = this;
        if (!inThrottle) {
            func.apply(context, args);
            inThrottle = true;
            setTimeout(() => inThrottle = false, limit);
        }
    };
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', initializeApp);

// Export for module usage if needed
if (typeof module !== 'undefined' && module.exports) {
    module.exports = {
        initializeApp,
        toggleTheme,
        addToCart,
        toggleWishlist,
        showToast,
        formatCurrency
    };
}