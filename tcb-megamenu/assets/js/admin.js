/**
 * TCB-MegaMenu - Admin scripts
 * Professional UX/UI interactions
 *
 * @package TCB_MegaMenu
 * @version 1.1.0
 */

(function($) {
    'use strict';

    /**
     * Initialize metabox interactions
     */
    function initMetabox() {
        // Toggle wrapper active state
        $(document).on('change', '.edit-menu-item-tcb-enabled', function() {
            var $wrapper = $(this).closest('.tcb-toggle-wrapper');
            var $container = $(this).closest('.tcb-menu-fields').find('.tcb-fields-container');
            
            if ($(this).is(':checked')) {
                $wrapper.addClass('active');
                $container.slideDown(300, 'swing');
            } else {
                $wrapper.removeClass('active');
                $container.slideUp(300, 'swing');
            }
        });

        // Toggle Divi fields based on source with animation
        $(document).on('change', '.edit-menu-item-tcb-source', function() {
            var $diviFields = $(this).closest('.tcb-menu-fields').find('.tcb-divi-fields');
            
            if ($(this).val() === 'divi_layout') {
                $diviFields.slideDown(300, 'swing');
            } else {
                $diviFields.slideUp(300, 'swing');
            }
        });

        // Toggle custom width field with animation
        $(document).on('change', '.edit-menu-item-tcb-width', function() {
            var $widthPxField = $(this).closest('.tcb-menu-fields').find('.field-tcb-width-px');
            
            if ($(this).val() === 'custom') {
                $widthPxField.slideDown(300, 'swing');
            } else {
                $widthPxField.slideUp(300, 'swing');
            }
        });

        // Add visual feedback on input focus
        $(document).on('focus', '.tcb-field-input', function() {
            $(this).closest('.tcb-field-group').addClass('focused');
        });

        $(document).on('blur', '.tcb-field-input', function() {
            $(this).closest('.tcb-field-group').removeClass('focused');
        });

        // Initialize any existing toggles
        $('.edit-menu-item-tcb-enabled').each(function() {
            if ($(this).is(':checked')) {
                $(this).closest('.tcb-toggle-wrapper').addClass('active');
            }
        });
    }

    /**
     * Initialize settings page
     */
    function initSettings() {
        // Initialize color pickers with enhanced options
        if ($.fn.wpColorPicker) {
            $('.tcb-color-field').wpColorPicker({
                palettes: [
                    '#e11414', '#f0b429', '#10b981', '#3b82f6',
                    '#8b5cf6', '#ec4899', '#050506', '#f5f5f5',
                    '#ffffff', '#333333', '#666666', '#999999'
                ],
                change: function(event, ui) {
                    var $wrapper = $(this).closest('.tcb-color-picker-wrapper');
                    var $preview = $wrapper.find('.tcb-color-preview');
                    $preview.css('background', ui.color.toString());
                    
                    // Update live preview if on settings page
                    if ($('#tcb-preview-mockup').length) {
                        updateLivePreview();
                    }
                }
            });
        }

        // Tab navigation
        $('.tcb-tab').on('click', function(e) {
            e.preventDefault();
            var target = $(this).attr('href');
            
            // Update active tab
            $('.tcb-tab').removeClass('active');
            $(this).addClass('active');
            
            // Scroll to section
            if ($(target).length) {
                $('html, body').animate({
                    scrollTop: $(target).offset().top - 100
                }, 500);
            }
        });

        // Live preview updates
        $('input, select').on('change input', function() {
            if ($('#tcb-preview-mockup').length) {
                updateLivePreview();
            }
        });

        // Preview mode toggle
        $('.tcb-preview-btn').on('click', function() {
            var mode = $(this).data('mode');
            $('.tcb-preview-btn').removeClass('active');
            $(this).addClass('active');
            
            var $mockup = $('#tcb-preview-mockup');
            if (mode === 'mobile') {
                $mockup.animate({ maxWidth: '375px' }, 300);
            } else {
                $mockup.animate({ maxWidth: '100%' }, 300);
            }
        });

        // Initialize first preview button as active
        $('.tcb-preview-btn').first().addClass('active');
    }

    /**
     * Update live preview
     */
    function updateLivePreview() {
        var bg = $('input[name$="[bg]"]').val() || '#ffffff';
        var fg = $('input[name$="[fg]"]').val() || '#333333';
        var accent = $('input[name$="[accent]"]').val() || '#e11414';
        var border = $('input[name$="[border]"]').val() || 'rgba(0,0,0,.08)';
        var radius = $('input[name$="[radius]"]').val() || '10px';
        var bgMode = $('select[name$="[bg_mode]"]').val() || 'transparent';

        // Apply background mode
        if (bgMode === 'transparent') {
            bg = 'transparent';
        } else if (bgMode === 'light') {
            bg = 'rgba(255, 255, 255, 0.98)';
        } else if (bgMode === 'dark') {
            bg = '#1a1a1a';
        }

        // Update preview
        $('#tcb-preview-mockup > div').css({
            'background': bg,
            'color': fg,
            'border-radius': radius
        });

        // Update accent colors
        $('#tcb-preview-mockup [style*="color"]').each(function() {
            if ($(this).css('color') !== fg) {
                $(this).css('color', accent);
            }
        });

        // Update CTA button
        $('#tcb-preview-mockup div[style*="background"]').last().css({
            'background': accent,
            'border-radius': radius
        });
    }

    /**
     * Initialize on document ready
     */
    $(document).ready(function() {
        if ($('.tcb-menu-fields').length) {
            initMetabox();
        }
        
        if ($('.tcb-settings-wrap').length) {
            initSettings();
        }
    });

    /**
     * Reinitialize when menu items are added
     */
    $(document).on('wp-menu-item-added', function() {
        if ($('.tcb-menu-fields').length) {
            initMetabox();
        }
    });

    /**
     * Add smooth scroll for anchor links
     */
    $('a[href^="#"]').on('click', function(e) {
        var target = $(this.hash);
        if (target.length) {
            e.preventDefault();
            $('html, body').animate({
                scrollTop: target.offset().top - 100
            }, 500);
        }
    });

})(jQuery);
