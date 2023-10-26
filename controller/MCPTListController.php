<?php

if ( ! defined( 'ABSPATH' ) ) exit;

class MCPTListController extends MCPTMainController {
    public static function index(){
        /**
         * Extracting passed aguments
         */
        global $wpdb;

        $mcpt_post_types =  $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mcpt_post_types");
        parent::mcpt_set_query_vars(['data'=> $mcpt_post_types ]);
        load_template( MCPT_LIB_PATH. '/views/list.php' );
    } 
    
    public static function mcpt_add_new_cpt() {
        load_template( MCPT_LIB_PATH. '/views/add.php' );
    }
    
    public static function mcpt_edit_cpt () {
        if(!isset($_GET['id']) || empty($_GET['id'])) {
            exit;
        }
        global $wpdb;
        $pt_id = $_GET['id'];
        $result = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}mcpt_post_types WHERE id = $pt_id");
        if($result) {
            parent::mcpt_set_query_vars(['data'=> $result ]);
            load_template( MCPT_LIB_PATH. '/views/edit.php' );
        }

    }
}

