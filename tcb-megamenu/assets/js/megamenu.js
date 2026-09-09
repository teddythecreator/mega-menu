/**
 * TCB-MegaMenu - Front-end interaction
 *
 * Vanilla JS (< 5 KB target)
 *
 * @package TCB_MegaMenu
 * @version 1.0.0
 */

(function() {
    'use strict';

    const CONFIG = Object.assign({
        hoverIn: 120,
        hoverOut: 200,
        breakpoint: 980,
        scrollLock: true,
        staggerDelay: 50,
        lazyLoadImages: true
    }, window.tcbConfig || {});

    const REDUCED_MOTION = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    let activePanel = null;
    let hoverInTimer = null;
    let hoverOutTimer = null;
    let scrollPosition = 0;

    function init() {
        const triggers = document.querySelectorAll('[data-tcb-toggle="mega"]');
        if (!triggers.length) return;

        triggers.forEach(function(trigger) {
            const li = trigger.closest('.tcb-mega-item');
            if (!li) return;

            const panel = li.querySelector('.tcb-panel');
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

            // Click/tap
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

            panel.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closePanel(trigger, panel);
                    trigger.focus();
                }
            });

            // Lazy load images
            if (CONFIG.lazyLoadImages) {
                panel.addEventListener('tcb:open', function() {
                    lazyLoadImages(panel);
                });
            }
        });

        // Close on click outside
        document.addEventListener('click', function(e) {
            if (activePanel && !activePanel.contains(e.target)) {
                const trigger = document.querySelector('[aria-controls="' + activePanel.id + '"]');
                if (trigger) closePanel(trigger, activePanel);
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

        // Close on resize
        let resizeTimer;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(function() {
                if (!isMobile() && activePanel) {
                    const trigger = document.querySelector('[aria-controls="' + activePanel.id + '"]');
                    if (trigger) closePanel(trigger, activePanel);
                }
            }, 250);
        });
    }

    function openPanel(trigger, panel) {
        if (activePanel && activePanel !== panel) {
            const otherTrigger = document.querySelector('[aria-controls="' + activePanel.id + '"]');
            if (otherTrigger) closePanel(otherTrigger, activePanel);
        }

        if (CONFIG.scrollLock && isMobile()) {
            scrollPosition = window.pageYOffset || document.documentElement.scrollTop;
            document.body.style.position = 'fixed';
            document.body.style.top = '-' + scrollPosition + 'px';
            document.body.style.width = '100%';
        }

        trigger.setAttribute('aria-expanded', 'true');
        panel.setAttribute('aria-hidden', 'false');
        panel.removeAttribute('hidden');

        if (!REDUCED_MOTION) staggerColumns(panel);

        activePanel = panel;
        panel.dispatchEvent(new CustomEvent('tcb:open'));

        if (!REDUCED_MOTION) {
            setTimeout(function() {
                const firstFocusable = panel.querySelector('a, button, [tabindex]:not([tabindex="-1"])');
                if (firstFocusable) firstFocusable.focus();
            }, 100);
        }
    }

    function closePanel(trigger, panel) {
        trigger.setAttribute('aria-expanded', 'false');
        panel.setAttribute('aria-hidden', 'true');

        if (CONFIG.scrollLock && isMobile()) {
            document.body.style.position = '';
            document.body.style.top = '';
            document.body.style.width = '';
            window.scrollTo(0, scrollPosition);
        }

        const delay = REDUCED_MOTION ? 0 : 220;
        setTimeout(function() {
            if (panel.getAttribute('aria-hidden') === 'true') {
                panel.setAttribute('hidden', '');
            }
        }, delay);

        if (activePanel === panel) activePanel = null;
        panel.dispatchEvent(new CustomEvent('tcb:close'));
    }

    function handleKeyboard(e, trigger, panel) {
        switch (e.key) {
            case 'Enter':
            case ' ':
                e.preventDefault();
                if (activePanel === panel) closePanel(trigger, panel);
                else openPanel(trigger, panel);
                break;
            case 'ArrowDown':
                e.preventDefault();
                if (activePanel !== panel) openPanel(trigger, panel);
                setTimeout(function() {
                    const first = panel.querySelector('a, button, [tabindex]:not([tabindex="-1"])');
                    if (first) first.focus();
                }, 100);
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

    function navigateToSibling(currentTrigger, direction) {
        const allTriggers = Array.from(document.querySelectorAll('[data-tcb-toggle="mega"]'));
        const currentIndex = allTriggers.indexOf(currentTrigger);
        let nextIndex;
        if (direction === 'next') {
            nextIndex = (currentIndex + 1) % allTriggers.length;
        } else {
            nextIndex = (currentIndex - 1 + allTriggers.length) % allTriggers.length;
        }
        allTriggers[nextIndex].focus();
    }

    function staggerColumns(panel) {
        const columns = panel.querySelectorAll('.tcb-column');
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

    function lazyLoadImages(panel) {
        const images = panel.querySelectorAll('img[data-src]');
        images.forEach(function(img) {
            if (!img.src || img.src === '') {
                img.src = img.getAttribute('data-src');
                img.removeAttribute('data-src');
            }
        });
    }

    function isMobile() {
        return window.innerWidth < CONFIG.breakpoint;
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

    // Public API
    window.TCB_MegaMenu = {
        open: function(selector) {
            const trigger = document.querySelector(selector);
            if (trigger) {
                const panel = document.getElementById(trigger.getAttribute('aria-controls'));
                if (panel) openPanel(trigger, panel);
            }
        },
        close: function(selector) {
            const trigger = document.querySelector(selector);
            if (trigger) {
                const panel = document.getElementById(trigger.getAttribute('aria-controls'));
                if (panel) closePanel(trigger, panel);
            }
        },
        closeAll: function() {
            document.querySelectorAll('[data-tcb-toggle="mega"]').forEach(function(trigger) {
                const panel = document.getElementById(trigger.getAttribute('aria-controls'));
                if (panel) closePanel(trigger, panel);
            });
        }
    };

})();
