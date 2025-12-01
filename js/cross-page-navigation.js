// Cross-Page Navigation System
// Automatically manages navigation links and active states across all pages

class CrossPageNavigation {
    constructor() {
        this.pages = {
            'index.html': { title: 'Trang Chủ', icon: 'fas fa-home' },
            'dia-diem-du-lich.html': { title: 'Địa Điểm', icon: 'fas fa-map-marker-alt' },
            'am-thuc.html': { title: 'Ẩm Thực', icon: 'fas fa-utensils' },
            'lien-he.html': { title: 'Liên Hệ', icon: 'fas fa-envelope' },
            'dang-nhap.html': { title: 'Đăng Nhập', icon: 'fas fa-user-circle' }
        };
        
        this.currentPage = this.getCurrentPage();
        this.init();
    }

    getCurrentPage() {
        const path = window.location.pathname;
        const filename = path.split('/').pop() || 'index.html';
        return filename;
    }

    init() {
        this.updateActiveNavigation();
        this.addMobileMenu();
        this.setupPageTransitions();
    }

    updateActiveNavigation() {
        // Update navigation links with active states
        const navLinks = document.querySelectorAll('nav a, .nav-link');
        
        navLinks.forEach(link => {
            const href = link.getAttribute('href');
            
            // Remove existing active classes
            link.classList.remove('text-blue-600', 'text-orange-600', 'text-purple-600', 'font-bold');
            
            // Add active class if this is the current page
            if (href === this.currentPage) {
                this.setActiveLink(link);
            }
        });
    }

    setActiveLink(link) {
        // Determine color based on current page
        const colors = {
            'index.html': 'text-blue-600',
            'dia-diem-du-lich.html': 'text-blue-600',
            'am-thuc.html': 'text-orange-600',
            'lien-he.html': 'text-purple-600',
            'dang-nhap.html': 'text-blue-600'
        };
        
        const activeColor = colors[this.currentPage] || 'text-blue-600';
        link.classList.add(activeColor, 'font-bold');
    }

    addMobileMenu() {
        // Add mobile hamburger menu if not exists
        const header = document.querySelector('header');
        if (!header || document.querySelector('.mobile-menu-toggle')) return;

        const nav = header.querySelector('nav');
        if (!nav) return;

        // Create mobile menu toggle
        const mobileToggle = document.createElement('button');
        mobileToggle.className = 'mobile-menu-toggle md:hidden text-gray-700 hover:text-blue-600 transition-colors';
        mobileToggle.innerHTML = '<i class="fas fa-bars text-xl"></i>';

        // Create mobile menu
        const mobileMenu = document.createElement('div');
        mobileMenu.className = 'mobile-menu hidden absolute top-full left-0 right-0 bg-white shadow-lg border-t z-40';
        
        // Clone navigation for mobile
        const mobileNav = this.createMobileNavigation();
        mobileMenu.appendChild(mobileNav);

        // Add toggle functionality
        mobileToggle.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
            const icon = mobileToggle.querySelector('i');
            icon.classList.toggle('fa-bars');
            icon.classList.toggle('fa-times');
        });

        // Insert mobile elements
        nav.parentNode.insertBefore(mobileToggle, nav);
        header.appendChild(mobileMenu);
    }

    createMobileNavigation() {
        const mobileNav = document.createElement('div');
        mobileNav.className = 'flex flex-col p-4 space-y-3';

        Object.entries(this.pages).forEach(([filename, page]) => {
            const link = document.createElement('a');
            link.href = filename;
            link.className = 'flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-100 transition-colors';
            
            if (filename === this.currentPage) {
                link.classList.add('bg-blue-50', 'text-blue-600', 'font-semibold');
            } else {
                link.classList.add('text-gray-700');
            }
            
            link.innerHTML = `
                <i class="${page.icon}"></i>
                <span>${page.title}</span>
            `;
            
            mobileNav.appendChild(link);
        });

        return mobileNav;
    }

    setupPageTransitions() {
        // Add smooth page transitions
        document.querySelectorAll('a[href$=".html"]').forEach(link => {
            link.addEventListener('click', (e) => {
                const href = link.getAttribute('href');
                
                // Skip if it's the current page or external link
                if (href === this.currentPage || href.startsWith('http')) return;
                
                // Add loading state
                this.showPageTransition();
            });
        });
    }

    showPageTransition() {
        // Create loading overlay
        const overlay = document.createElement('div');
        overlay.className = 'fixed inset-0 bg-white bg-opacity-90 z-50 flex items-center justify-center';
        overlay.innerHTML = `
            <div class="text-center">
                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mx-auto mb-4"></div>
                <p class="text-gray-600">Đang tải trang...</p>
            </div>
        `;
        
        document.body.appendChild(overlay);
        
        // Remove overlay after a short delay (in case page loads quickly)
        setTimeout(() => {
            if (overlay.parentNode) {
                overlay.remove();
            }
        }, 2000);
    }

    // Method to programmatically navigate
    navigateTo(page) {
        if (this.pages[page]) {
            this.showPageTransition();
            window.location.href = page;
        }
    }

    // Method to get navigation breadcrumb
    getBreadcrumb() {
        const breadcrumb = [
            { title: 'Trang Chủ', href: 'index.html' }
        ];
        
        if (this.currentPage !== 'index.html' && this.pages[this.currentPage]) {
            breadcrumb.push({
                title: this.pages[this.currentPage].title,
                href: this.currentPage
            });
        }
        
        return breadcrumb;
    }

    // Method to add breadcrumb to page
    addBreadcrumb(container) {
        const breadcrumb = this.getBreadcrumb();
        const breadcrumbHTML = breadcrumb.map((item, index) => {
            const isLast = index === breadcrumb.length - 1;
            return `
                <li class="flex items-center">
                    ${index > 0 ? '<i class="fas fa-chevron-right text-gray-400 mx-2"></i>' : ''}
                    ${isLast ? 
                        `<span class="text-gray-500">${item.title}</span>` :
                        `<a href="${item.href}" class="text-blue-600 hover:text-blue-800 transition-colors">${item.title}</a>`
                    }
                </li>
            `;
        }).join('');
        
        container.innerHTML = `<ol class="flex items-center">${breadcrumbHTML}</ol>`;
    }
}

// Initialize navigation system
document.addEventListener('DOMContentLoaded', () => {
    window.crossPageNav = new CrossPageNavigation();
    
    // Add breadcrumb if container exists
    const breadcrumbContainer = document.getElementById('breadcrumb');
    if (breadcrumbContainer) {
        window.crossPageNav.addBreadcrumb(breadcrumbContainer);
    }
});

// Export for use in other scripts
if (typeof module !== 'undefined' && module.exports) {
    module.exports = CrossPageNavigation;
}

// Utility functions for navigation
function goToPage(page) {
    if (window.crossPageNav) {
        window.crossPageNav.navigateTo(page);
    } else {
        window.location.href = page;
    }
}

function getCurrentPageInfo() {
    return window.crossPageNav ? {
        current: window.crossPageNav.currentPage,
        title: window.crossPageNav.pages[window.crossPageNav.currentPage]?.title
    } : null;
}