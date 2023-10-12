<?php 
add_action('admin_post_handle_custom_form', 'handle_custom_form_submission');
function handle_custom_form_submission() {

    // Verify the nonce for security
    if (isset($_POST['handle_custom_form_nonce']) && wp_verify_nonce($_POST['handle_custom_form_nonce'], 'handle_custom_form_action')) {

        global $wpdb;
        $table = $wpdb->prefix . 'cpta_post_types';
        $post_slug = $_POST['slug'];
        $results = $wpdb->get_results("SELECT * FROM $table WHERE `slug` = '$post_slug'");

        $errors = array();
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

        $supports = (isset($_POST['supports'])) ? implode(', ', $_POST['supports']) : NULL;
        $taxonomies = (isset($_POST['taxonomies'])) ? implode(', ', $_POST['taxonomies']) : NULL;

        $data = array(
            "slug" => $post_slug,
            "plural" => $_POST['plural'],
            "singular" => $_POST['singular'],
            'menu_icon' => $_POST['menu_icon'],
            'menu_position' => $_POST['menu_position'],
            'supports' => $supports,
            'taxonomies' => $taxonomies,
        );

        if (count($errors) > 0) {
            set_transient('cpta_form_error', $errors, 60);
            set_transient('cpta_form_data', $data, 60);
            wp_redirect(admin_url('admin.php?page=add-new-cpt'));
        }
        else {
            
            $wpdb->insert($table, $data);
            $entry_id = $wpdb->insert_id;
            if( $entry_id ) {
                $message = 'Post type created successfully' ?? false;
                set_transient('cpta_form_success', $message, 60);
                wp_redirect(admin_url() . 'admin.php?page=cpt-list');
            }
            else {
                $message = 'Failed to create post type! please try again' ?? false;
                set_transient('cpta_form_fail', $message, 60);
                wp_redirect(admin_url('admin.php?page=add-new-cpt'));
            }
        }
        exit;
        
    }
}

add_action('admin_post_delete_custom_posttype', 'delete_custom_posttype_by_id');
function delete_custom_posttype_by_id() {

    // Verify the nonce for security
    if (isset($_POST['delete_custom_posttype_nonce']) && wp_verify_nonce($_POST['delete_custom_posttype_nonce'], 'delete_custom_posttype_action')) {
    
        global $wpdb;

        $table = $wpdb->prefix . 'cpta_post_types';
        $post_type_slug = $_POST['slug'];
        $post_type_id = $_POST['id'];

        $related_posts = get_posts( array( 'post_type' => $post_type_slug, 'numberposts' => -1 ) );

        foreach ($related_posts as $related_post) {
            wp_delete_post($related_post->ID, true);
        }
        $result = $wpdb->delete($table, array('id' => $post_type_id));

        if ($result !== false) {
            $message = 'Post type deleted successfully' ?? false;
            set_transient('cpta_form_success', $message, 60);
        } else {
            $message = 'Failed to delete the post type.' ?? false;
            set_transient('cpta_form_fail', $message, 60);
        }
        wp_redirect(admin_url() . 'admin.php?page=cpt-list');
        exit;
    }
}


add_action('admin_post_handle_cpt_edit', 'handle_cpt_edit_single_posttype');
function handle_cpt_edit_single_posttype() {
    
    // Verify the nonce for security
    if (isset($_POST['handle_cpt_edit_nonce']) && wp_verify_nonce($_POST['handle_cpt_edit_nonce'], 'handle_cpt_edit_action')) {
        
        global $wpdb;
        $table = $wpdb->prefix . 'cpta_post_types';
        $post_table = $wpdb->prefix . 'posts';
        $pt_slug = $_POST['slug'];
        $old_slug = $_POST['old_slug'];
        $pt_id = $_POST['id'];
        $results = $wpdb->get_results("SELECT * FROM $table WHERE `slug` = '$pt_slug' AND `id` != $pt_id");
        
        $errors = array();
        if ( empty($pt_slug) ) {
            $errors['cpta_slug_err'] = 'Post type slug is required' ?? false;
        }
        if($old_slug != $pt_slug) {
            if (!empty($results) || post_type_exists($pt_slug)) {
                echo 'Post type with this slug already exists';
            }
        }
        if ( empty($_POST['plural']) ) {
            $errors['cpta_plural_err'] = 'Plural label is required' ?? false;
        }
        if ( empty($_POST['singular']) ) {
            $errors['cpta_singular_err'] = 'Singular label is required' ?? false;
        }
        
        $supports = (isset($_POST['supports'])) ? implode(', ', $_POST['supports']) : NULL;
        $taxonomies = (isset($_POST['taxonomies'])) ? implode(', ', $_POST['taxonomies']) : NULL;
        
        $data = array(
            "slug" => $pt_slug,
            "plural" => $_POST['plural'],
            "singular" => $_POST['singular'],
            'menu_icon' => $_POST['menu_icon'],
            'menu_position' => $_POST['menu_position'],
            'supports' => $supports,
            'taxonomies' => $taxonomies,
            'updated_at' => date('Y-m-d H:i:s'),
        );

        if (count($errors) > 0) {
            set_transient('cpta_form_error', $errors, 60);
            set_transient('cpta_form_data', $data, 60);
            wp_redirect(admin_url('admin.php?page=edit-cpt&id=' . $pt_id));
        }
        else {

            $where = array( 'id' => $pt_id );
            
            $updated = $wpdb->update($table, $data, $where);
            if( $updated ) {
                if($old_slug != $pt_slug) {
                    $post_data = array( 'post_type' => $pt_slug );
                    $post_where = array( 'post_type' => $old_slug );
                    $wpdb->update( $post_table, $post_data, $post_where);
                }
                $message = 'Post type updated successfully' ?? false;
                set_transient('cpta_form_success', $message, 60);
                wp_redirect(admin_url() . 'admin.php?page=cpt-list');
            }
            else {
                $message = 'Failed to update post type! please try again' ?? false;
                set_transient('cpta_form_fail', $message, 60);
                wp_redirect(admin_url('admin.php?page=edit-cpt&id=' . $pt_id));
            }
        }
        exit;
    }
}