<?php


class CPTAListController extends CPTAMainController {
    public static function index(){
        /**
         * Extracting passed aguments
         */
        global $wpdb;

        // $start_date = (isset($_GET['from_date']) && !empty($_GET['from_date'])) ? $_GET['from_date'] : null;
        // $end_date = (isset($_GET['to_date']) && !empty($_GET['to_date'])) ? date('Y-m-d', strtotime("+1 day", strtotime($_GET['to_date']))) : date('Y-m-d', strtotime("+1 day"));

        $cpta_post_types =  $wpdb->get_results("SELECT * FROM {$wpdb->prefix}cpta_post_types");
        parent::cpta_set_query_vars(['data'=> $cpta_post_types ]);
        load_template( CPTA_LIB_PATH. '/views/list.php' );
    } 
    
    public static function add_new_cpt() {
        load_template( CPTA_LIB_PATH. '/views/add.php' );
    }

    public static function add_cpt() {
        
    }
}

