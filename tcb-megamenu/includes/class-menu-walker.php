<?php
/**
 * Menu Walker - Custom Nav_Menu Walker
 *
 * @package TCB_MegaMenu
 */

namespace TCB_MegaMenu;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Menu_Walker extends \Walker_Nav_Menu {

    private $renderer;
    private $mega_panels = array();

    public function __construct() {
        $this->renderer = new Renderer();
    }

    public function start_lvl( &$output, $depth = 0, $args = null ) {
        $indent = str_repeat( "\t", $depth );
        $output .= "\n$indent<ul class=\"sub-menu\">\n";
    }

    public function end_lvl( &$output, $depth = 0, $args = null ) {
        $indent = str_repeat( "\t", $depth );
        $output .= "$indent</ul>\n";
    }

    public function start_el( &$output, $data_object, $depth = 0, $args = null, $id = 0 ) {
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

        $classes   = empty( $data_object->classes ) ? array() : (array) $data_object->classes;
        $classes[] = 'menu-item-' . $data_object->ID;

        $is_mega = Menu_Fields::is_mega_enabled( $data_object->ID );

        if ( $is_mega && 0 === $depth ) {
            $classes[] = 'tcb-mega-item';
        }

        $args = apply_filters( 'nav_menu_item_args', $args, $data_object, $depth );

        $class_names = implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $data_object, $args, $depth ) );
        $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

        $id = apply_filters( 'nav_menu_item_id', 'menu-item-' . $data_object->ID, $data_object, $args, $depth );
        $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

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
            $panel_id = 'tcb-panel-' . $data_object->ID;
            $atts['aria-haspopup']    = 'true';
            $atts['aria-expanded']    = 'false';
            $atts['aria-controls']    = $panel_id;
            $atts['data-tcb-toggle']  = 'mega';
            
            // Store panel data for later rendering
            $this->mega_panels[ $data_object->ID ] = array(
                'id' => $panel_id,
                'item' => $data_object,
            );
        }

        $atts = apply_filters( 'nav_menu_link_attributes', $atts, $data_object, $args, $depth );

        $attributes = '';
        foreach ( $atts as $attr => $value ) {
            if ( is_scalar( $value ) && '' !== $value && false !== $value ) {
                $attributes .= sprintf( ' %s="%s"', $attr, esc_attr( $value ) );
            }
        }

        $title = apply_filters( 'the_title', $data_object->title, $data_object->ID );
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
                $item_output .= '<span class="tcb-badge">' . esc_html( $badge ) . '</span>';
            }
        }

        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $data_object, $depth, $args );
    }

    public function end_el( &$output, $data_object, $depth = 0, $args = null ) {
        $output .= "</li>\n";
    }

    /**
     * Render all mega panels after the menu
     */
    public function walk( $elements, $max_depth, ...$args ) {
        $output = parent::walk( $elements, $max_depth, ...$args );
        
        // Append all mega panels at the end
        if ( ! empty( $this->mega_panels ) ) {
            $output .= "\n<!-- TCB Mega Menu Panels -->\n";
            $output .= '<div class="tcb-mega-panels-container">' . "\n";
            
            foreach ( $this->mega_panels as $item_id => $panel_data ) {
                $panel_id = $panel_data['id'];
                $item = $panel_data['item'];
                $panel_content = $this->renderer->render( $item_id );

                $width    = Menu_Fields::get_meta( $item_id, Menu_Fields::META_WIDTH, 'full' );
                $width_px = Menu_Fields::get_meta( $item_id, Menu_Fields::META_WIDTH_PX, 1200 );
                $align    = Menu_Fields::get_meta( $item_id, Menu_Fields::META_ALIGN, 'left' );

                $panel_classes = array( 'tcb-panel' );
                $panel_classes[] = 'tcb-width-' . $width;
                $panel_classes[] = 'tcb-align-' . $align;

                // Inline style para custom width
                $inline_style = '';
                if ( 'custom' === $width && $width_px > 0 ) {
                    $inline_style = ' style="width: ' . intval( $width_px ) . 'px;"';
                }

                $output .= '<div';
                $output .= ' id="' . esc_attr( $panel_id ) . '"';
                $output .= ' class="' . esc_attr( implode( ' ', $panel_classes ) ) . '"';
                $output .= $inline_style;
                $output .= ' role="region"';
                $output .= ' aria-label="' . esc_attr( sprintf( __( 'Mega menu panel for %s', 'tcb-megamenu' ), $item->title ) ) . '"';
                $output .= ' aria-hidden="true"';
                $output .= ' hidden';
                $output .= ">\n";
                $output .= '<div class="tcb-panel-inner">' . $panel_content . "</div>\n";
                $output .= "</div>\n";
            }
            
            $output .= '</div>' . "\n";
        }
        
        return $output;
    }
}
