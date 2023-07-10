<?php 
add_action('admin_post_handle_custom_form', 'handle_custom_form_submission');
function handle_custom_form_submission() {

    // Verify the nonce for security
    if (isset($_POST['handle_custom_form_nonce']) && wp_verify_nonce($_POST['handle_custom_form_nonce'], 'handle_custom_form_action')) {

        session_start();
        global $wpdb;
        $table = $wpdb->prefix . 'cpta_post_types';
        $post_slug = $_POST['slug'];
        $results = $wpdb->get_results("SELECT * FROM $table WHERE `slug` = '$post_slug'");

        $error = array();
        if ( empty($post_slug) ) {
            $errors['cpta_slug_err'] = 'Post type slug is required' ?? false;
        }
        if (!empty($results) || post_type_exists($post_slug)) {
            $errors['cpta_slug_err'] = 'Post type with this slug already exists' ?? false;
        }
        if ( empty($_POST['plural']) ) {
            $errors['cpta_plural_err'] = 'Plural label is required' ?? false;
        }
        if ( empty($_POST['singular']) ) {
            $errors['cpta_singular_err'] = 'Singular label is required' ?? false;
        }

        $data = array(
            "slug" => $post_slug,
            "plural" => $_POST['plural'],
            "singular" => $_POST['singular'],
            'menu_icon' => $_POST['menu_icon'],
            'menu_position' => $_POST['menu_position'],
            'supports' => implode(', ', $_POST['supports']),
            'taxonomies' => implode(', ', $_POST['taxonomies']),
        );

        if (count($errors) > 0) {
            $_SESSION['cpta_form_err'] = $errors;
            $_SESSION['cpta_form_data'] = $data;
        }
        else {
            
            $wpdb->insert($table, $data);
            $entry_id = $wpdb->insert_id;
            if( $entry_id ) {
                $_SESSION['cpta_form_success'] = 'Post type created successfully' ?? false;
            }
            else {
                $_SESSION['cpta_form_fail'] = 'Failed to create post type! please try again' ?? false;
            }
        }
        wp_redirect(admin_url('admin.php?page=add-new-cpt'));
        exit;
        
    }
}

add_action('admin_post_delete_custom_posttype', 'delete_custom_posttype_by_id');
function delete_custom_posttype_by_id() {
    
    global $wpdb;
    session_start();

    $table = $wpdb->prefix . 'cpta_post_types';
    $post_type_slug = $_POST['slug'];
    $post_type_id = $_POST['id'];

    $related_posts = get_posts( array( 'post_type' => $post_type_slug, 'numberposts' => -1 ) );

    foreach ($related_posts as $related_post) {
        wp_delete_post($related_post->ID, true);
    }
    $result = $wpdb->delete($table, array('id' => $post_type_id));

    if ($result !== false) {
        $_SESSION['cpta_delete_success'] = 'Post type deleted successfully' ?? false;
        wp_redirect(admin_url() . 'admin.php?page=cpt-list');
    } else {
        $_SESSION['cpta_delete_fail'] = 'Failed to delete the post type.' ?? false;
        wp_redirect(admin_url() . 'admin.php?page=cpt-list');
    }
    exit;
}