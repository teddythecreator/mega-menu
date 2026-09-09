/**
 * TCB-MegaMenu - Front-end interaction
 *
 * @package TCB_MegaMenu
 * @version 1.3.0
 */

(function() {
    'use strict';

    const CONFIG = Object.assign({
        hoverIn: 120,
        hoverOut: 200,
        breakpoint: 980,
        mobileStyle: 'accordion',
        mobilePosition: 'left',
        mobileWidth: 300,
        hamburgerIcon: 'classic',
        hamburgerColor: '#333333',
        hamburgerSize: 24,
        hamburgerThickness: 2
    }, window.tcbConfig || {});

    let activePanel = null;
    let hoverInTimer = null;
    let hoverOutTimer = null;

    function init() {
        const triggers = document.querySelectorAll('[data-tcb-toggle="mega"]');
        if (!triggers.length) return;

        // Add hamburger button for mobile
        addHamburgerButtons();

        triggers.forEach(function(trigger) {
            const li = trigger.closest('.tcb-mega-item');
            if (!li) return;

            const panel = li.querySelector('.tcb-panel');
            if (!panel) return;

            // Add mobile class based on settings
            addMobileClass(panel);

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
                if (isMobile()) return; // Let hamburger handle mobile
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

    function addHamburgerButtons() {
        const megaItems = document.querySelectorAll('.tcb-mega-item');
        
        megaItems.forEach(function(item) {
            const trigger = item.querySelector('a[data-tcb-toggle="mega"]');
            if (!trigger) return;

            // Check if hamburger already exists
            if (item.querySelector('.tcb-hamburger')) return;

            const hamburger = document.createElement('button');
            hamburger.className = 'tcb-hamburger tcb-hamburger-icon-' + CONFIG.hamburgerIcon;
            hamburger.setAttribute('aria-label', 'Toggle menu');
            hamburger.setAttribute('aria-expanded', 'false');
            hamburger.setAttribute('aria-controls', trigger.getAttribute('aria-controls'));
            
            // Add lines
            for (let i = 0; i < 3; i++) {
                const line = document.createElement('span');
                line.className = 'tcb-hamburger-line';
                hamburger.appendChild(line);
            }

            // Insert hamburger after trigger
            trigger.parentNode.insertBefore(hamburger, trigger.nextSibling);

            // Add click handler
            hamburger.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                const panel = document.getElementById(this.getAttribute('aria-controls'));
                if (!panel) return;

                const isExpanded = this.getAttribute('aria-expanded') === 'true';
                
                if (isExpanded) {
                    closePanel(this, panel);
                    this.setAttribute('aria-expanded', 'false');
                } else {
                    // Close any other open panels
                    closeAllPanels();
                    openPanel(this, panel);
                    this.setAttribute('aria-expanded', 'true');
                    
                    // Show overlay for drawer and overlay styles
                    if (CONFIG.mobileStyle === 'drawer' || CONFIG.mobileStyle === 'overlay') {
                        showMobileOverlay();
                    }
                }
            });
        });
    }

    function addMobileClass(panel) {
        const styleClass = 'tcb-mobile-' + CONFIG.mobileStyle;
        panel.classList.add(styleClass);

        // Add position class for drawer
        if (CONFIG.mobileStyle === 'drawer') {
            panel.classList.add('tcb-mobile-position-' + CONFIG.mobilePosition);
        }
    }

    function showMobileOverlay() {
        let overlay = document.querySelector('.tcb-mobile-overlay');
        if (!overlay) {
            overlay = document.createElement('div');
            overlay.className = 'tcb-mobile-overlay';
            document.body.appendChild(overlay);

            overlay.addEventListener('click', function() {
                closeAllPanels();
                hideMobileOverlay();
            });
        }
        
        setTimeout(function() {
            overlay.classList.add('active');
        }, 10);
    }

    function hideMobileOverlay() {
        const overlay = document.querySelector('.tcb-mobile-overlay');
        if (overlay) {
            overlay.classList.remove('active');
            setTimeout(function() {
                overlay.remove();
            }, 300);
        }
    }

    function closeAllPanels() {
        document.querySelectorAll('.tcb-panel[aria-hidden="false"]').forEach(function(panel) {
            const trigger = document.querySelector('[aria-controls="' + panel.id + '"]');
            if (trigger) {
                closePanel(trigger, panel);
                if (trigger.classList.contains('tcb-hamburger')) {
                    trigger.setAttribute('aria-expanded', 'false');
                }
            }
        });
        hideMobileOverlay();
    }

    function openPanel(trigger, panel) {
        if (activePanel && activePanel !== panel) {
            const otherTrigger = document.querySelector('[aria-controls="' + activePanel.id + '"]');
            if (otherTrigger) closePanel(otherTrigger, activePanel);
        }

        trigger.setAttribute('aria-expanded', 'true');
        panel.setAttribute('aria-hidden', 'false');
        panel.removeAttribute('hidden');

        activePanel = panel;
    }

    function closePanel(trigger, panel) {
        trigger.setAttribute('aria-expanded', 'false');
        panel.setAttribute('aria-hidden', 'true');

        setTimeout(function() {
            if (panel.getAttribute('aria-hidden') === 'true') {
                panel.setAttribute('hidden', '');
            }
        }, 300);

        if (activePanel === panel) activePanel = null;
    }

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

    function isMobile() {
        return window.innerWidth < CONFIG.breakpoint;
    }

    // Initialize on DOM ready
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
        closeAll: closeAllPanels
    };

})();
