// Main JavaScript file for Library Website

// Initialize everything when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    initializeComponents();
});

function initializeComponents() {
    // Initialize mobile menu
    initializeMobileMenu();
    
    // Initialize search functionality
    initializeSearch();
    
    // Initialize sliders
    initializeSliders();
    
    // Initialize forms
    initializeForms();
    
    // Initialize tooltips and animations
    initializeAnimations();
}

// Mobile menu functionality
function initializeMobileMenu() {
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    
    if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
            
            // Change icon
            const icon = mobileMenuButton.querySelector('i');
            if (mobileMenu.classList.contains('hidden')) {
                icon.className = 'fas fa-bars text-xl';
            } else {
                icon.className = 'fas fa-times text-xl';
            }
        });
    }
}

// Search functionality
function initializeSearch() {
    const searchForm = document.querySelector('form[method="GET"]');
    const searchInputs = document.querySelectorAll('input[type="text"][name="search"]');
    
    // Add search suggestions
    searchInputs.forEach(input => {
        input.addEventListener('input', function() {
            const query = this.value.trim();
            if (query.length >= 2) {
                showSearchSuggestions(query, this);
            } else {
                hideSearchSuggestions();
            }
        });
    });
    
    // Handle search form submission
    if (searchForm) {
        searchForm.addEventListener('submit', function(e) {
            const searchInput = this.querySelector('input[name="search"]');
            if (searchInput && searchInput.value.trim() === '') {
                e.preventDefault();
                showNotification('Qidiruv uchun kamida bitta so\'z kiriting', 'warning');
            }
        });
    }
}

// Search suggestions
function showSearchSuggestions(query, input) {
    // Remove existing suggestions
    hideSearchSuggestions();
    
    // Create suggestions dropdown
    const suggestions = document.createElement('div');
    suggestions.className = 'absolute z-50 w-full bg-white border border-gray-300 rounded-md shadow-lg mt-1';
    suggestions.id = 'search-suggestions';
    
    // Make AJAX request for suggestions
    fetch(`/pages/search-suggestions.php?q=${encodeURIComponent(query)}`)
        .then(response => response.json())
        .then(data => {
            if (data.length > 0) {
                data.forEach(item => {
                    const suggestionItem = document.createElement('div');
                    suggestionItem.className = 'px-4 py-2 hover:bg-gray-100 cursor-pointer';
                    suggestionItem.innerHTML = `
                        <div class="font-medium">${item.title}</div>
                        <div class="text-sm text-gray-600">${item.type}</div>
                    `;
                    suggestionItem.addEventListener('click', function() {
                        input.value = item.title;
                        hideSearchSuggestions();
                    });
                    suggestions.appendChild(suggestionItem);
                });
                
                // Position suggestions
                const inputRect = input.getBoundingClientRect();
                const inputContainer = input.parentElement;
                inputContainer.style.position = 'relative';
                inputContainer.appendChild(suggestions);
            }
        })
        .catch(error => console.error('Search suggestions error:', error));
}

function hideSearchSuggestions() {
    const suggestions = document.getElementById('search-suggestions');
    if (suggestions) {
        suggestions.remove();
    }
}

// Slider initialization
function initializeSliders() {
    // Initialize Swiper for hero slider
    if (document.querySelector('.hero-slider')) {
        new Swiper('.hero-slider', {
            slidesPerView: 1,
            spaceBetween: 0,
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            effect: 'fade',
            fadeEffect: {
                crossFade: true
            }
        });
    }
    
    // Initialize book carousel
    if (document.querySelector('.books-slider')) {
        new Swiper('.books-slider', {
            slidesPerView: 1,
            spaceBetween: 20,
            loop: true,
            autoplay: {
                delay: 4000,
                disableOnInteraction: false,
            },
            breakpoints: {
                640: {
                    slidesPerView: 2,
                },
                768: {
                    slidesPerView: 3,
                },
                1024: {
                    slidesPerView: 4,
                },
            },
            navigation: {
                nextEl: '.books-next',
                prevEl: '.books-prev',
            },
        });
    }
}

// Form initialization
function initializeForms() {
    // Initialize form validation
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!validateForm(this)) {
                e.preventDefault();
            }
        });
    });
    
    // Initialize file upload previews
    const fileInputs = document.querySelectorAll('input[type="file"]');
    fileInputs.forEach(input => {
        input.addEventListener('change', function() {
            previewFile(this);
        });
    });
}

// Form validation
function validateForm(form) {
    let isValid = true;
    const requiredFields = form.querySelectorAll('[required]');
    
    requiredFields.forEach(field => {
        if (!field.value.trim()) {
            showFieldError(field, 'Bu maydon to\'ldirilishi shart');
            isValid = false;
        } else {
            hideFieldError(field);
        }
    });
    
    // Email validation
    const emailFields = form.querySelectorAll('input[type="email"]');
    emailFields.forEach(field => {
        if (field.value && !isValidEmail(field.value)) {
            showFieldError(field, 'Email format noto\'g\'ri');
            isValid = false;
        }
    });
    
    // Password validation
    const passwordFields = form.querySelectorAll('input[type="password"]');
    passwordFields.forEach(field => {
        if (field.value && field.value.length < 8) {
            showFieldError(field, 'Parol kamida 8 belgidan iborat bo\'lishi kerak');
            isValid = false;
        }
    });
    
    return isValid;
}

function showFieldError(field, message) {
    hideFieldError(field);
    
    const errorDiv = document.createElement('div');
    errorDiv.className = 'text-red-500 text-sm mt-1';
    errorDiv.textContent = message;
    errorDiv.id = `error-${field.name}`;
    
    field.parentNode.appendChild(errorDiv);
    field.classList.add('border-red-500');
}

function hideFieldError(field) {
    const errorDiv = document.getElementById(`error-${field.name}`);
    if (errorDiv) {
        errorDiv.remove();
    }
    field.classList.remove('border-red-500');
}

function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

// File preview
function previewFile(input) {
    const file = input.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            // Remove existing preview
            const existingPreview = input.parentNode.querySelector('.file-preview');
            if (existingPreview) {
                existingPreview.remove();
            }
            
            // Create new preview
            const preview = document.createElement('div');
            preview.className = 'file-preview mt-2';
            
            if (file.type.startsWith('image/')) {
                preview.innerHTML = `
                    <img src="${e.target.result}" alt="Preview" class="max-w-xs h-32 object-cover rounded">
                    <p class="text-sm text-gray-600 mt-1">${file.name}</p>
                `;
            } else {
                preview.innerHTML = `
                    <div class="flex items-center p-3 bg-gray-100 rounded">
                        <i class="fas fa-file mr-2"></i>
                        <span class="text-sm">${file.name}</span>
                    </div>
                `;
            }
            
            input.parentNode.appendChild(preview);
        };
        reader.readAsDataURL(file);
    }
}

// Animations and effects
function initializeAnimations() {
    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        });
    });
    
    // Fade in animation for cards
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-fade-in');
            }
        });
    }, observerOptions);
    
    document.querySelectorAll('.card-hover').forEach(card => {
        observer.observe(card);
    });
    
    // Parallax effect for hero section
    const heroSection = document.querySelector('.hero-gradient');
    if (heroSection) {
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            const parallax = heroSection.querySelector('.parallax-element');
            if (parallax) {
                parallax.style.transform = `translateY(${scrolled * 0.5}px)`;
            }
        });
    }
}

// Notification system
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg transition-all duration-300 transform translate-x-full`;
    
    // Set color based on type
    const colors = {
        success: 'bg-green-500 text-white',
        error: 'bg-red-500 text-white',
        warning: 'bg-yellow-500 text-white',
        info: 'bg-blue-500 text-white'
    };
    
    notification.className += ` ${colors[type] || colors.info}`;
    
    // Set icon based on type
    const icons = {
        success: 'fas fa-check-circle',
        error: 'fas fa-exclamation-circle',
        warning: 'fas fa-exclamation-triangle',
        info: 'fas fa-info-circle'
    };
    
    notification.innerHTML = `
        <div class="flex items-center">
            <i class="${icons[type] || icons.info} mr-2"></i>
            <span>${message}</span>
            <button class="ml-4 text-white hover:text-gray-200" onclick="this.parentElement.parentElement.remove()">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    // Show notification
    setTimeout(() => {
        notification.classList.remove('translate-x-full');
    }, 100);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        notification.classList.add('translate-x-full');
        setTimeout(() => {
            if (notification.parentNode) {
                notification.remove();
            }
        }, 300);
    }, 5000);
}

// Utility functions
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

// Loading indicator
function showLoading() {
    const loading = document.createElement('div');
    loading.id = 'loading-indicator';
    loading.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
    loading.innerHTML = `
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <div class="flex items-center">
                <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-blue-600 mr-3"></div>
                <span>Yuklanmoqda...</span>
            </div>
        </div>
    `;
    document.body.appendChild(loading);
}

function hideLoading() {
    const loading = document.getElementById('loading-indicator');
    if (loading) {
        loading.remove();
    }
}

// AJAX helper
function makeAjaxRequest(url, options = {}) {
    showLoading();
    
    const defaultOptions = {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    };
    
    return fetch(url, { ...defaultOptions, ...options })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .catch(error => {
            console.error('AJAX request failed:', error);
            showNotification('Xatolik yuz berdi. Iltimos qayta urinib ko\'ring.', 'error');
            throw error;
        })
        .finally(() => {
            hideLoading();
        });
}

// Book rating system
function rateBook(bookId, rating) {
    const data = {
        book_id: bookId,
        rating: rating
    };
    
    makeAjaxRequest('/api/rate-book.php', {
        method: 'POST',
        body: JSON.stringify(data)
    })
    .then(response => {
        if (response.success) {
            showNotification('Baho berildi!', 'success');
            updateRatingDisplay(bookId, response.average_rating);
        } else {
            showNotification(response.message || 'Xatolik yuz berdi', 'error');
        }
    });
}

function updateRatingDisplay(bookId, averageRating) {
    const ratingElement = document.querySelector(`[data-book-id="${bookId}"] .rating-display`);
    if (ratingElement) {
        ratingElement.innerHTML = generateStars(averageRating);
    }
}

function generateStars(rating) {
    let stars = '';
    for (let i = 1; i <= 5; i++) {
        if (i <= rating) {
            stars += '<i class="fas fa-star text-yellow-400"></i>';
        } else if (i - 0.5 <= rating) {
            stars += '<i class="fas fa-star-half-alt text-yellow-400"></i>';
        } else {
            stars += '<i class="far fa-star text-gray-300"></i>';
        }
    }
    return stars;
}

// Export functions for global use
window.showNotification = showNotification;
window.rateBook = rateBook;
window.makeAjaxRequest = makeAjaxRequest;