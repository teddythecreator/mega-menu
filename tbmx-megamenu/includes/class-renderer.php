<?php
/**
 * Renderer - Panel content renderer
 *
 * Renders the mega panel content from either:
 * - Divi Library layout (et_pb_layout CPT)
 * - Custom columns (fallback without Divi)
 *
 * @package TBMX_MegaMenu
 */

namespace TBMX_MegaMenu;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Renderer
 *
 * Handles rendering of mega panel content.
 */
class Renderer {

    /**
     * Render panel content for a menu item
     *
     * @param int $item_id Menu item ID.
     * @return string Panel HTML content.
     */
    public function render( $item_id ) {
        $source    = Menu_Fields::get_meta( $item_id, Menu_Fields::META_SOURCE, 'divi_layout' );
        $layout_id = (int) Menu_Fields::get_meta( $item_id, Menu_Fields::META_LAYOUT_ID, 0 );

        if ( 'divi_layout' === $source && $layout_id > 0 ) {
            return $this->render_divi_layout( $layout_id );
        }

        // Fallback: render custom columns
        return $this->render_columns( $item_id );
    }

    /**
     * Render content from a Divi Library layout
     *
     * @param int $layout_id Post ID of the et_pb_layout.
     * @return string Rendered HTML.
     */
    private function render_divi_layout( $layout_id ) {
        $layout = get_post( $layout_id );

        if ( ! $layout || 'et_pb_layout' !== $layout->post_type ) {
            return '';
        }

        // Get the layout content
        $content = $layout->post_content;

        if ( empty( $content ) ) {
            return '';
        }

        // Process Divi shortcodes
        if ( self::is_divi_active() ) {
            // Divi is active, process shortcodes
            $content = do_shortcode( $content );
        } else {
            // Divi not active, return raw content with warning
            $content = '<p class="tbmx-warning">' . esc_html__( 'Divi is not active. Please activate Divi to render this layout.', 'tbmx-megamenu' ) . '</p>';
        }

        return $content;
    }

    /**
     * Render custom columns layout (fallback)
     *
     * @param int $item_id Menu item ID.
     * @return string Rendered HTML.
     */
    private function render_columns( $item_id ) {
        // Get child menu items
        $children = $this->get_child_items( $item_id );

        if ( empty( $children ) ) {
            return '<p class="tbmx-empty">' . esc_html__( 'No child menu items found.', 'tbmx-megamenu' ) . '</p>';
        }

        // Group into columns (3 columns by default)
        $columns = array_chunk( $children, ceil( count( $children ) / 3 ) );

        ob_start();
        ?>
        <div class="tbmx-columns">
            <?php foreach ( $columns as $column ) : ?>
                <div class="tbmx-column">
                    <ul class="tbmx-column-links">
                        <?php foreach ( $column as $child ) : ?>
                            <li>
                                <a href="<?php echo esc_url( $child->url ); ?>">
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
     * Get child menu items for a parent item
     *
     * @param int $parent_id Parent menu item ID.
     * @return array Array of menu item objects.
     */
    private function get_child_items( $parent_id ) {
        global $wpdb;

        // Get the menu this item belongs to
        $menu_id = wp_get_post_terms( $parent_id, 'nav_menu', array( 'fields' => 'ids' ) );

        if ( empty( $menu_id ) ) {
            return array();
        }

        $menu_id = $menu_id[0];

        // Get all items in this menu
        $items = wp_get_nav_menu_items( $menu_id );

        if ( empty( $items ) ) {
            return array();
        }

        // Filter children of the parent
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
     * @return bool
     */
    public static function is_divi_active() {
        // Check for Divi theme
        if ( function_exists( 'et_setup_theme' ) ) {
            return true;
        }

        // Check for Divi Builder plugin
        if ( defined( 'ET_BUILDER_PLUGIN_VERSION' ) ) {
            return true;
        }

        // Check if et_pb_layout CPT exists
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
