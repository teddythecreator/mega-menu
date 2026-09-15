<?php
/**
 * Renderer - Panel content renderer
 *
 * CRITICAL: Uses apply_filters('the_content') for proper Divi shortcode processing.
 * This ensures Divi modules render correctly with all their styles and scripts.
 *
 * @package TCB_MegaMenu
 */

namespace TCB_MegaMenu;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Renderer {

    /**
     * Render panel content for a menu item
     */
    public function render( $item_id ) {
        $source    = Menu_Fields::get_meta( $item_id, Menu_Fields::META_SOURCE, 'divi_layout' );
        $layout_id = (int) Menu_Fields::get_meta( $item_id, Menu_Fields::META_LAYOUT_ID, 0 );

        if ( 'divi_layout' === $source && $layout_id > 0 ) {
            return $this->render_divi_layout( $layout_id );
        }

        return $this->render_columns( $item_id );
    }

    /**
     * Render content from a Divi Library layout
     *
     * IMPORTANT: We use apply_filters('the_content') instead of do_shortcode()
     * because Divi registers its shortcodes through the_content filter.
     * This ensures all Divi modules render with their proper HTML, CSS, and JS.
     *
     * @param int $layout_id Post ID of the et_pb_layout.
     * @return string Rendered HTML.
     */
    private function render_divi_layout( $layout_id ) {
        $layout = get_post( $layout_id );

        if ( ! $layout || 'et_pb_layout' !== $layout->post_type ) {
            return $this->render_error( __( 'Layout not found or invalid.', 'tcb-megamenu' ) );
        }

        $content = $layout->post_content;

        if ( empty( $content ) ) {
            return $this->render_error( __( 'Layout is empty.', 'tcb-megamenu' ) );
        }

        // Check if Divi is active
        if ( ! self::is_divi_active() ) {
            return $this->render_error(
                __( 'Divi is not active. Please activate Divi theme or Divi Builder plugin to render this layout. Alternatively, use "Custom Columns" mode.', 'tcb-megamenu' )
            );
        }

        // Ensure Divi shortcodes are registered
        if ( function_exists( 'et_pb_allow_shortcode_processing' ) ) {
            et_pb_allow_shortcode_processing();
        }

        // CRITICAL: Use apply_filters('the_content') for proper Divi rendering
        // This processes all Divi shortcodes and applies necessary filters
        $content = apply_filters( 'the_content', $content );

        // Wrap in container for proper styling isolation
        $output = '<div class="tcb-divi-content tcb-layout-' . esc_attr( $layout_id ) . '">';
        $output .= $content;
        $output .= '</div>';

        return $output;
    }

    /**
     * Render custom columns layout (fallback without Divi)
     */
    private function render_columns( $item_id ) {
        $children = $this->get_child_items( $item_id );

        if ( empty( $children ) ) {
            return '<p class="tcb-empty">' . esc_html__( 'No child menu items found. Add sub-items to this menu item to populate the panel.', 'tcb-megamenu' ) . '</p>';
        }

        // Determine column count based on number of items
        $count = count( $children );
        if ( $count <= 5 ) {
            $column_count = 1;
        } elseif ( $count <= 10 ) {
            $column_count = 2;
        } elseif ( $count <= 15 ) {
            $column_count = 3;
        } else {
            $column_count = 4;
        }

        $columns = array_chunk( $children, (int) ceil( $count / $column_count ) );

        ob_start();
        ?>
        <div class="tcb-columns" style="grid-template-columns: repeat(<?php echo esc_attr( $column_count ); ?>, 1fr);">
            <?php foreach ( $columns as $column ) : ?>
                <div class="tcb-column">
                    <ul class="tcb-column-links">
                        <?php foreach ( $column as $child ) : ?>
                            <li>
                                <a href="<?php echo esc_url( $child->url ); ?>"<?php echo ! empty( $child->target ) ? ' target="' . esc_attr( $child->target ) . '"' : ''; ?>>
                                    <?php echo esc_html( $child->title ); ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endforeach; ?>
        </div>
        <?php
        return ob_get_clean();
    }

    /**
     * Render error message
     */
    private function render_error( $message ) {
        return '<div class="tcb-error"><p>' . esc_html( $message ) . '</p></div>';
    }

    /**
     * Get child menu items for a parent item
     */
    private function get_child_items( $parent_id ) {
        $menu_ids = wp_get_post_terms( $parent_id, 'nav_menu', array( 'fields' => 'ids' ) );

        if ( empty( $menu_ids ) ) {
            return array();
        }

        $menu_id = $menu_ids[0];
        $items = wp_get_nav_menu_items( $menu_id );

        if ( empty( $items ) ) {
            return array();
        }

        $children = array();
        foreach ( $items as $item ) {
            if ( (int) $item->menu_item_parent === $parent_id ) {
                $children[] = $item;
            }
        }

        return $children;
    }

    /**
     * Check if Divi is active
     *
     * Checks for:
     * 1. Divi theme (et_setup_theme function)
     * 2. Divi Builder plugin (ET_BUILDER_PLUGIN_VERSION constant)
     * 3. et_pb_layout CPT existence
     */
    public static function is_divi_active() {
        if ( function_exists( 'et_setup_theme' ) ) {
            return true;
        }

        if ( defined( 'ET_BUILDER_PLUGIN_VERSION' ) ) {
            return true;
        }

        if ( post_type_exists( 'et_pb_layout' ) ) {
            return true;
        }

        return false;
    }

    /**
     * Get available Divi Library layouts
     *
     * @return array Array of layout objects (ID, post_title).
     */
    public static function get_divi_layouts() {
        if ( ! self::is_divi_active() ) {
            return array();
        }

        $layouts = get_posts( array(
            'post_type'      => 'et_pb_layout',
            'posts_per_page' => -1,
            'post_status'    => 'publish',
            'orderby'        => 'title',
            'order'          => 'ASC',
            'fields'         => 'ids',
        ) );

        if ( empty( $layouts ) ) {
            return array();
        }

        $result = array();
        foreach ( $layouts as $layout_id ) {
            $result[] = (object) array(
                'ID'         => $layout_id,
                'post_title' => get_the_title( $layout_id ),
            );
        }

        return $result;
    }
}
