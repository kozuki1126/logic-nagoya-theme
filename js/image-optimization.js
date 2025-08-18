/**
 * Logic Nagoya Theme - Image Optimization and Lazy Loading
 * Task 017: Image optimization functionality
 * 
 * Features:
 * - Lazy loading with Intersection Observer
 * - WebP detection and fallback
 * - Responsive image handling
 * - Smooth loading animations
 * - Performance optimizations
 */

(function() {
    'use strict';

    /**
     * Image Optimization Class
     */
    class LogicNagoyaImageOptimizer {
        constructor() {
            this.isInitialized = false;
            this.lazyImages = [];
            this.lazyImageObserver = null;
            this.webpSupported = false;
            
            this.settings = {
                rootMargin: '50px 0px',
                threshold: 0.01,
                fadeInDuration: 300,
                retryAttempts: 3,
                retryDelay: 1000
            };
            
            // Merge with localized settings if available
            if (typeof logic_nagoya_image_opt !== 'undefined') {
                this.settings.rootMargin = logic_nagoya_image_opt.lazy_loading_offset || this.settings.rootMargin;
                this.settings.fadeInDuration = parseInt(logic_nagoya_image_opt.fade_duration) || this.settings.fadeInDuration;
            }
            
            this.init();
        }

        /**
         * Initialize the image optimizer
         */
        async init() {
            if (this.isInitialized) {
                return;
            }

            try {
                // Wait for DOM to be ready
                if (document.readyState === 'loading') {
                    await new Promise(resolve => {
                        document.addEventListener('DOMContentLoaded', resolve);
                    });
                }

                // Check WebP support
                this.webpSupported = await this.checkWebPSupport();
                
                // Apply WebP class to document
                document.documentElement.classList.toggle('webp-supported', this.webpSupported);
                document.documentElement.classList.toggle('no-webp', !this.webpSupported);

                // Initialize lazy loading
                this.initializeLazyLoading();
                
                // Setup responsive images
                this.setupResponsiveImages();
                
                // Setup error handling
                this.setupImageErrorHandling();

                this.isInitialized = true;
                console.log('Logic Nagoya Image Optimizer initialized successfully');
                
            } catch (error) {
                console.error('Error initializing image optimizer:', error);
            }
        }

        /**
         * Check browser WebP support
         */
        checkWebPSupport() {
            return new Promise((resolve) => {
                const webP = new Image();
                webP.onload = webP.onerror = () => {
                    resolve(webP.height === 2);
                };
                webP.src = 'data:image/webp;base64,UklGRjoAAABXRUJQVlA4IC4AAACyAgCdASoCAAIALmk0mk0iIiIiIgBoSygABc6WWgAA/veff/0PP8bA//LwYAAA';
            });
        }

        /**
         * Initialize lazy loading with Intersection Observer
         */
        initializeLazyLoading() {
            if (!('IntersectionObserver' in window)) {
                // Fallback for older browsers
                this.fallbackLazyLoading();
                return;
            }

            this.lazyImageObserver = new IntersectionObserver(
                (entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            this.loadLazyImage(entry.target);
                            this.lazyImageObserver.unobserve(entry.target);
                        }
                    });
                },
                {
                    rootMargin: this.settings.rootMargin,
                    threshold: this.settings.threshold
                }
            );

            // Find all lazy images
            this.lazyImages = document.querySelectorAll('img[data-src], img[loading="lazy"]');
            
            this.lazyImages.forEach(img => {
                // Add lazy class for styling
                img.classList.add('lazy-image', 'loading');
                
                // Observe the image
                this.lazyImageObserver.observe(img);
            });

            console.log(`Initialized lazy loading for ${this.lazyImages.length} images`);
        }

        /**
         * Load a lazy image
         */
        loadLazyImage(img) {
            return new Promise((resolve, reject) => {
                const dataSrc = img.getAttribute('data-src');
                const dataSrcset = img.getAttribute('data-srcset');
                
                // Create new image for preloading
                const newImg = new Image();
                
                newImg.onload = () => {
                    // Apply the loaded image
                    if (dataSrc) {
                        img.src = dataSrc;
                    }
                    if (dataSrcset) {
                        img.srcset = dataSrcset;
                    }
                    
                    // Remove data attributes
                    img.removeAttribute('data-src');
                    img.removeAttribute('data-srcset');
                    
                    // Apply loaded state with animation
                    this.applyLoadedState(img);
                    
                    resolve();
                };
                
                newImg.onerror = () => {
                    this.handleImageError(img);
                    reject();
                };
                
                // Start loading
                newImg.src = dataSrc || img.src;
            });
        }

        /**
         * Apply loaded state with smooth animation
         */
        applyLoadedState(img) {
            img.classList.remove('loading');
            img.classList.add('loaded');
            
            // Animate fade in
            img.style.opacity = '0';
            img.style.transition = `opacity ${this.settings.fadeInDuration}ms ease-in-out`;
            
            // Force reflow
            img.offsetHeight;
            
            // Fade in
            img.style.opacity = '1';
            
            // Remove inline styles after animation
            setTimeout(() => {
                img.style.opacity = '';
                img.style.transition = '';
            }, this.settings.fadeInDuration);
        }

        /**
         * Setup responsive images with WebP support
         */
        setupResponsiveImages() {
            const pictureElements = document.querySelectorAll('picture');
            
            pictureElements.forEach(picture => {
                const sources = picture.querySelectorAll('source');
                const img = picture.querySelector('img');
                
                if (!img) return;
                
                sources.forEach(source => {
                    const srcset = source.getAttribute('srcset');
                    if (srcset && this.webpSupported) {
                        // WebP is supported, keep WebP sources
                        return;
                    } else if (srcset && !this.webpSupported && source.getAttribute('type') === 'image/webp') {
                        // WebP not supported, remove WebP sources
                        source.remove();
                    }
                });
            });
        }

        /**
         * Setup image error handling with retry mechanism
         */
        setupImageErrorHandling() {
            document.addEventListener('error', (event) => {
                if (event.target.tagName === 'IMG') {
                    this.handleImageError(event.target);
                }
            }, true);
        }

        /**
         * Handle image loading errors
         */
        handleImageError(img) {
            const retryCount = parseInt(img.getAttribute('data-retry-count') || '0');
            
            if (retryCount < this.settings.retryAttempts) {
                // Increment retry count
                img.setAttribute('data-retry-count', retryCount + 1);
                
                // Try to load fallback image
                const fallbackSrc = this.getFallbackImageSrc(img);
                if (fallbackSrc && fallbackSrc !== img.src) {
                    setTimeout(() => {
                        img.src = fallbackSrc;
                    }, this.settings.retryDelay * (retryCount + 1));
                } else {
                    // Show error state
                    this.showImageErrorState(img);
                }
            } else {
                this.showImageErrorState(img);
            }
        }

        /**
         * Get fallback image source
         */
        getFallbackImageSrc(img) {
            // Try to convert WebP to JPG/PNG
            const src = img.getAttribute('data-src') || img.src;
            if (src.includes('.webp')) {
                return src.replace(/\.webp$/i, '.jpg');
            }
            
            // Return original src or placeholder
            return src || this.getPlaceholderImage();
        }

        /**
         * Show image error state
         */
        showImageErrorState(img) {
            img.classList.add('image-error');
            img.classList.remove('loading');
            
            // Add error styling
            img.style.backgroundColor = '#f0f0f0';
            img.style.border = '1px solid #ddd';
            
            // Add alt text or placeholder
            if (!img.alt) {
                img.alt = 'Image failed to load';
            }
        }

        /**
         * Get placeholder image (data URI)
         */
        getPlaceholderImage() {
            return 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAwIiBoZWlnaHQ9IjMwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KICA8cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSIjZGRkZGRkIi8+CiAgPHRleHQgeD0iNTAlIiB5PSI1MCUiIGZvbnQtZmFtaWx5PSJBcmlhbCwgc2Fucy1zZXJpZiIgZm9udC1zaXplPSIxOCIgZmlsbD0iIzk5OTk5OSIgdGV4dC1hbmNob3I9Im1pZGRsZSIgZHk9Ii4zZW0iPkltYWdlPC90ZXh0Pgo8L3N2Zz4K';
        }

        /**
         * Fallback lazy loading for older browsers
         */
        fallbackLazyLoading() {
            let lazyImageTargets = document.querySelectorAll('img[data-src]');
            
            const lazyImageCallback = () => {
                lazyImageTargets.forEach(img => {
                    if (this.isInViewport(img)) {
                        this.loadLazyImage(img);
                    }
                });
            };
            
            // Initial check
            lazyImageCallback();
            
            // Listen to scroll and resize events
            window.addEventListener('scroll', this.throttle(lazyImageCallback, 100));
            window.addEventListener('resize', this.throttle(lazyImageCallback, 100));
        }

        /**
         * Check if element is in viewport
         */
        isInViewport(element) {
            const rect = element.getBoundingClientRect();
            return (
                rect.top < window.innerHeight &&
                rect.bottom > 0 &&
                rect.left < window.innerWidth &&
                rect.right > 0
            );
        }

        /**
         * Throttle function execution
         */
        throttle(func, limit) {
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

        /**
         * Reinitialize for dynamically loaded content
         */
        reinitialize() {
            if (this.lazyImageObserver) {
                this.lazyImageObserver.disconnect();
            }
            this.initializeLazyLoading();
        }

        /**
         * Destroy the image optimizer
         */
        destroy() {
            if (this.lazyImageObserver) {
                this.lazyImageObserver.disconnect();
                this.lazyImageObserver = null;
            }
            
            this.lazyImages = [];
            this.isInitialized = false;
        }
    }

    /**
     * Utility functions for image optimization
     */
    const ImageOptimizationUtils = {
        /**
         * Preload critical images
         */
        preloadCriticalImages() {
            const criticalImages = document.querySelectorAll('img.critical, .hero img, .above-fold img');
            
            criticalImages.forEach(img => {
                const link = document.createElement('link');
                link.rel = 'preload';
                link.as = 'image';
                link.href = img.src || img.getAttribute('data-src');
                document.head.appendChild(link);
            });
        },

        /**
         * Optimize image loading order
         */
        optimizeLoadingOrder() {
            // Remove loading="lazy" from above-the-fold images
            const aboveFoldImages = document.querySelectorAll('.hero img, .above-fold img');
            aboveFoldImages.forEach(img => {
                img.removeAttribute('loading');
                img.classList.add('priority-load');
            });
        },

        /**
         * Setup image performance monitoring
         */
        setupPerformanceMonitoring() {
            if ('PerformanceObserver' in window) {
                const observer = new PerformanceObserver((list) => {
                    for (const entry of list.getEntries()) {
                        if (entry.initiatorType === 'img') {
                            console.log('Image loaded:', entry.name, 'Duration:', entry.duration + 'ms');
                        }
                    }
                });
                observer.observe({ entryTypes: ['resource'] });
            }
        }
    };

    // Initialize when DOM is ready
    let imageOptimizer;
    
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => {
            imageOptimizer = new LogicNagoyaImageOptimizer();
            ImageOptimizationUtils.preloadCriticalImages();
            ImageOptimizationUtils.optimizeLoadingOrder();
            ImageOptimizationUtils.setupPerformanceMonitoring();
        });
    } else {
        imageOptimizer = new LogicNagoyaImageOptimizer();
        ImageOptimizationUtils.preloadCriticalImages();
        ImageOptimizationUtils.optimizeLoadingOrder();
        ImageOptimizationUtils.setupPerformanceMonitoring();
    }

    // Make image optimizer available globally for dynamic content
    window.LogicNagoyaImageOptimizer = imageOptimizer;

    // Auto-reinitialize when new content is added (for AJAX/dynamic content)
    const observer = new MutationObserver((mutations) => {
        let hasNewImages = false;
        mutations.forEach((mutation) => {
            if (mutation.type === 'childList') {
                mutation.addedNodes.forEach((node) => {
                    if (node.nodeType === 1) { // Element node
                        if (node.tagName === 'IMG' || node.querySelector('img')) {
                            hasNewImages = true;
                        }
                    }
                });
            }
        });
        
        if (hasNewImages && imageOptimizer) {
            setTimeout(() => {
                imageOptimizer.reinitialize();
            }, 100);
        }
    });

    observer.observe(document.body, {
        childList: true,
        subtree: true
    });

})();
