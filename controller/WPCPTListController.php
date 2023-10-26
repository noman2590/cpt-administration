<?php

if ( ! defined( 'ABSPATH' ) ) exit;

class WPCPTListController extends WPCPTMainController {
    public static function index(){
        /**
         * Extracting passed aguments
         */
        global $wpdb;

        $wpcpt_post_types =  $wpdb->get_results("SELECT * FROM {$wpdb->prefix}wpcpt_post_types");
        parent::wpcpt_set_query_vars(['data'=> $wpcpt_post_types ]);
        load_template( WPCPT_LIB_PATH. '/views/list.php' );
    } 
    
    public static function wpcpt_add_new_cpt() {
        load_template( WPCPT_LIB_PATH. '/views/add.php' );
    }
    
    public static function wpcpt_edit_cpt () {
        if(!isset($_GET['id']) || empty($_GET['id'])) {
            exit;
        }
        global $wpdb;
        $pt_id = $_GET['id'];
        $result = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}wpcpt_post_types WHERE id = $pt_id");
        if($result) {
            parent::wpcpt_set_query_vars(['data'=> $result ]);
            load_template( WPCPT_LIB_PATH. '/views/edit.php' );
        }

    }
}

