/**
 * TBMX Mega Menu - Front-end interaction (Enhanced)
 *
 * Vanilla JS (< 5 KB target) with advanced features:
 * - Hover-intent with visual progress indicator
 * - Click/tap to open
 * - Keyboard navigation (Enter, Space, Esc, Tab, Arrows)
 * - ARIA state management (aria-expanded, aria-hidden)
 * - Mobile accordion with touch support
 * - Scroll lock when panel is open
 * - Staggered animations for columns
 * - Lazy loading for images
 * - Intersection Observer for entrance animations
 * - Custom events for external integration
 * - Focus trap (optional)
 * - Respects prefers-reduced-motion
 *
 * @package TBMX_MegaMenu
 * @version 0.2.0
 */

(function() {
    'use strict';

    /**
     * Configuration (injected from PHP via wp_localize_script)
     */
    const CONFIG = Object.assign({
        hoverIn: 120,
        hoverOut: 200,
        breakpoint: 980,
        scrollLock: true,
        focusTrap: false,
        staggerDelay: 50,
        lazyLoadImages: true
    }, window.tbmxConfig || {});

    const REDUCED_MOTION = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    /**
     * State management
     */
    let activePanel = null;
    let hoverInTimer = null;
    let hoverOutTimer = null;
    let scrollPosition = 0;

    /**
     * Initialize mega menu
     */
    function init() {
        const triggers = document.querySelectorAll('[data-tbmx-toggle="mega"]');

        if (!triggers.length) return;

        // Dispatch custom init event
        dispatchCustomEvent('tbmx:init', { triggers: triggers.length });

        triggers.forEach(function(trigger) {
            const li = trigger.closest('.tbmx-mega-item');
            if (!li) return;

            const panel = li.querySelector('.tbmx-panel');
            if (!panel) return;

            // Add progress indicator for hover-intent
            if (!isMobile() && !REDUCED_MOTION) {
                addProgressIndicator(li, trigger);
            }

            // Desktop: hover intent
            li.addEventListener('mouseenter', function() {
                if (isMobile()) return;
                clearTimeout(hoverOutTimer);
                showProgressIndicator(li);
                hoverInTimer = setTimeout(function() {
                    openPanel(trigger, panel);
                }, CONFIG.hoverIn);
            });

            li.addEventListener('mouseleave', function() {
                if (isMobile()) return;
                clearTimeout(hoverInTimer);
                hideProgressIndicator(li);
                hoverOutTimer = setTimeout(function() {
                    closePanel(trigger, panel);
                }, CONFIG.hoverOut);
            });

            // Touch support for mobile
            li.addEventListener('touchstart', function(e) {
                if (!isMobile()) return;
                // Prevent double-tap zoom
                e.preventDefault();
            }, { passive: false });

            // Click/tap (works on both desktop and mobile)
            trigger.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();

                if (activePanel === panel) {
                    closePanel(trigger, panel);
                } else {
                    openPanel(trigger, panel);
                }
            });

            // Keyboard navigation
            trigger.addEventListener('keydown', function(e) {
                handleKeyboard(e, trigger, panel);
            });

            // Panel keyboard navigation
            panel.addEventListener('keydown', function(e) {
                handlePanelKeyboard(e, trigger, panel);
            });

            // Lazy load images when panel opens
            if (CONFIG.lazyLoadImages) {
                panel.addEventListener('tbmx:open', function() {
                    lazyLoadImages(panel);
                });
            }
        });

        // Close on click outside
        document.addEventListener('click', function(e) {
            if (activePanel && !activePanel.contains(e.target)) {
                const trigger = document.querySelector('[aria-controls="' + activePanel.id + '"]');
                if (trigger) {
                    closePanel(trigger, activePanel);
                }
            }
        });

        // Close on Escape (global)
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && activePanel) {
                const trigger = document.querySelector('[aria-controls="' + activePanel.id + '"]');
                if (trigger) {
                    closePanel(trigger, activePanel);
                    trigger.focus();
                }
            }
        });

        // Close on window resize (if switching from mobile to desktop)
        let resizeTimer;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(function() {
                if (!isMobile() && activePanel) {
                    const trigger = document.querySelector('[aria-controls="' + activePanel.id + '"]');
                    if (trigger) {
                        closePanel(trigger, activePanel);
                    }
                }
            }, 250);
        });

        // Intersection Observer for entrance animations
        if (!REDUCED_MOTION && 'IntersectionObserver' in window) {
            setupIntersectionObserver();
        }
    }

    /**
     * Add progress indicator for hover-intent
     */
    function addProgressIndicator(li, trigger) {
        const indicator = document.createElement('span');
        indicator.className = 'tbmx-hover-indicator';
        indicator.setAttribute('aria-hidden', 'true');
        trigger.parentNode.insertBefore(indicator, trigger.nextSibling);
    }

    /**
     * Show progress indicator
     */
    function showProgressIndicator(li) {
        const indicator = li.querySelector('.tbmx-hover-indicator');
        if (indicator) {
            indicator.classList.add('tbmx-hover-indicator--active');
        }
    }

    /**
     * Hide progress indicator
     */
    function hideProgressIndicator(li) {
        const indicator = li.querySelector('.tbmx-hover-indicator');
        if (indicator) {
            indicator.classList.remove('tbmx-hover-indicator--active');
        }
    }

    /**
     * Open panel
     */
    function openPanel(trigger, panel) {
        // Close any other open panel first
        if (activePanel && activePanel !== panel) {
            const otherTrigger = document.querySelector('[aria-controls="' + activePanel.id + '"]');
            if (otherTrigger) {
                closePanel(otherTrigger, activePanel);
            }
        }

        // Scroll lock
        if (CONFIG.scrollLock && isMobile()) {
            scrollPosition = window.pageYOffset || document.documentElement.scrollTop;
            document.body.style.position = 'fixed';
            document.body.style.top = `-${scrollPosition}px`;
            document.body.style.width = '100%';
        }

        // Open this panel
        trigger.setAttribute('aria-expanded', 'true');
        panel.setAttribute('aria-hidden', 'false');
        panel.removeAttribute('hidden');

        // Staggered animation for columns
        if (!REDUCED_MOTION) {
            staggerColumns(panel);
        }

        activePanel = panel;

        // Dispatch custom event
        dispatchCustomEvent('tbmx:open', { panel: panel, trigger: trigger });

        // Panel open event
        panel.dispatchEvent(new CustomEvent('tbmx:open'));

        // Focus first focusable element in panel (for keyboard users)
        if (!REDUCED_MOTION) {
            setTimeout(function() {
                const firstFocusable = panel.querySelector('a, button, [tabindex]:not([tabindex="-1"])');
                if (firstFocusable) {
                    firstFocusable.focus();
                }
            }, 100);
        }
    }

    /**
     * Close panel
     */
    function closePanel(trigger, panel) {
        trigger.setAttribute('aria-expanded', 'false');
        panel.setAttribute('aria-hidden', 'true');

        // Scroll unlock
        if (CONFIG.scrollLock && isMobile()) {
            document.body.style.position = '';
            document.body.style.top = '';
            document.body.style.width = '';
            window.scrollTo(0, scrollPosition);
        }

        // Wait for animation to complete before hiding
        const delay = REDUCED_MOTION ? 0 : 220;
        setTimeout(function() {
            if (panel.getAttribute('aria-hidden') === 'true') {
                panel.setAttribute('hidden', '');
            }
        }, delay);

        if (activePanel === panel) {
            activePanel = null;
        }

        // Dispatch custom event
        dispatchCustomEvent('tbmx:close', { panel: panel, trigger: trigger });
    }

    /**
     * Close all panels
     */
    function closeAllPanels() {
        const triggers = document.querySelectorAll('[data-tbmx-toggle="mega"]');
        triggers.forEach(function(trigger) {
            const panelId = trigger.getAttribute('aria-controls');
            const panel = document.getElementById(panelId);
            if (panel) {
                closePanel(trigger, panel);
            }
        });
    }

    /**
     * Handle keyboard navigation on trigger
     */
    function handleKeyboard(e, trigger, panel) {
        switch (e.key) {
            case 'Enter':
            case ' ':
                e.preventDefault();
                if (activePanel === panel) {
                    closePanel(trigger, panel);
                } else {
                    openPanel(trigger, panel);
                }
                break;

            case 'ArrowDown':
                if (activePanel === panel) {
                    e.preventDefault();
                    const firstFocusable = panel.querySelector('a, button, [tabindex]:not([tabindex="-1"])');
                    if (firstFocusable) {
                        firstFocusable.focus();
                    }
                } else {
                    e.preventDefault();
                    openPanel(trigger, panel);
                    setTimeout(function() {
                        const firstFocusable = panel.querySelector('a, button, [tabindex]:not([tabindex="-1"])');
                        if (firstFocusable) {
                            firstFocusable.focus();
                        }
                    }, 100);
                }
                break;

            case 'ArrowUp':
                if (activePanel === panel) {
                    e.preventDefault();
                    trigger.focus();
                }
                break;

            case 'ArrowRight':
                e.preventDefault();
                navigateToSibling(trigger, 'next');
                break;

            case 'ArrowLeft':
                e.preventDefault();
                navigateToSibling(trigger, 'prev');
                break;
        }
    }

    /**
     * Handle keyboard navigation inside panel
     */
    function handlePanelKeyboard(e, trigger, panel) {
        if (e.key === 'Escape') {
            closePanel(trigger, panel);
            trigger.focus();
        }

        // Focus trap (if enabled)
        if (CONFIG.focusTrap && e.key === 'Tab') {
            const focusableElements = panel.querySelectorAll('a, button, [tabindex]:not([tabindex="-1"])');
            const firstFocusable = focusableElements[0];
            const lastFocusable = focusableElements[focusableElements.length - 1];

            if (e.shiftKey) {
                if (document.activeElement === firstFocusable) {
                    e.preventDefault();
                    lastFocusable.focus();
                }
            } else {
                if (document.activeElement === lastFocusable) {
                    e.preventDefault();
                    firstFocusable.focus();
                }
            }
        }
    }

    /**
     * Navigate to sibling mega item
     */
    function navigateToSibling(currentTrigger, direction) {
        const allTriggers = Array.from(document.querySelectorAll('[data-tbmx-toggle="mega"]'));
        const currentIndex = allTriggers.indexOf(currentTrigger);

        let nextIndex;
        if (direction === 'next') {
            nextIndex = (currentIndex + 1) % allTriggers.length;
        } else {
            nextIndex = (currentIndex - 1 + allTriggers.length) % allTriggers.length;
        }

        allTriggers[nextIndex].focus();
    }

    /**
     * Staggered animation for columns
     */
    function staggerColumns(panel) {
        const columns = panel.querySelectorAll('.tbmx-column');
        columns.forEach(function(column, index) {
            column.style.opacity = '0';
            column.style.transform = 'translateY(20px)';
            column.style.transition = 'none';

            setTimeout(function() {
                column.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
                column.style.opacity = '1';
                column.style.transform = 'translateY(0)';
            }, index * CONFIG.staggerDelay);
        });
    }

    /**
     * Lazy load images in panel
     */
    function lazyLoadImages(panel) {
        const images = panel.querySelectorAll('img[data-src]');
        images.forEach(function(img) {
            if (!img.src || img.src === '') {
                img.src = img.getAttribute('data-src');
                img.removeAttribute('data-src');
            }
        });
    }

    /**
     * Setup Intersection Observer for entrance animations
     */
    function setupIntersectionObserver() {
        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('tbmx-in-view');
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        });

        document.querySelectorAll('.tbmx-mega-item').forEach(function(item) {
            observer.observe(item);
        });
    }

    /**
     * Check if mobile breakpoint
     */
    function isMobile() {
        return window.innerWidth < CONFIG.breakpoint;
    }

    /**
     * Dispatch custom event
     */
    function dispatchCustomEvent(eventName, detail) {
        const event = new CustomEvent(eventName, {
            detail: detail,
            bubbles: true,
            cancelable: true
        });
        document.dispatchEvent(event);
    }

    /**
     * Initialize on DOM ready
     */
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

    // Expose API for external use
    window.TBMX_MegaMenu = {
        open: function(triggerSelector) {
            const trigger = document.querySelector(triggerSelector);
            if (trigger) {
                const panelId = trigger.getAttribute('aria-controls');
                const panel = document.getElementById(panelId);
                if (panel) {
                    openPanel(trigger, panel);
                }
            }
        },
        close: function(triggerSelector) {
            const trigger = document.querySelector(triggerSelector);
            if (trigger) {
                const panelId = trigger.getAttribute('aria-controls');
                const panel = document.getElementById(panelId);
                if (panel) {
                    closePanel(trigger, panel);
                }
            }
        },
        closeAll: closeAllPanels,
        getConfig: function() {
            return Object.assign({}, CONFIG);
        },
        setConfig: function(newConfig) {
            Object.assign(CONFIG, newConfig);
        }
    };

})();
