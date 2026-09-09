/**
 * TBMX Mega Menu - Admin scripts
 *
 * Handles UX for the menu item metabox and settings page:
 * - Show/hide fields based on checkbox state
 * - Toggle Divi layout selector based on source
 * - Toggle custom width field based on width type
 * - Color picker initialization
 * - Preset selector
 *
 * @package TBMX_MegaMenu
 * @version 0.1.0
 */

(function($) {
    'use strict';

    /**
     * Initialize metabox interactions
     */
    function initMetabox() {
        // Handle enabled checkbox toggle
        $(document).on('change', '.edit-menu-item-tbmx-enabled', function() {
            var $checkbox = $(this);
            var $container = $checkbox.closest('.tbmx-menu-fields').find('.tbmx-fields-container');

            if ($checkbox.is(':checked')) {
                $container.slideDown(200);
            } else {
                $container.slideUp(200);
            }
        });

        // Handle source selector toggle
        $(document).on('change', '.edit-menu-item-tbmx-source', function() {
            var $select = $(this);
            var $container = $select.closest('.tbmx-menu-fields');
            var $diviFields = $container.find('.tbmx-divi-fields');
            var value = $select.val();

            if (value === 'divi_layout') {
                $diviFields.slideDown(200);
            } else {
                $diviFields.slideUp(200);
            }
        });

        // Handle width selector toggle
        $(document).on('change', '.edit-menu-item-tbmx-width', function() {
            var $select = $(this);
            var $container = $select.closest('.tbmx-menu-fields');
            var $widthPxField = $container.find('.field-tbmx-width-px');
            var value = $select.val();

            if (value === 'custom') {
                $widthPxField.slideDown(200);
            } else {
                $widthPxField.slideUp(200);
            }
        });
    }

    /**
     * Initialize settings page
     */
    function initSettings() {
        // Initialize color pickers
        if ($.fn.wpColorPicker) {
            $('.tbmx-color-field').wpColorPicker({
                palettes: [
                    '#e11414', '#050506', '#f5f5f5', '#d40f0f',
                    '#101014', '#f2f3f5', '#161616', '#e8e8e6'
                ],
                change: function(event, ui) {
                    // Update preview swatch
                    var $wrap = $(this).closest('.tbmx-color-field-wrap');
                    var $preview = $wrap.find('.tbmx-color-preview');
                    $preview.css('background', ui.color.toString());
                }
            });
        }

        // Handle preset selection
        $(document).on('change', 'input[name="tbmx_apply_preset"]', function() {
            var preset = $(this).val();

            // Visual feedback
            $('.tbmx-preset-option').removeClass('selected');
            $(this).closest('.tbmx-preset-option').addClass('selected');
        });
    }

    /**
     * Initialize on document ready
     */
    $(document).ready(function() {
        // Check if we're on the menu editor
        if ($('.tbmx-menu-fields').length) {
            initMetabox();
        }

        // Check if we're on the settings page
        if ($('.tbmx-settings-wrap').length) {
            initSettings();
        }
    });

    /**
     * Handle menu item expand/collapse
     * WordPress fires this event when menu items are expanded
     */
    $(document).on('wp-menu-item-added', function() {
        // Re-initialize metabox for newly added items
        if ($('.tbmx-menu-fields').length) {
            initMetabox();
        }
    });

})(jQuery);
