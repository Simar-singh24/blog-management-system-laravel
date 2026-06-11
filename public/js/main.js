// Main JavaScript File
document.addEventListener('DOMContentLoaded', function() {
    // Initialize animations
    initializeAnimations();
    initializeEventListeners();
});

/**
 * Initialize GSAP animations
 */
function initializeAnimations() {
    gsap.registerPlugin(ScrollTrigger);

    // Prevent animation on reduced motion preference
    if (!window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        // Stagger animation for elements
        gsap.utils.toArray('[data-animate]').forEach((element, index) => {
            gsap.from(element, {
                opacity: 0,
                y: 30,
                duration: 0.6,
                delay: index * 0.1,
                ease: 'power3.out'
            });
        });

        // Scroll trigger animations
        // Exclude the hero section so the page header/hero isn't left at opacity:0 on load
        gsap.utils.toArray('section').forEach((section) => {
            if (section.classList && section.classList.contains('hero-section')) return;

            gsap.from(section, {
                opacity: 0,
                y: 40,
                duration: 0.8,
                scrollTrigger: {
                    trigger: section,
                    start: 'top 85%',
                    toggleActions: 'play none none none'
                }
            });
        });
    }
}

/**
 * Initialize event listeners
 */
function initializeEventListeners() {
    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if (href !== '#') {
                e.preventDefault();
                const target = document.querySelector(href);
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            }
        });
    });

    // Add active class to navbar links on scroll
    const navLinks = document.querySelectorAll('.navbar a');
    window.addEventListener('scroll', () => {
        let current = '';
        document.querySelectorAll('section').forEach(section => {
            const sectionTop = section.offsetTop;
            if (pageYOffset >= sectionTop - 200) {
                current = section.getAttribute('id');
            }
        });

        navLinks.forEach(link => {
            link.classList.remove('active');
            if (link.getAttribute('href').slice(1) === current) {
                link.classList.add('active');
            }
        });
    });

    // Navbar collapse on link click
    const navbarCollapse = document.querySelector('.navbar-collapse');
    if (navbarCollapse) {
        document.querySelectorAll('.navbar a').forEach(link => {
            link.addEventListener('click', () => {
                const bsCollapse = new bootstrap.Collapse(navbarCollapse, {
                    toggle: false
                });
                bsCollapse.hide();
            });
        });
    }
}

/**
 * Format date helper
 */
function formatDate(date) {
    return new Date(date).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    });
}

/**
 * Show loading state
 */
function showLoading(element) {
    element.classList.add('loading');
    element.disabled = true;
}

/**
 * Hide loading state
 */
function hideLoading(element) {
    element.classList.remove('loading');
    element.disabled = false;
}

/**
 * Debounce function for search
 */
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

/**
 * Throttle function
 */
function throttle(func, limit) {
    let inThrottle;
    return function(...args) {
        if (!inThrottle) {
            func.apply(this, args);
            inThrottle = true;
            setTimeout(() => inThrottle = false, limit);
        }
    };
}

/**
 * Custom cursor (for desktop only)
 */
function initCustomCursor() {
    if (!window.matchMedia('(max-width: 768px)').matches) {
        const cursor = document.createElement('div');
        cursor.className = 'custom-cursor';
        document.body.appendChild(cursor);

        document.addEventListener('mousemove', (e) => {
            cursor.style.left = e.clientX + 'px';
            cursor.style.top = e.clientY + 'px';
        });

        // Show/hide cursor on hover
        document.querySelectorAll('a, button').forEach(el => {
            el.addEventListener('mouseenter', () => {
                cursor.style.transform = 'scale(1.5)';
            });
            el.addEventListener('mouseleave', () => {
                cursor.style.transform = 'scale(1)';
            });
        });
    }
}

/**
 * Lazy load images
 */
function lazyLoadImages() {
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.classList.remove('lazy-load');
                    observer.unobserve(img);
                }
            });
        });

        document.querySelectorAll('img[data-src]').forEach(img => {
            imageObserver.observe(img);
        });
    }
}

/**
 * Reading time calculator
 */
function calculateReadingTime(text) {
    const wordsPerMinute = 200;
    const words = text.trim().split(/\s+/).length;
    return Math.ceil(words / wordsPerMinute);
}

/**
 * Copy to clipboard
 */
function copyToClipboard(text) {
    if (navigator.clipboard) {
        navigator.clipboard.writeText(text).then(() => {
            alert('Copied to clipboard!');
        });
    }
}

/**
 * Smooth page transitions
 */
function smoothPageTransition() {
    window.addEventListener('beforeunload', () => {
        document.body.style.opacity = '0';
        document.body.style.transition = 'opacity 0.3s ease-out';
    });

    window.addEventListener('pageshow', () => {
        document.body.style.opacity = '1';
    });
}

/**
 * Initialize on page load
 */
window.addEventListener('load', () => {
    lazyLoadImages();
    initCustomCursor();
    smoothPageTransition();
});

// Export for external use
window.BlogUtils = {
    formatDate,
    showLoading,
    hideLoading,
    debounce,
    throttle,
    calculateReadingTime,
    copyToClipboard
};
