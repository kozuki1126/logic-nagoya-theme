/**
 * Logic Nagoya Theme - Accessibility JavaScript
 * Task 022: Accessibility audit and improvements
 * 
 * Features:
 * - Keyboard navigation management
 * - Focus management and focus trapping
 * - ARIA attributes dynamic updates
 * - Screen reader announcements
 * - Mobile menu accessibility
 * - Skip link functionality
 */

(function() {
    'use strict';

    /**
     * Accessibility Manager Class
     */
    class LogicNagoyaAccessibility {
        constructor() {
            this.isInitialized = false;
            this.focusableElements = 'a[href], button, textarea, input[type="text"], input[type="radio"], input[type="checkbox"], input[type="submit"], select, [tabindex]:not([tabindex="-1"])';
            this.lastFocusedElement = null;
            this.announcer = null;
            
            this.init();
        }

        /**
         * Initialize accessibility features
         */
        init() {
            if (this.isInitialized) {
                return;
            }

            try {
                // Wait for DOM to be ready
                if (document.readyState === 'loading') {
                    document.addEventListener('DOMContentLoaded', () => {
                        this.setupAccessibilityFeatures();
                    });
                } else {
                    this.setupAccessibilityFeatures();
                }

                this.isInitialized = true;
                console.log('Logic Nagoya Accessibility initialized successfully');
                
            } catch (error) {
                console.error('Error initializing accessibility features:', error);
            }
        }

        /**
         * Setup all accessibility features
         */
        setupAccessibilityFeatures() {
            this.createAnnouncer();
            this.setupKeyboardNavigation();
            this.setupMobileMenuAccessibility();
            this.setupSkipLinks();
            this.setupFocusManagement();
            this.setupARIAUpdates();
            this.setupFormAccessibility();
            this.setupModalAccessibility();
            this.setupTabAccessibility();
            this.setupAccordionAccessibility();
        }

        /**
         * Create live region for screen reader announcements
         */
        createAnnouncer() {
            this.announcer = document.createElement('div');
            this.announcer.setAttribute('aria-live', 'polite');
            this.announcer.setAttribute('aria-atomic', 'true');
            this.announcer.setAttribute('class', 'screen-reader-text live-region');
            this.announcer.setAttribute('id', 'accessibility-announcer');
            document.body.appendChild(this.announcer);
        }

        /**
         * Announce message to screen readers
         */
        announce(message, priority = 'polite') {
            if (!this.announcer) {
                this.createAnnouncer();
            }

            this.announcer.setAttribute('aria-live', priority);
            this.announcer.textContent = '';
            
            // Small delay to ensure the change is detected
            setTimeout(() => {
                this.announcer.textContent = message;
            }, 100);

            // Clear after announcement
            setTimeout(() => {
                this.announcer.textContent = '';
            }, 1000);
        }

        /**
         * Setup keyboard navigation
         */
        setupKeyboardNavigation() {
            // Global keyboard event handler
            document.addEventListener('keydown', (event) => {
                switch (event.key) {
                    case 'Escape':
                        this.handleEscapeKey(event);
                        break;
                    case 'Tab':
                        this.handleTabKey(event);
                        break;
                    case 'Enter':
                    case ' ':
                        this.handleActivationKeys(event);
                        break;
                    case 'ArrowUp':
                    case 'ArrowDown':
                    case 'ArrowLeft':
                    case 'ArrowRight':
                        this.handleArrowKeys(event);
                        break;
                }
            });

            // Add keyboard event indicators
            document.addEventListener('keydown', () => {
                document.body.classList.add('keyboard-navigation');
            });

            document.addEventListener('mousedown', () => {
                document.body.classList.remove('keyboard-navigation');
            });
        }

        /**
         * Handle Escape key
         */
        handleEscapeKey(event) {
            // Close mobile menu
            const mobileMenu = document.querySelector('.main-navigation ul');
            const menuToggle = document.querySelector('.menu-toggle');
            
            if (mobileMenu && menuToggle && mobileMenu.getAttribute('aria-hidden') === 'false') {
                this.closeMobileMenu();
                menuToggle.focus();
                event.preventDefault();
            }

            // Close modals
            const openModal = document.querySelector('.modal[aria-hidden="false"]');
            if (openModal) {
                this.closeModal(openModal);
                event.preventDefault();
            }

            // Close dropdowns or other open elements
            const openDropdowns = document.querySelectorAll('[aria-expanded="true"]');
            openDropdowns.forEach(dropdown => {
                if (dropdown !== menuToggle) {
                    dropdown.setAttribute('aria-expanded', 'false');
                    const targetId = dropdown.getAttribute('aria-controls');
                    if (targetId) {
                        const target = document.getElementById(targetId);
                        if (target) {
                            target.setAttribute('aria-hidden', 'true');
                        }
                    }
                }
            });
        }

        /**
         * Handle Tab key for focus management
         */
        handleTabKey(event) {
            // Handle focus trapping in modals
            const openModal = document.querySelector('.modal[aria-hidden="false"]');
            if (openModal) {
                this.trapFocus(event, openModal);
            }
        }

        /**
         * Handle activation keys (Enter, Space)
         */
        handleActivationKeys(event) {
            const target = event.target;
            
            // Handle custom interactive elements
            if (target.hasAttribute('role')) {
                const role = target.getAttribute('role');
                
                switch (role) {
                    case 'button':
                        if (target.tagName !== 'BUTTON') {
                            target.click();
                            event.preventDefault();
                        }
                        break;
                    case 'tab':
                        this.activateTab(target);
                        event.preventDefault();
                        break;
                    case 'menuitem':
                        target.click();
                        event.preventDefault();
                        break;
                }
            }

            // Handle FAQ questions
            if (target.classList.contains('faq-question')) {
                target.click();
                event.preventDefault();
            }
        }

        /**
         * Handle arrow keys for navigation
         */
        handleArrowKeys(event) {
            const target = event.target;
            const parent = target.closest('[role="tablist"], [role="menu"], [role="menubar"]');
            
            if (parent) {
                const items = Array.from(parent.querySelectorAll('[role="tab"], [role="menuitem"]'));
                const currentIndex = items.indexOf(target);
                let nextIndex;

                switch (event.key) {
                    case 'ArrowRight':
                    case 'ArrowDown':
                        nextIndex = (currentIndex + 1) % items.length;
                        break;
                    case 'ArrowLeft':
                    case 'ArrowUp':
                        nextIndex = (currentIndex - 1 + items.length) % items.length;
                        break;
                }

                if (nextIndex !== undefined) {
                    items[nextIndex].focus();
                    event.preventDefault();
                }
            }
        }

        /**
         * Setup mobile menu accessibility
         */
        setupMobileMenuAccessibility() {
            const menuToggle = document.querySelector('.menu-toggle');
            const mobileMenu = document.querySelector('.main-navigation ul');
            
            if (!menuToggle || !mobileMenu) {
                return;
            }

            // Set initial ARIA attributes
            menuToggle.setAttribute('aria-expanded', 'false');
            menuToggle.setAttribute('aria-controls', 'primary-menu');
            mobileMenu.setAttribute('aria-hidden', 'true');
            mobileMenu.setAttribute('id', 'primary-menu');

            // Handle menu toggle
            menuToggle.addEventListener('click', (event) => {
                event.preventDefault();
                this.toggleMobileMenu();
            });

            // Handle menu item clicks
            const menuItems = mobileMenu.querySelectorAll('a');
            menuItems.forEach(item => {
                item.addEventListener('click', () => {
                    // Close menu when item is selected
                    this.closeMobileMenu();
                    this.announce(`Navigating to ${item.textContent}`);
                });
            });
        }

        /**
         * Toggle mobile menu
         */
        toggleMobileMenu() {
            const menuToggle = document.querySelector('.menu-toggle');
            const mobileMenu = document.querySelector('.main-navigation ul');
            
            if (!menuToggle || !mobileMenu) {
                return;
            }

            const isExpanded = menuToggle.getAttribute('aria-expanded') === 'true';
            
            if (isExpanded) {
                this.closeMobileMenu();
            } else {
                this.openMobileMenu();
            }
        }

        /**
         * Open mobile menu
         */
        openMobileMenu() {
            const menuToggle = document.querySelector('.menu-toggle');
            const mobileMenu = document.querySelector('.main-navigation ul');
            
            menuToggle.setAttribute('aria-expanded', 'true');
            mobileMenu.setAttribute('aria-hidden', 'false');
            
            // Focus first menu item
            const firstMenuItem = mobileMenu.querySelector('a');
            if (firstMenuItem) {
                firstMenuItem.focus();
            }

            this.announce('Menu opened');
        }

        /**
         * Close mobile menu
         */
        closeMobileMenu() {
            const menuToggle = document.querySelector('.menu-toggle');
            const mobileMenu = document.querySelector('.main-navigation ul');
            
            menuToggle.setAttribute('aria-expanded', 'false');
            mobileMenu.setAttribute('aria-hidden', 'true');
            
            this.announce('Menu closed');
        }

        /**
         * Setup skip links
         */
        setupSkipLinks() {
            const skipLinks = document.querySelectorAll('.skip-link');
            
            skipLinks.forEach(link => {
                link.addEventListener('click', (event) => {
                    event.preventDefault();
                    const targetId = link.getAttribute('href').substring(1);
                    const target = document.getElementById(targetId);
                    
                    if (target) {
                        target.focus();
                        target.scrollIntoView({ behavior: 'smooth' });
                        this.announce(`Skipped to ${target.textContent || targetId}`);
                    }
                });
            });
        }

        /**
         * Setup focus management
         */
        setupFocusManagement() {
            // Store last focused element before modal opens
            document.addEventListener('focusin', (event) => {
                if (!event.target.closest('.modal')) {
                    this.lastFocusedElement = event.target;
                }
            });

            // Handle focus indicators
            document.addEventListener('focusin', (event) => {
                event.target.classList.add('has-focus');
            });

            document.addEventListener('focusout', (event) => {
                event.target.classList.remove('has-focus');
            });
        }

        /**
         * Setup dynamic ARIA updates
         */
        setupARIAUpdates() {
            // Update page title announcements
            const observer = new MutationObserver((mutations) => {
                mutations.forEach((mutation) => {
                    if (mutation.type === 'childList' && mutation.target.tagName === 'TITLE') {
                        this.announce(`Page changed to ${document.title}`);
                    }
                });
            });

            const titleElement = document.querySelector('title');
            if (titleElement) {
                observer.observe(titleElement, { childList: true });
            }

            // Update dynamic content announcements
            const liveRegions = document.querySelectorAll('[aria-live]');
            liveRegions.forEach(region => {
                const regionObserver = new MutationObserver((mutations) => {
                    mutations.forEach((mutation) => {
                        if (mutation.type === 'childList' || mutation.type === 'characterData') {
                            const announcement = region.textContent.trim();
                            if (announcement && announcement !== mutation.oldValue) {
                                this.announce(announcement);
                            }
                        }
                    });
                });

                regionObserver.observe(region, { 
                    childList: true, 
                    characterData: true, 
                    subtree: true 
                });
            });
        }

        /**
         * Setup form accessibility
         */
        setupFormAccessibility() {
            const forms = document.querySelectorAll('form');
            
            forms.forEach(form => {
                // Add form validation announcements
                form.addEventListener('submit', (event) => {
                    const invalidFields = form.querySelectorAll('input:invalid, textarea:invalid, select:invalid');
                    
                    if (invalidFields.length > 0) {
                        event.preventDefault();
                        this.announce(`Form has ${invalidFields.length} errors. Please correct them and try again.`);
                        invalidFields[0].focus();
                    }
                });

                // Handle input validation
                const inputs = form.querySelectorAll('input, textarea, select');
                inputs.forEach(input => {
                    input.addEventListener('invalid', () => {
                        input.setAttribute('aria-invalid', 'true');
                        this.announce(`Error in ${input.name || 'field'}: ${input.validationMessage}`);
                    });

                    input.addEventListener('input', () => {
                        if (input.checkValidity()) {
                            input.setAttribute('aria-invalid', 'false');
                        }
                    });
                });
            });
        }

        /**
         * Setup modal accessibility
         */
        setupModalAccessibility() {
            const modalTriggers = document.querySelectorAll('[data-modal-target]');
            
            modalTriggers.forEach(trigger => {
                trigger.addEventListener('click', (event) => {
                    event.preventDefault();
                    const modalId = trigger.getAttribute('data-modal-target');
                    const modal = document.getElementById(modalId);
                    
                    if (modal) {
                        this.openModal(modal);
                    }
                });
            });

            // Setup modal close buttons
            const modalCloseButtons = document.querySelectorAll('.modal-close');
            modalCloseButtons.forEach(button => {
                button.addEventListener('click', (event) => {
                    event.preventDefault();
                    const modal = button.closest('.modal');
                    if (modal) {
                        this.closeModal(modal);
                    }
                });
            });
        }

        /**
         * Open modal
         */
        openModal(modal) {
            modal.setAttribute('aria-hidden', 'false');
            modal.style.display = 'block';
            
            // Focus first focusable element in modal
            const focusableElements = modal.querySelectorAll(this.focusableElements);
            if (focusableElements.length > 0) {
                focusableElements[0].focus();
            }

            this.announce('Dialog opened');
        }

        /**
         * Close modal
         */
        closeModal(modal) {
            modal.setAttribute('aria-hidden', 'true');
            modal.style.display = 'none';
            
            // Return focus to last focused element
            if (this.lastFocusedElement) {
                this.lastFocusedElement.focus();
            }

            this.announce('Dialog closed');
        }

        /**
         * Trap focus within element
         */
        trapFocus(event, container) {
            const focusableElements = container.querySelectorAll(this.focusableElements);
            const firstElement = focusableElements[0];
            const lastElement = focusableElements[focusableElements.length - 1];

            if (event.shiftKey) {
                if (document.activeElement === firstElement) {
                    lastElement.focus();
                    event.preventDefault();
                }
            } else {
                if (document.activeElement === lastElement) {
                    firstElement.focus();
                    event.preventDefault();
                }
            }
        }

        /**
         * Setup tab accessibility
         */
        setupTabAccessibility() {
            const tabLists = document.querySelectorAll('[role="tablist"]');
            
            tabLists.forEach(tabList => {
                const tabs = tabList.querySelectorAll('[role="tab"]');
                const tabPanels = document.querySelectorAll('[role="tabpanel"]');

                tabs.forEach((tab, index) => {
                    tab.addEventListener('click', (event) => {
                        event.preventDefault();
                        this.activateTab(tab);
                    });

                    // Set initial states
                    if (index === 0) {
                        tab.setAttribute('aria-selected', 'true');
                        tab.setAttribute('tabindex', '0');
                    } else {
                        tab.setAttribute('aria-selected', 'false');
                        tab.setAttribute('tabindex', '-1');
                    }
                });

                // Set initial panel states
                tabPanels.forEach((panel, index) => {
                    panel.setAttribute('aria-hidden', index !== 0 ? 'true' : 'false');
                });
            });
        }

        /**
         * Activate tab
         */
        activateTab(activeTab) {
            const tabList = activeTab.closest('[role="tablist"]');
            const tabs = tabList.querySelectorAll('[role="tab"]');
            const activePanel = document.getElementById(activeTab.getAttribute('aria-controls'));

            // Deactivate all tabs
            tabs.forEach(tab => {
                tab.setAttribute('aria-selected', 'false');
                tab.setAttribute('tabindex', '-1');
                
                const panelId = tab.getAttribute('aria-controls');
                if (panelId) {
                    const panel = document.getElementById(panelId);
                    if (panel) {
                        panel.setAttribute('aria-hidden', 'true');
                    }
                }
            });

            // Activate selected tab
            activeTab.setAttribute('aria-selected', 'true');
            activeTab.setAttribute('tabindex', '0');
            
            if (activePanel) {
                activePanel.setAttribute('aria-hidden', 'false');
            }

            this.announce(`Tab ${activeTab.textContent} selected`);
        }

        /**
         * Setup accordion accessibility
         */
        setupAccordionAccessibility() {
            const accordionHeaders = document.querySelectorAll('.faq-question, .accordion-header');
            
            accordionHeaders.forEach(header => {
                // Set ARIA attributes
                header.setAttribute('role', 'button');
                header.setAttribute('aria-expanded', 'false');
                header.setAttribute('tabindex', '0');
                
                const contentId = header.getAttribute('data-target') || 
                                 header.nextElementSibling?.id || 
                                 `accordion-content-${Math.random().toString(36).substr(2, 9)}`;
                
                header.setAttribute('aria-controls', contentId);
                
                if (header.nextElementSibling) {
                    header.nextElementSibling.setAttribute('id', contentId);
                    header.nextElementSibling.setAttribute('aria-hidden', 'true');
                }

                header.addEventListener('click', () => {
                    this.toggleAccordion(header);
                });
            });
        }

        /**
         * Toggle accordion
         */
        toggleAccordion(header) {
            const isExpanded = header.getAttribute('aria-expanded') === 'true';
            const contentId = header.getAttribute('aria-controls');
            const content = document.getElementById(contentId);

            header.setAttribute('aria-expanded', !isExpanded);
            
            if (content) {
                content.setAttribute('aria-hidden', isExpanded);
            }

            this.announce(`${header.textContent} ${isExpanded ? 'collapsed' : 'expanded'}`);
        }

        /**
         * Check if element is visible
         */
        isElementVisible(element) {
            return !!(element.offsetWidth || element.offsetHeight || element.getClientRects().length);
        }

        /**
         * Get all focusable elements
         */
        getFocusableElements(container = document) {
            return Array.from(container.querySelectorAll(this.focusableElements))
                .filter(el => this.isElementVisible(el) && !el.disabled);
        }
    }

    // Initialize accessibility features
    let accessibilityManager;
    
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => {
            accessibilityManager = new LogicNagoyaAccessibility();
        });
    } else {
        accessibilityManager = new LogicNagoyaAccessibility();
    }

    // Make accessibility manager available globally
    window.LogicNagoyaAccessibility = accessibilityManager;

})();
