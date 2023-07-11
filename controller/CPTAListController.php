<?php


class CPTAListController extends CPTAMainController {
    public static function index(){
        /**
         * Extracting passed aguments
         */
        global $wpdb;

        $cpta_post_types =  $wpdb->get_results("SELECT * FROM {$wpdb->prefix}cpta_post_types");
        parent::cpta_set_query_vars(['data'=> $cpta_post_types ]);
        load_template( CPTA_LIB_PATH. '/views/list.php' );
    } 
    
    public static function add_new_cpt() {
        load_template( CPTA_LIB_PATH. '/views/add.php' );
    }
    
    public static function edit_cpt () {
        if(!isset($_GET['id']) || empty($_GET['id'])) {
            exit;
        }
        global $wpdb;
        $pt_id = $_GET['id'];
        $result = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}cpta_post_types WHERE id = $pt_id");
        if($result) {
            parent::cpta_set_query_vars(['data'=> $result ]);
            load_template( CPTA_LIB_PATH. '/views/edit.php' );
        }

    }
}

