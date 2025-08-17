/**
 * FAQ JavaScript functionality for Logic Nagoya Theme
 *
 * @package Logic_Nagoya
 */

jQuery(document).ready(function($) {
    'use strict';

    // Initialize FAQ functionality
    initFAQ();

    /**
     * Initialize FAQ accordion functionality
     */
    function initFAQ() {
        const faqItems = $('.faq-item');
        
        if (faqItems.length === 0) {
            return;
        }

        // Add click event to FAQ questions
        $('.faq-question').on('click', function() {
            const faqItem = $(this).closest('.faq-item');
            const faqAnswer = faqItem.find('.faq-answer');
            const isActive = faqItem.hasClass('active');

            // Close all other FAQ items (accordion behavior)
            $('.faq-item').not(faqItem).removeClass('active').find('.faq-answer').slideUp(300);

            // Toggle current item
            if (isActive) {
                faqItem.removeClass('active');
                faqAnswer.slideUp(300);
            } else {
                faqItem.addClass('active');
                faqAnswer.slideDown(300);
            }

            // Add animation class if Animate.css is available
            if (typeof window.WOW !== 'undefined' || $('link[href*="animate"]').length > 0) {
                faqItem.addClass('animate__animated animate__pulse');
                
                setTimeout(function() {
                    faqItem.removeClass('animate__animated animate__pulse');
                }, 600);
            }
        });

        // Keyboard accessibility
        $('.faq-question').on('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                $(this).click();
            }
        });

        // Add ARIA attributes for accessibility
        setupAccessibility();

        // Auto-open first FAQ item if specified
        if ($('.faq-items').data('auto-open') === true) {
            $('.faq-item:first-child .faq-question').click();
        }
    }

    /**
     * Setup accessibility attributes for FAQ items
     */
    function setupAccessibility() {
        $('.faq-question').each(function(index) {
            const questionId = 'faq-question-' + index;
            const answerId = 'faq-answer-' + index;
            const faqItem = $(this).closest('.faq-item');
            const faqAnswer = faqItem.find('.faq-answer');

            // Add IDs and ARIA attributes
            $(this).attr({
                'id': questionId,
                'role': 'button',
                'aria-expanded': 'false',
                'aria-controls': answerId,
                'tabindex': '0'
            });

            faqAnswer.attr({
                'id': answerId,
                'role': 'region',
                'aria-labelledby': questionId
            });

            // Update ARIA attributes when toggled
            faqItem.on('faq:toggle', function() {
                const isActive = faqItem.hasClass('active');
                $(this).find('.faq-question').attr('aria-expanded', isActive.toString());
            });
        });

        // Trigger accessibility update when FAQ items are toggled
        $('.faq-item').on('DOMSubtreeModified propertychange', function() {
            if ($(this).hasClass('active')) {
                $(this).trigger('faq:toggle');
            }
        });
    }

    /**
     * Search functionality for FAQ items (if search box exists)
     */
    function initFAQSearch() {
        const searchBox = $('.faq-search');
        
        if (searchBox.length === 0) {
            return;
        }

        searchBox.on('input', function() {
            const searchTerm = $(this).val().toLowerCase();
            
            $('.faq-item').each(function() {
                const question = $(this).find('.faq-question').text().toLowerCase();
                const answer = $(this).find('.faq-answer').text().toLowerCase();
                
                if (question.includes(searchTerm) || answer.includes(searchTerm)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });

            // Show "no results" message if no items are visible
            const visibleItems = $('.faq-item:visible').length;
            const noResultsMessage = $('.faq-no-results');
            
            if (visibleItems === 0 && searchTerm.length > 0) {
                if (noResultsMessage.length === 0) {
                    $('.faq-items').after('<div class="faq-no-results"><p>検索結果が見つかりませんでした。</p></div>');
                }
            } else {
                noResultsMessage.remove();
            }
        });
    }

    // Initialize search if search box exists
    initFAQSearch();

    /**
     * Smooth scroll to FAQ section if hash is present
     */
    function handleFAQHash() {
        const hash = window.location.hash;
        
        if (hash && hash.includes('faq')) {
            const target = $(hash);
            
            if (target.length > 0) {
                $('html, body').animate({
                    scrollTop: target.offset().top - 100
                }, 800);
                
                // Auto-open FAQ item if it's a specific question
                if (target.hasClass('faq-item')) {
                    target.find('.faq-question').click();
                }
            }
        }
    }

    // Handle FAQ hash on page load
    handleFAQHash();

    // Handle FAQ hash on hash change
    $(window).on('hashchange', handleFAQHash);

    /**
     * FAQ Analytics tracking (if Google Analytics is available)
     */
    function trackFAQInteraction(action, question) {
        if (typeof gtag !== 'undefined') {
            gtag('event', 'FAQ_' + action, {
                'event_category': 'FAQ',
                'event_label': question,
                'value': 1
            });
        } else if (typeof ga !== 'undefined') {
            ga('send', 'event', 'FAQ', action, question);
        }
    }

    // Track FAQ clicks
    $('.faq-question').on('click', function() {
        const questionText = $(this).text().trim();
        const isOpening = !$(this).closest('.faq-item').hasClass('active');
        
        trackFAQInteraction(isOpening ? 'open' : 'close', questionText);
    });

    /**
     * Print styles for FAQ
     */
    function addPrintStyles() {
        const printStyles = `
            <style media="print">
                .faq-item { page-break-inside: avoid; }
                .faq-answer { max-height: none !important; padding: 1rem !important; }
                .faq-question::after { display: none !important; }
            </style>
        `;
        $('head').append(printStyles);
    }

    // Add print styles
    addPrintStyles();
});

/**
 * Vanilla JavaScript fallback for environments without jQuery
 */
if (typeof jQuery === 'undefined') {
    document.addEventListener('DOMContentLoaded', function() {
        const faqQuestions = document.querySelectorAll('.faq-question');
        
        faqQuestions.forEach(function(question) {
            question.addEventListener('click', function() {
                const faqItem = question.closest('.faq-item');
                const faqAnswer = faqItem.querySelector('.faq-answer');
                const isActive = faqItem.classList.contains('active');

                // Close all other FAQ items
                document.querySelectorAll('.faq-item').forEach(function(item) {
                    if (item !== faqItem) {
                        item.classList.remove('active');
                    }
                });

                // Toggle current item
                if (isActive) {
                    faqItem.classList.remove('active');
                } else {
                    faqItem.classList.add('active');
                }
            });
        });
    });
}
