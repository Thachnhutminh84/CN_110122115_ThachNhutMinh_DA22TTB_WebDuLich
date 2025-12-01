/**
 * Mobile Menu Handler - Simple Version
 * Xử lý menu responsive cho thiết bị di động
 * Version 3.0 - Simplified
 */

(function() {
    'use strict';

    // State
    let isMenuOpen = false;

    /**
     * Initialize when DOM is ready
     */
    document.addEventListener('DOMContentLoaded', function() {
        initHamburgerButton();
        initScrollToTop();
        handleScrollEffects();
    });

    /**
     * Initialize hamburger button click handler
     */
    function initHamburgerButton() {
        // Find existing hamburger buttons
        const hamburgerBtns = document.querySelectorAll('.hamburger-btn, .mobile-menu-toggle, #hamburgerBtn');
        
        hamburgerBtns.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                toggleMobileMenu();
            });
        });

        // Close menu when clicking overlay
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('mobile-nav-overlay')) {
                closeMobileMenu();
            }
        });

        // Close menu when clicking close button
        const closeBtn = document.querySelector('.mobile-menu-close');
        if (closeBtn) {
            closeBtn.addEventListener('click', closeMobileMenu);
        }

        // Close menu when clicking menu links
        const menuLinks = document.querySelectorAll('.mobile-menu-link');
        menuLinks.forEach(link => {
            link.addEventListener('click', closeMobileMenu);
        });

        // Close menu on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && isMenuOpen) {
                closeMobileMenu();
            }
        });

        // Close menu on window resize to desktop
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 768 && isMenuOpen) {
                closeMobileMenu();
            }
        });
    }

    /**
     * Toggle mobile menu
     */
    function toggleMobileMenu() {
        if (isMenuOpen) {
            closeMobileMenu();
        } else {
            openMobileMenu();
        }
    }

    /**
     * Open mobile menu
     */
    function openMobileMenu() {
        const overlay = document.querySelector('.mobile-nav-overlay, #mobileNavOverlay');
        const menu = document.querySelector('.mobile-menu-container, #mobileMenuContainer');
        const btn = document.querySelector('.hamburger-btn, #hamburgerBtn');

        if (overlay) {
            overlay.classList.add('active');
            overlay.style.display = 'block';
        }
        if (menu) {
            menu.classList.add('active');
            menu.style.display = 'block';
        }
        if (btn) {
            btn.classList.add('active');
        }
        
        document.body.style.overflow = 'hidden';
        isMenuOpen = true;
    }

    /**
     * Close mobile menu
     */
    function closeMobileMenu() {
        const overlay = document.querySelector('.mobile-nav-overlay, #mobileNavOverlay');
        const menu = document.querySelector('.mobile-menu-container, #mobileMenuContainer');
        const btn = document.querySelector('.hamburger-btn, #hamburgerBtn');

        if (overlay) {
            overlay.classList.remove('active');
            setTimeout(() => {
                overlay.style.display = 'none';
            }, 300);
        }
        if (menu) {
            menu.classList.remove('active');
            setTimeout(() => {
                menu.style.display = 'none';
            }, 300);
        }
        if (btn) {
            btn.classList.remove('active');
        }
        
        document.body.style.overflow = '';
        isMenuOpen = false;
    }

    /**
     * Initialize scroll to top button
     */
    function initScrollToTop() {
        // Check if button already exists
        let btn = document.querySelector('.scroll-to-top, #scrollToTop');
        
        if (!btn) {
            btn = document.createElement('button');
            btn.className = 'scroll-to-top';
            btn.id = 'scrollToTop';
            btn.setAttribute('aria-label', 'Lên đầu trang');
            btn.innerHTML = '<i class="fas fa-arrow-up"></i>';
            btn.style.cssText = `
                position: fixed;
                bottom: 30px;
                right: 20px;
                width: 44px;
                height: 44px;
                background: linear-gradient(135deg, #3b82f6, #1d4ed8);
                color: white;
                border: none;
                border-radius: 50%;
                box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.25rem;
                opacity: 0;
                visibility: hidden;
                transform: translateY(20px);
                transition: all 0.3s ease;
                z-index: 998;
            `;
            document.body.appendChild(btn);
        }

        btn.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // Show/hide based on scroll
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                btn.style.opacity = '1';
                btn.style.visibility = 'visible';
                btn.style.transform = 'translateY(0)';
            } else {
                btn.style.opacity = '0';
                btn.style.visibility = 'hidden';
                btn.style.transform = 'translateY(20px)';
            }
        }, { passive: true });
    }

    /**
     * Handle scroll effects for header
     */
    function handleScrollEffects() {
        const header = document.querySelector('header, .header');
        if (!header) return;

        let lastScroll = 0;

        window.addEventListener('scroll', function() {
            const currentScroll = window.pageYOffset;

            // Add scrolled class
            if (currentScroll > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }

            lastScroll = currentScroll;
        }, { passive: true });
    }

    /**
     * Show toast notification
     */
    window.showToast = function(message, type = 'info', duration = 3000) {
        let container = document.querySelector('.toast-container');
        if (!container) {
            container = document.createElement('div');
            container.className = 'toast-container';
            container.style.cssText = `
                position: fixed;
                bottom: 80px;
                left: 15px;
                right: 15px;
                z-index: 10000;
                display: flex;
                flex-direction: column;
                gap: 10px;
                pointer-events: none;
            `;
            document.body.appendChild(container);
        }

        const colors = {
            success: 'linear-gradient(135deg, #10b981, #059669)',
            error: 'linear-gradient(135deg, #ef4444, #dc2626)',
            warning: 'linear-gradient(135deg, #f59e0b, #d97706)',
            info: 'linear-gradient(135deg, #3b82f6, #1d4ed8)'
        };

        const icons = {
            success: 'fa-check-circle',
            error: 'fa-times-circle',
            warning: 'fa-exclamation-triangle',
            info: 'fa-info-circle'
        };

        const toast = document.createElement('div');
        toast.style.cssText = `
            background: ${colors[type] || colors.info};
            color: white;
            padding: 15px 20px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            display: flex;
            align-items: center;
            gap: 12px;
            animation: slideUp 0.3s ease;
            pointer-events: auto;
        `;
        toast.innerHTML = `
            <i class="fas ${icons[type] || icons.info}" style="font-size: 1.25rem;"></i>
            <span style="flex: 1; font-size: 0.9rem;">${message}</span>
        `;

        container.appendChild(toast);

        // Auto remove
        setTimeout(() => {
            toast.style.animation = 'slideUp 0.3s ease reverse';
            setTimeout(() => toast.remove(), 300);
        }, duration);
    };

    /**
     * Expose functions globally
     */
    window.openMobileMenu = openMobileMenu;
    window.closeMobileMenu = closeMobileMenu;
    window.toggleMobileMenu = toggleMobileMenu;

})();

// Add CSS animation
const style = document.createElement('style');
style.textContent = `
    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
`;
document.head.appendChild(style);
