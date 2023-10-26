<?php

if ( ! defined( 'ABSPATH' ) ) exit;

require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

class WPCPTMainController
{
    public function __construct()
    {
        register_activation_hook( WPCPT_PLUGIN_BASENAME, array( $this, 'wpcpt_activation_hook' ));
        add_action('init', array($this, 'wpcpt_create_custom_post_type'));
        add_action('admin_menu', array( $this, 'wpcpt_admin_menu' ));
        add_action('admin_menu', array( $this, 'wpcpt_register_add_new_page' ));
        add_action('admin_menu', array( $this, 'wpcpt_register_edit_page' ));
        add_action('admin_enqueue_scripts', array( $this, 'wpcpt_enqueue_admin_scripts'));
    }

    public function wpcpt_activation_hook () {
        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();
        $table_name = $wpdb->prefix . 'wpcpt_post_types';
        if ( $wpdb->get_var( $wpdb->prepare( "SHOW TABLES LIKE %s", $table_name ) ) !== $table_name ) {
            $sql = "CREATE TABLE  $table_name (
                `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, 
                `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                `singular` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                `plural` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                `menu_icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                `menu_position` bigint(20) UNSIGNED DEFAULT NULL,
                `supports` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                `taxonomies` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
                `updated_at` timestamp NULL DEFAULT NULL,
                PRIMARY KEY  (id)
            ) $charset_collate;";
            dbDelta($sql);
        }
    }

    public static function wpcpt_set_query_vars ( $args )
    {
        global $wp_query;
        $wp_query->set("data", $args);

    }

    public function wpcpt_admin_menu() {
        add_menu_page(
            __('CPT List', 'cpt-list'),
            __('CPT List', 'cpt-list'),
            'manage_options',
            'cpt-list',
            'WPCPTListController::index',
            'dashicons-editor-table',
        );
    }

    function wpcpt_register_add_new_page() {
        add_submenu_page(
            'cpt-list',
            __('Add New Post Type', 'add-new-cpt'),
            __('Add New', 'add-new-cpt'),
            'manage_options',
            'add-new-cpt',
            'WPCPTListController::wpcpt_add_new_cpt'
        );
    }

    function wpcpt_register_edit_page () {
        add_submenu_page(
            'cpt-list',
            __('Edit Post Type', 'edit-cpt'),
            __('Edit Post Type', 'edit-cpt'),
            'manage_options',
            'edit-cpt',
            'WPCPTListController::wpcpt_edit_cpt'
        );
    }

    function wpcpt_enqueue_admin_scripts() {
        wp_enqueue_style( 'wpcpt-style', WPCPT_PLUGIN_URL . '/lib/assets/css/style.css' );
        wp_enqueue_script( 'wpcpt-js', WPCPT_PLUGIN_URL . '/lib/assets/js/main.js' );
        wp_enqueue_style( 'dashicons-css', WPCPT_PLUGIN_URL . '/lib/assets/css/dashicons-picker.css' );
        wp_enqueue_script( 'dashicons-picker-js', WPCPT_PLUGIN_URL . '/lib/assets/js/dashicons-picker.js' );
    }

    function wpcpt_create_custom_post_type() {

        global $wpdb;
        $table = $wpdb->prefix . 'wpcpt_post_types';

        $results = $wpdb->get_results("SELECT * FROM $table");
        if( !empty($results) ) {
            foreach($results as $item) {

                $labels = array(
                    'name'                => _x( $item->plural , 'Post Type General Name' ),
                    'singular_name'       => _x( $item->singular , 'Post Type Singular Name' ),
                    'menu_name'           => __( $item->plural  ),
                    'parent_item_colon'   => __( 'Parent ' . $item->singular ),
                    'all_items'           => __( 'All ' . $item->plural ),
                    'view_item'           => __( 'View ' . $item->singular ),
                    'add_new_item'        => __( 'Add New ' . $item->singular ),
                    'add_new'             => __( 'Add New' ),
                    'edit_item'           => __( 'Edit ' . $item->singular ),
                    'update_item'         => __( 'Update ' . $item->singular ),
                    'search_items'        => __( 'Search ' . $item->singular ),
                    'not_found'           => __( $item->plural . ' Not Found' ),
                    'not_found_in_trash'  => __( $item->plural . ' Not found in Trash' ),
                );

                register_post_type( $item->slug,
                    array(
                        'labels'              => $labels,
                        'supports'            => explode(', ', $item->supports),
                        'taxonomies'          => explode(', ', $item->taxonomies ),
                        'public'              => true,
                        'has_archive'         => true,
                        'hierarchical'        => false,
                        'show_ui'             => true,
                        'show_in_menu'        => true,
                        'show_in_nav_menus'   => true,
                        'show_in_admin_bar'   => true,
                        'menu_position'       => (int) $item->menu_position,
                        'menu_icon'           => $item->menu_icon,
                        'can_export'          => true,
                        'exclude_from_search' => false,
                        'publicly_queryable'  => true,
                        'capability_type'     => 'post',
                        'show_in_rest'        => true,
                    )
                );
            }
        }
    }
}