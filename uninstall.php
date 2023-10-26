<?php
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    die;
}

global $wpdb;
$table = $wpdb->prefix . 'mcpt_post_types';

$results = $wpdb->get_results("SELECT * FROM $table");
if( !empty($results) ) {
    foreach($results as $item) {
        $args = array(
            'post_type' => $item->slug,
            'posts_per_page' => -1,
        );
        
        $query = new WP_Query($args);
        
        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                wp_delete_post(get_the_ID(), true);
            }
        }
        wp_reset_postdata();
    }
}

$wpdb->query( "DROP TABLE IF EXISTS {$table}" );

?>