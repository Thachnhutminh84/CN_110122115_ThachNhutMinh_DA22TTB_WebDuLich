// Index Page Special Effects

class IndexEffects {
    constructor() {
        this.init();
    }

    init() {
        this.setupParallax();
        this.setupCounterAnimation();
        this.setupCardAnimations();
        this.setupScrollEffects();
    }

    // Parallax effect for background images
    setupParallax() {
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            const parallaxElements = document.querySelectorAll('.bg1, .bg2, .bg3');
            
            parallaxElements.forEach((element, index) => {
                const speed = 0.5 + (index * 0.1);
                const yPos = -(scrolled * speed);
                element.style.transform = `translateY(${yPos}px) scale(1.1)`;
            });
        });
    }

    // Animated counters for statistics
    setupCounterAnimation() {
        const counters = [
            { element: document.querySelector('.stat-counter-1'), target: 140, suffix: '+' },
            { element: document.querySelector('.stat-counter-2'), target: 3.5, suffix: 'M' },
            { element: document.querySelector('.stat-counter-3'), target: 50, suffix: '+' },
            { element: document.querySelector('.stat-counter-4'), target: 3, suffix: '' }
        ];

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    this.animateCounter(entry.target);
                }
            });
        }, { threshold: 0.5 });

        counters.forEach(counter => {
            if (counter.element) {
                observer.observe(counter.element);
            }
        });
    }

    animateCounter(element) {
        const target = parseInt(element.dataset.target);
        const duration = 2000;
        const start = 0;
        const increment = target / (duration / 16);
        let current = start;

        const timer = setInterval(() => {
            current += increment;
            if (current >= target) {
                current = target;
                clearInterval(timer);
            }
            
            if (element.dataset.suffix === 'M') {
                element.textContent = (current / 1000000).toFixed(1) + 'M';
            } else {
                element.textContent = Math.floor(current) + (element.dataset.suffix || '');
            }
        }, 16);
    }

    // Card hover animations
    setupCardAnimations() {
        const cards = document.querySelectorAll('.nav-card, .featured-card');
        
        cards.forEach(card => {
            card.addEventListener('mouseenter', () => {
                this.addCardGlow(card);
            });
            
            card.addEventListener('mouseleave', () => {
                this.removeCardGlow(card);
            });
        });
    }

    addCardGlow(card) {
        card.style.boxShadow = '0 20px 40px rgba(0, 0, 0, 0.3), 0 0 20px rgba(59, 130, 246, 0.3)';
        card.style.transform = 'translateY(-8px) scale(1.02)';
    }

    removeCardGlow(card) {
        card.style.boxShadow = '';
        card.style.transform = '';
    }

    // Scroll-triggered animations
    setupScrollEffects() {
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '50px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-in');
                }
            });
        }, observerOptions);

        // Observe elements for scroll animations
        document.querySelectorAll('.scroll-animate').forEach(el => {
            observer.observe(el);
        });
    }

    // Smooth page transitions
    setupPageTransitions() {
        document.querySelectorAll('a[href^="dia-diem"], a[href^="am-thuc"], a[href^="lien-he"], a[href^="dang-nhap"]').forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                const href = link.getAttribute('href');
                
                // Add fade out effect
                document.body.style.opacity = '0';
                document.body.style.transition = 'opacity 0.3s ease';
                
                setTimeout(() => {
                    window.location.href = href;
                }, 300);
            });
        });
    }

    // Dynamic background color based on time
    setupDynamicBackground() {
        const hour = new Date().getHours();
        const hero = document.querySelector('nav');
        
        if (hour >= 6 && hour < 12) {
            // Morning - lighter overlay
            hero.querySelector('.absolute.inset-0.bg-black').style.backgroundColor = 'rgba(0, 0, 0, 0.3)';
        } else if (hour >= 12 && hour < 18) {
            // Afternoon - medium overlay
            hero.querySelector('.absolute.inset-0.bg-black').style.backgroundColor = 'rgba(0, 0, 0, 0.4)';
        } else {
            // Evening/Night - darker overlay
            hero.querySelector('.absolute.inset-0.bg-black').style.backgroundColor = 'rgba(0, 0, 0, 0.6)';
        }
    }

    // Typing effect for main title
    setupTypingEffect() {
        const title = document.querySelector('h1 span');
        if (!title) return;

        const text = title.textContent;
        title.textContent = '';
        
        let i = 0;
        const typeWriter = () => {
            if (i < text.length) {
                title.textContent += text.charAt(i);
                i++;
                setTimeout(typeWriter, 100);
            }
        };
        
        setTimeout(typeWriter, 1000);
    }
}

// Utility functions
function addRippleEffect(element) {
    element.addEventListener('click', function(e) {
        const ripple = document.createElement('span');
        const rect = this.getBoundingClientRect();
        const size = Math.max(rect.width, rect.height);
        const x = e.clientX - rect.left - size / 2;
        const y = e.clientY - rect.top - size / 2;
        
        ripple.style.width = ripple.style.height = size + 'px';
        ripple.style.left = x + 'px';
        ripple.style.top = y + 'px';
        ripple.classList.add('ripple');
        
        this.appendChild(ripple);
        
        setTimeout(() => {
            ripple.remove();
        }, 600);
    });
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    new IndexEffects();
    
    // Add ripple effect to buttons
    document.querySelectorAll('.nav-card, button, .btn').forEach(addRippleEffect);
});

// CSS for ripple effect
const rippleCSS = `
.ripple {
    position: absolute;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.3);
    transform: scale(0);
    animation: ripple-animation 0.6s linear;
    pointer-events: none;
}

@keyframes ripple-animation {
    to {
        transform: scale(4);
        opacity: 0;
    }
}
`;

// Inject ripple CSS
const style = document.createElement('style');
style.textContent = rippleCSS;
document.head.appendChild(style);