/**
 * TBMX Mega Menu - Front-end interaction
 *
 * Vanilla JS (< 5 KB target) handling:
 * - Hover-intent (120ms in, 200ms out)
 * - Click/tap to open
 * - Keyboard navigation (Enter, Space, Esc, Tab)
 * - ARIA state management (aria-expanded, aria-hidden)
 * - Mobile accordion (< breakpoint)
 * - Respects prefers-reduced-motion
 *
 * @package TBMX_MegaMenu
 * @version 0.1.0
 */

(function() {
    'use strict';

    /**
     * Configuration (injected from PHP via wp_localize_script)
     */
    const CONFIG = window.tbmxConfig || {
        hoverIn: 120,
        hoverOut: 200,
        breakpoint: 980
    };

    const REDUCED_MOTION = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    /**
     * State management
     */
    let activePanel = null;
    let hoverInTimer = null;
    let hoverOutTimer = null;

    /**
     * Initialize mega menu
     */
    function init() {
        const triggers = document.querySelectorAll('[data-tbmx-toggle="mega"]');

        if (!triggers.length) return;

        triggers.forEach(function(trigger) {
            const li = trigger.closest('.tbmx-mega-item');
            if (!li) return;

            const panel = li.querySelector('.tbmx-panel');
            if (!panel) return;

            // Desktop: hover intent
            li.addEventListener('mouseenter', function() {
                if (isMobile()) return;
                clearTimeout(hoverOutTimer);
                hoverInTimer = setTimeout(function() {
                    openPanel(trigger, panel);
                }, CONFIG.hoverIn);
            });

            li.addEventListener('mouseleave', function() {
                if (isMobile()) return;
                clearTimeout(hoverInTimer);
                hoverOutTimer = setTimeout(function() {
                    closePanel(trigger, panel);
                }, CONFIG.hoverOut);
            });

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
                if (e.key === 'Escape') {
                    closePanel(trigger, panel);
                    trigger.focus();
                }
            });
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
    }

    /**
     * Open panel
     * @param {HTMLElement} trigger - The menu item trigger
     * @param {HTMLElement} panel - The panel to open
     */
    function openPanel(trigger, panel) {
        // Close any other open panel first
        if (activePanel && activePanel !== panel) {
            const otherTrigger = document.querySelector('[aria-controls="' + activePanel.id + '"]');
            if (otherTrigger) {
                closePanel(otherTrigger, activePanel);
            }
        }

        // Open this panel
        trigger.setAttribute('aria-expanded', 'true');
        panel.setAttribute('aria-hidden', 'false');
        panel.removeAttribute('hidden');

        activePanel = panel;

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
     * @param {HTMLElement} trigger - The menu item trigger
     * @param {HTMLElement} panel - The panel to close
     */
    function closePanel(trigger, panel) {
        trigger.setAttribute('aria-expanded', 'false');
        panel.setAttribute('aria-hidden', 'true');

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
     * Handle keyboard navigation
     * @param {KeyboardEvent} e
     * @param {HTMLElement} trigger
     * @param {HTMLElement} panel
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

            case 'Escape':
                if (activePanel === panel) {
                    closePanel(trigger, panel);
                    trigger.focus();
                }
                break;

            case 'ArrowDown':
                if (activePanel === panel) {
                    e.preventDefault();
                    const firstFocusable = panel.querySelector('a, button, [tabindex]:not([tabindex="-1"])');
                    if (firstFocusable) {
                        firstFocusable.focus();
                    }
                }
                break;

            case 'ArrowUp':
                if (activePanel === panel) {
                    e.preventDefault();
                    trigger.focus();
                }
                break;
        }
    }

    /**
     * Check if mobile breakpoint
     * @returns {boolean}
     */
    function isMobile() {
        return window.innerWidth < CONFIG.breakpoint;
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
        closeAll: closeAllPanels
    };

})();
