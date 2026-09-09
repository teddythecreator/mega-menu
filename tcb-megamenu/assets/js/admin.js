/**
 * TCB-MegaMenu - Admin scripts
 *
 * @package TCB_MegaMenu
 * @version 1.0.0
 */

(function($) {
    'use strict';

    function initMetabox() {
        // Toggle fields based on enabled checkbox
        $(document).on('change', '.edit-menu-item-tcb-enabled', function() {
            var $container = $(this).closest('.tcb-menu-fields').find('.tcb-fields-container');
            if ($(this).is(':checked')) {
                $container.slideDown(200);
            } else {
                $container.slideUp(200);
            }
        });

        // Toggle Divi fields based on source
        $(document).on('change', '.edit-menu-item-tcb-source', function() {
            var $diviFields = $(this).closest('.tcb-menu-fields').find('.tcb-divi-fields');
            if ($(this).val() === 'divi_layout') {
                $diviFields.slideDown(200);
            } else {
                $diviFields.slideUp(200);
            }
        });

        // Toggle custom width field
        $(document).on('change', '.edit-menu-item-tcb-width', function() {
            var $widthPxField = $(this).closest('.tcb-menu-fields').find('.field-tcb-width-px');
            if ($(this).val() === 'custom') {
                $widthPxField.slideDown(200);
            } else {
                $widthPxField.slideUp(200);
            }
        });
    }

    function initSettings() {
        // Initialize color pickers
        if ($.fn.wpColorPicker) {
            $('.tcb-color-field').wpColorPicker({
                palettes: ['#e11414', '#050506', '#f5f5f5', '#d40f0f', '#101014', '#f2f3f5', '#161616', '#e8e8e6'],
                change: function(event, ui) {
                    $(this).closest('div').find('.tcb-color-preview').css('background', ui.color.toString());
                }
            });
        }
    }

    $(document).ready(function() {
        if ($('.tcb-menu-fields').length) initMetabox();
        if ($('.tcb-settings-wrap').length) initSettings();
    });

    $(document).on('wp-menu-item-added', function() {
        if ($('.tcb-menu-fields').length) initMetabox();
    });

})(jQuery);
