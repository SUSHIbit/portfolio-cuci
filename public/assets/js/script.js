// Adenekan Wonderful Portfolio - JavaScript Functionality

// DOM Content Loaded Event
document.addEventListener('DOMContentLoaded', function() {
    initializeThemeToggle();
    initializeNavigation();
    initializeContactForm();
    initializeSmoothScrolling();
    initializeProjectHovers();
    initializeAnimations();
    initializeProjectModals();
});

// Theme Toggle Functionality
function initializeThemeToggle() {
    const themeToggleDesktop = document.getElementById('theme-toggle-desktop');
    const themeToggleOverlay = document.getElementById('theme-toggle-overlay');
    const root = document.documentElement;

    // Check for saved theme preference or default to dark mode
    const currentTheme = localStorage.getItem('theme') || 'dark';

    if (currentTheme === 'light') {
        root.classList.add('light-theme');
        updateThemeToggleIcon(true);
    }

    // Initial header update
    updateHeaderScroll();
    forceHeaderThemeUpdate();

    // Theme toggle function
    function toggleTheme() {
        root.classList.toggle('light-theme');
        const isLight = root.classList.contains('light-theme');

        // Save theme preference
        localStorage.setItem('theme', isLight ? 'light' : 'dark');
        updateThemeToggleIcon(isLight);

        // Add transition effect to body
        document.body.style.transition = 'all 0.3s ease';

        // Force update header immediately after theme change
        setTimeout(() => {
            document.body.style.transition = '';
            updateHeaderScroll();
            forceHeaderThemeUpdate();
        }, 50);
    }

    // Theme toggle click handlers
    if (themeToggleDesktop) {
        themeToggleDesktop.addEventListener('click', toggleTheme);
    }

    if (themeToggleOverlay) {
        themeToggleOverlay.addEventListener('click', toggleTheme);
    }
}

// Update theme toggle icon
function updateThemeToggleIcon(isLight) {
    const themeToggleDesktop = document.getElementById('theme-toggle-desktop');
    const themeToggleOverlay = document.getElementById('theme-toggle-overlay');

    // Determine which icon to show based on current theme
    // When in dark mode, show light-mode icon (to switch to light)
    // When in light mode, show dark-mode icon (to switch to dark)
    const iconPath = isLight ? '/assets/images/dark-mode.png' : '/assets/images/light-mode.png';

    // Update desktop theme toggle
    if (themeToggleDesktop) {
        const icon = themeToggleDesktop.querySelector('.theme-toggle-icon');
        if (icon) {
            icon.src = iconPath;
            // Add rotation animation during transition
            icon.classList.add('transitioning');

            // Remove transition class after animation completes
            setTimeout(() => {
                icon.classList.remove('transitioning');
            }, 300);
        }
    }

    // Update overlay theme toggle
    if (themeToggleOverlay) {
        const icon = themeToggleOverlay.querySelector('.theme-toggle-icon');
        if (icon) {
            icon.src = iconPath;
            // Add rotation animation during transition
            icon.classList.add('transitioning');

            // Remove transition class after animation completes
            setTimeout(() => {
                icon.classList.remove('transitioning');
            }, 300);
        }
    }
}

// Force header theme update - Fallback function
function forceHeaderThemeUpdate() {
    const root = document.documentElement;
    const isLightTheme = root.classList.contains('light-theme');
    const header = document.querySelector('header');

    if (header) {
        // Get all text elements in header
        const textPrimary = header.querySelectorAll('.text-primary');
        const textSecondary = header.querySelectorAll('.text-secondary');
        const borderPrimary = header.querySelectorAll('.border-primary');

        if (isLightTheme) {
            // Light mode: dark text
            textPrimary.forEach(el => el.style.color = '#0a0a0a');
            textSecondary.forEach(el => el.style.color = '#404040');
            borderPrimary.forEach(el => el.style.borderColor = '#a3a3a3');
        } else {
            // Dark mode: light text
            textPrimary.forEach(el => el.style.color = '#ffffff');
            textSecondary.forEach(el => el.style.color = '#d4d4d4');
            borderPrimary.forEach(el => el.style.borderColor = '#525252');
        }
    }
}

// Navigation Functionality
function initializeNavigation() {
    // Get current page
    const currentPage = window.location.pathname.split('/').pop() || 'index.html';

    // Update active navigation state for both desktop and mobile
    const navLinks = document.querySelectorAll('nav a, .mobile-nav-link');
    navLinks.forEach(link => {
        const linkHref = link.getAttribute('href');
        if (linkHref === currentPage ||
            (currentPage === '' && linkHref === 'index.html') ||
            (currentPage === 'index.html' && linkHref === 'index.html')) {
            link.classList.add('nav-active');
        }
    });

    // Mobile navigation toggle
    const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
    const mobileMenuClose = document.getElementById('mobile-menu-close');
    const mobileMenu = document.querySelector('.nav-mobile');

    if (mobileMenuToggle && mobileMenu) {
        function openMobileMenu(e) {
            e.preventDefault();
            e.stopPropagation();

            mobileMenu.classList.add('active');
            // Don't transform the original hamburger - leave it as hamburger lines

            // Prevent body scroll and add class for fixed positioning
            document.body.classList.add('mobile-menu-open');
        }

        function closeMobileMenu() {
            mobileMenu.classList.remove('active');
            // Original hamburger stays as hamburger lines

            // Remove body scroll prevention
            document.body.classList.remove('mobile-menu-open');
        }

        // Open menu with hamburger button
        mobileMenuToggle.addEventListener('click', openMobileMenu);

        // Close menu with dedicated close button
        if (mobileMenuClose) {
            mobileMenuClose.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                closeMobileMenu();
            });
        }

        // Close mobile menu when clicking on nav links
        const mobileNavLinks = mobileMenu.querySelectorAll('.mobile-nav-link');
        mobileNavLinks.forEach(link => {
            link.addEventListener('click', function() {
                closeMobileMenu();
            });
        });

        // Close mobile menu when clicking outside
        document.addEventListener('click', function(e) {
            if (!mobileMenu.contains(e.target) && !mobileMenuToggle.contains(e.target)) {
                closeMobileMenu();
            }
        });

        // Close mobile menu on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && mobileMenu.classList.contains('active')) {
                closeMobileMenu();
            }
        });

        // Close mobile menu on window resize to desktop
        window.addEventListener('resize', function() {
            if (window.innerWidth > 768 && mobileMenu.classList.contains('active')) {
                closeMobileMenu();
            }
        });
    }
}

// Contact Form Functionality
function initializeContactForm() {
    const contactForm = document.getElementById('contact-form');

    if (contactForm) {
        // Add real-time validation only
        const formFields = contactForm.querySelectorAll('input, textarea');
        formFields.forEach(field => {
            field.addEventListener('blur', function() {
                validateField(this);
            });

            field.addEventListener('input', function() {
                // Remove error state when user starts typing
                this.classList.remove('form-error');
            });
        });
    }
}

// Form validation
function validateForm(data) {
    let isValid = true;

    // Name validation
    const nameField = document.getElementById('name');
    if (!data.name.trim()) {
        showFieldError(nameField, 'Name is required');
        isValid = false;
    }

    // Email validation
    const emailField = document.getElementById('email');
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(data.email)) {
        showFieldError(emailField, 'Please enter a valid email');
        isValid = false;
    }

    // Message validation
    const messageField = document.getElementById('message');
    if (!data.message.trim()) {
        showFieldError(messageField, 'Message is required');
        isValid = false;
    }

    return isValid;
}

// Validate individual field
function validateField(field) {
    const value = field.value.trim();

    switch(field.type) {
        case 'email':
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (value && !emailRegex.test(value)) {
                showFieldError(field, 'Please enter a valid email');
                return false;
            }
            break;
        default:
            if (field.hasAttribute('required') && !value) {
                showFieldError(field, 'This field is required');
                return false;
            }
    }

    // Remove error state if validation passes
    field.classList.remove('form-error');
    return true;
}

// Show field error
function showFieldError(field, message) {
    field.classList.add('form-error');

    // Create or update error message
    let errorElement = field.parentNode.querySelector('.error-message');
    if (!errorElement) {
        errorElement = document.createElement('div');
        errorElement.className = 'error-message text-red-400 text-sm mt-1';
        field.parentNode.appendChild(errorElement);
    }
    errorElement.textContent = message;

    // Remove error message after 3 seconds
    setTimeout(() => {
        if (errorElement && errorElement.parentNode) {
            errorElement.remove();
        }
    }, 3000);
}


// Show notification
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-lg text-white transform translate-x-full transition-transform duration-300 ${
        type === 'success' ? 'bg-green-500' :
        type === 'error' ? 'bg-red-500' : 'bg-blue-500'
    }`;
    notification.textContent = message;

    document.body.appendChild(notification);

    // Animate in
    setTimeout(() => {
        notification.style.transform = 'translateX(0)';
    }, 100);

    // Remove after 5 seconds
    setTimeout(() => {
        notification.style.transform = 'translateX(full)';
        setTimeout(() => {
            if (notification.parentNode) {
                notification.remove();
            }
        }, 300);
    }, 5000);
}

// Smooth Scrolling for Internal Links
function initializeSmoothScrolling() {
    const links = document.querySelectorAll('a[href^="#"]');

    links.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();

            const targetId = this.getAttribute('href').substring(1);
            const targetElement = document.getElementById(targetId);

            if (targetElement) {
                const offsetTop = targetElement.offsetTop - 100; // Account for fixed header

                window.scrollTo({
                    top: offsetTop,
                    behavior: 'smooth'
                });
            }
        });
    });
}

// Project Card Hover Effects
function initializeProjectHovers() {
    const projectCards = document.querySelectorAll('.group');

    projectCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            // Add hover effect class
            this.style.transform = 'translateY(-8px)';
            this.style.boxShadow = '0 25px 50px rgba(0, 0, 0, 0.3)';
        });

        card.addEventListener('mouseleave', function() {
            // Remove hover effect
            this.style.transform = '';
            this.style.boxShadow = '';
        });

        // Add click interaction for future modal functionality
        card.addEventListener('click', function() {
            const projectTitle = this.querySelector('h3');
            if (projectTitle) {
                console.log('Project clicked:', projectTitle.textContent);
                // Future: Open project modal
            }
        });
    });
}

// Initialize Page Animations
function initializeAnimations() {
    // Intersection Observer for scroll animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('loading');
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    // Observe elements for animation
    const animateElements = document.querySelectorAll('h1, h2, p, .group, form');
    animateElements.forEach(element => {
        element.style.opacity = '0';
        element.style.transform = 'translateY(20px)';
        element.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(element);
    });
}

// Utility Functions

// Debounce function for performance
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

// Throttle function for scroll events
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

// Handle window resize
window.addEventListener('resize', debounce(function() {
    // Recalculate any layout-dependent features
    console.log('Window resized');
}, 250));

// Header scroll update function
function updateHeaderScroll() {
    const scrollY = window.scrollY;
    const header = document.querySelector('header');

    if (header) {
        const root = document.documentElement;
        const isLightTheme = root.classList.contains('light-theme');

        if (scrollY > 100) {
            // Add blurred background with theme-appropriate color
            if (isLightTheme) {
                header.style.backgroundColor = 'rgba(255, 255, 255, 0.85)';
            } else {
                header.style.backgroundColor = 'rgba(10, 10, 10, 0.85)';
            }
            header.style.backdropFilter = 'blur(12px)';
            header.style.webkitBackdropFilter = 'blur(12px)';
        } else {
            header.style.backgroundColor = 'transparent';
            header.style.backdropFilter = 'blur(4px)';
            header.style.webkitBackdropFilter = 'blur(4px)';
        }
    }
}

// Handle scroll events
window.addEventListener('scroll', throttle(function() {
    updateHeaderScroll();
}, 100));

// Global keyboard navigation support
document.addEventListener('keydown', function(e) {
    // Tab navigation enhancement
    if (e.key === 'Tab') {
        document.body.classList.add('keyboard-navigation');
    }
});

// Remove keyboard navigation class on mouse use
document.addEventListener('mousedown', function() {
    document.body.classList.remove('keyboard-navigation');
});

// Project Modal Functionality (Database-driven modals handled in page-specific scripts)
function initializeProjectModals() {
    // This function is kept for compatibility but projects page now uses database-driven modals
    // Modal functionality is handled by page-specific inline scripts in projects.blade.php

    // Only initialize basic modal behaviors that aren't page-specific
    const modal = document.getElementById('projectModal');
    if (!modal) return;

    // Prevent modal content clicks from closing modal
    const modalContent = modal.querySelector('.modal-content');
    if (modalContent) {
        modalContent.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    }
}

// Performance monitoring
if ('performance' in window) {
    window.addEventListener('load', function() {
        setTimeout(function() {
            const perfData = performance.getEntriesByType('navigation')[0];
            console.log('Page load time:', perfData.loadEventEnd - perfData.fetchStart, 'ms');
        }, 0);
    });
}

// Error handling
window.addEventListener('error', function(e) {
    console.error('JavaScript error:', e.error);
    // Could send error reports to analytics service
});

// Service Worker registration (for future PWA features)
if ('serviceWorker' in navigator) {
    window.addEventListener('load', function() {
        // Register service worker when available
        // navigator.serviceWorker.register('/sw.js');
    });
}