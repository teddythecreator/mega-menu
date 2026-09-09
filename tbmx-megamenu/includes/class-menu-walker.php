<?php
/**
 * Menu Walker - Custom Nav_Menu Walker
 *
 * Extends Walker_Nav_Menu to inject mega panel markup and ARIA attributes
 * for menu items with _tbmx_enabled meta.
 *
 * @package TBMX_MegaMenu
 */

namespace TBMX_MegaMenu;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Menu_Walker
 *
 * Custom walker that renders mega panels for enabled menu items.
 */
class Menu_Walker extends \Walker_Nav_Menu {

    /**
     * Renderer instance
     *
     * @var Renderer
     */
    private $renderer;

    /**
     * Constructor
     */
    public function __construct() {
        $this->renderer = new Renderer();
    }

    /**
     * Starts the list before the elements are added.
     *
     * @param string    $output Used to append additional content (passed by reference).
     * @param int       $depth  Depth of menu item.
     * @param \stdClass $args   An object of wp_nav_menu() arguments.
     */
    public function start_lvl( &$output, $depth = 0, $args = null ) {
        $indent = str_repeat( "\t", $depth );
        $output .= "\n$indent<ul class=\"sub-menu\">\n";
    }

    /**
     * Ends the list of after the elements are added.
     *
     * @param string    $output Used to append additional content (passed by reference).
     * @param int       $depth  Depth of menu item.
     * @param \stdClass $args   An object of wp_nav_menu() arguments.
     */
    public function end_lvl( &$output, $depth = 0, $args = null ) {
        $indent = str_repeat( "\t", $depth );
        $output .= "$indent</ul>\n";
    }

    /**
     * Start the element output.
     *
     * @param string    $output      Used to append additional content (passed by reference).
     * @param \WP_Post  $data_object Menu item data object.
     * @param int       $depth       Depth of menu item.
     * @param \stdClass $args        An object of wp_nav_menu() arguments.
     * @param int       $id          Current item ID.
     */
    public function start_el( &$output, $data_object, $depth = 0, $args = null, $id = 0 ) {
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

        $classes   = empty( $data_object->classes ) ? array() : (array) $data_object->classes;
        $classes[] = 'menu-item-' . $data_object->ID;

        // Check if this is a mega menu item
        $is_mega = Menu_Fields::is_mega_enabled( $data_object->ID );

        if ( $is_mega && 0 === $depth ) {
            $classes[] = 'tbmx-mega-item';
        }

        /**
         * Filters the arguments for a single nav menu item.
         *
         * @param \stdClass $args      An object of wp_nav_menu() arguments.
         * @param \WP_Post  $data_object Menu item data object.
         * @param int       $depth     Depth of menu item.
         */
        $args = apply_filters( 'nav_menu_item_args', $args, $data_object, $depth );

        /**
         * Filters the CSS class(es) applied to a menu item's list item element.
         *
         * @param string[]  $classes   Array of the CSS classes applied to the menu item's <li> element.
         * @param \WP_Post  $data_object The current menu item object.
         * @param \stdClass $args      An object of wp_nav_menu() arguments.
         * @param int       $depth     Depth of menu item.
         */
        $class_names = implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $data_object, $args, $depth ) );
        $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

        /**
         * Filters the ID applied to a menu item's list item element.
         *
         * @param string    $menu_id   The ID that is applied to the menu item's <li> element.
         * @param \WP_Post  $data_object The current menu item.
         * @param \stdClass $args      An object of wp_nav_menu() arguments.
         * @param int       $depth     Depth of menu item.
         */
        $id = apply_filters( 'nav_menu_item_id', 'menu-item-' . $data_object->ID, $data_object, $args, $depth );
        $id  = $id ? ' id="' . esc_attr( $id ) . '"' : '';

        $output .= $indent . '<li' . $id . $class_names . '>';

        $atts           = array();
        $atts['title']  = ! empty( $data_object->attr_title ) ? $data_object->attr_title : '';
        $atts['target'] = ! empty( $data_object->target ) ? $data_object->target : '';
        if ( '_blank' === $data_object->target && empty( $data_object->xfn ) ) {
            $atts['rel'] = 'noopener';
        } else {
            $atts['rel'] = $data_object->xfn;
        }
        $atts['href']         = ! empty( $data_object->url ) ? $data_object->url : '';
        $atts['aria-current'] = $data_object->current ? 'page' : '';

        // Add mega menu attributes
        if ( $is_mega && 0 === $depth ) {
            $panel_id = 'tbmx-panel-' . $data_object->ID;
            $atts['aria-haspopup']    = 'true';
            $atts['aria-expanded']    = 'false';
            $atts['aria-controls']    = $panel_id;
            $atts['data-tbmx-toggle'] = 'mega';
        }

        /**
         * Filters the HTML attributes applied to a menu item's anchor element.
         *
         * @param array   $atts {
         *     The HTML attributes applied to the menu item's <a> element, empty strings are ignored.
         *
         *     @type string $title        Title attribute.
         *     @type string $target       Target attribute.
         *     @type string $rel          The rel attribute.
         *     @type string $href         The href attribute.
         *     @type string $aria-current The aria-current attribute.
         * }
         * @param \WP_Post  $data_object The current menu item object.
         * @param \stdClass $args        An object of wp_nav_menu() arguments.
         * @param int       $depth       Depth of menu item.
         */
        $atts = apply_filters( 'nav_menu_link_attributes', $atts, $data_object, $args, $depth );

        $attributes = '';
        foreach ( $atts as $attr => $value ) {
            if ( is_scalar( $value ) && '' !== $value && false !== $value ) {
                $attributes .= sprintf( ' %s="%s"', $attr, esc_attr( $value ) );
            }
        }

        /** This filter is documented in wp-includes/post-template.php */
        $title = apply_filters( 'the_title', $data_object->title, $data_object->ID );

        /**
         * Filters a menu item's title.
         *
         * @param string    $title       The menu item's title.
         * @param \WP_Post  $data_object The current menu item object.
         * @param \stdClass $args        An object of wp_nav_menu() arguments.
         * @param int       $depth       Depth of menu item.
         */
        $title = apply_filters( 'nav_menu_item_title', $title, $data_object, $args, $depth );

        $item_output  = isset( $args->before ) ? $args->before : '';
        $item_output .= '<a' . $attributes . '>';
        $item_output .= ( isset( $args->link_before ) ? $args->link_before : '' ) . $title . ( isset( $args->link_after ) ? $args->link_after : '' );
        $item_output .= '</a>';
        $item_output .= isset( $args->after ) ? $args->after : '';

        // Add badge if configured
        if ( $is_mega && 0 === $depth ) {
            $badge = Menu_Fields::get_meta( $data_object->ID, Menu_Fields::META_BADGE, '' );
            if ( ! empty( $badge ) ) {
                $item_output .= '<span class="tbmx-badge">' . esc_html( $badge ) . '</span>';
            }
        }

        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $data_object, $depth, $args );
    }

    /**
     * Ends the element output, if needed.
     *
     * @param string    $output      Used to append additional content (passed by reference).
     * @param \WP_Post  $data_object Menu item data object.
     * @param int       $depth       Depth of menu item.
     * @param \stdClass $args        An object of wp_nav_menu() arguments.
     */
    public function end_el( &$output, $data_object, $depth = 0, $args = null ) {
        // Check if this is a mega menu item
        $is_mega = Menu_Fields::is_mega_enabled( $data_object->ID );

        if ( $is_mega && 0 === $depth ) {
            // Render the mega panel
            $panel_id   = 'tbmx-panel-' . $data_object->ID;
            $panel_content = $this->renderer->render( $data_object->ID );

            // Get panel settings
            $width = Menu_Fields::get_meta( $data_object->ID, Menu_Fields::META_WIDTH, 'full' );
            $align = Menu_Fields::get_meta( $data_object->ID, Menu_Fields::META_ALIGN, 'left' );

            $panel_classes = array( 'tbmx-panel' );
            $panel_classes[] = 'tbmx-width-' . $width;
            $panel_classes[] = 'tbmx-align-' . $align;

            $output .= "\n<div";
            $output .= ' id="' . esc_attr( $panel_id ) . '"';
            $output .= ' class="' . esc_attr( implode( ' ', $panel_classes ) ) . '"';
            $output .= ' role="region"';
            $output .= ' aria-label="' . esc_attr( sprintf( __( 'Mega menu panel for %s', 'tbmx-megamenu' ), $data_object->title ) ) . '"';
            $output .= ' aria-hidden="true"';
            $output .= ' hidden';
            $output .= ">\n";
            $output .= '<div class="tbmx-panel-inner">' . $panel_content . "</div>\n";
            $output .= "</div>\n";
        }

        $output .= "</li>\n";
    }
}
