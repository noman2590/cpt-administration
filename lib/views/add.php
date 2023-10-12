<?php
    $errors = get_transient('cpta_form_error') ?? array();
    $form_data = get_transient('cpta_form_data') ?? array();
    $form_success = get_transient('cpta_form_success') ?? false;
    $form_fail = get_transient('cpta_form_fail') ?? false; 

    delete_transient('cpta_form_error');
    delete_transient('cpta_form_data');
    delete_transient('cpta_form_fail');
    delete_transient('cpta_form_success');

    $supports = (isset($form_data['supports'])) ? explode(', ', $form_data['supports']) : array();
    $taxonomies = (isset($form_data['taxonomies'])) ? explode(', ', $form_data['taxonomies']) : array();

?>
<div class="wrap">
    <h1 class="wp-heading-inline">Add New Post Type</h1>
    

    <div class="postbox cpta-post-box">
        <div class="postbox-header">
            <h2 class="ui-sortable-handle">Post Type Settings</h2>
        </div>
        <div class="inside">
            <div class="main">
                <form name="add_cpt" method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                    <div class="">
                        <table>
                            <tr>
                                <td colspan="2">
                                    <div class="alert cpta-alert-success <?php echo ($form_success) ? '' : 'cpta-hidden' ?>">
                                        <?php echo ($form_success) ? $form_success : '' ?>
                                    </div>
                                    <div class="alert cpta-alert-fail <?php echo ($form_fail) ? '' : 'cpta-hidden' ?>">
                                        <?php echo ($form_fail) ? $form_fail : '' ?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="slug">Post Type Slug <span>*</span></label></td>
                                <td>
                                    <input 
                                        type="text" name="slug" id="slug" 
                                        class="<?php echo (isset($errors['cpta_slug_err'])) ? 'cpta-red-border' : '';?>" 
                                        value="<?php echo (isset($form_data['slug'])) ? $form_data['slug'] : '';?>" 
                                        placeholder="The post type name/slug. Used for various queries." />
                                    <?php echo (isset($errors['cpta_slug_err'])) ? '<small>' . $errors['cpta_slug_err'] . '</small>' : ''; ?>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="plural">Plural Label <span>*</span></label></td>
                                <td>
                                    <input 
                                        type="text" name="plural" id="plural" 
                                        class="<?php echo (isset($errors['cpta_plural_err'])) ? 'cpta-red-border' : '';?>"
                                        value="<?php echo (isset($form_data['plural'])) ? $form_data['plural'] : '';?>" 
                                        placeholder="(e.g. Services) Used in admin menu." />
                                    <?php echo (isset($errors['cpta_plural_err'])) ? '<small>' . $errors['cpta_plural_err'] . '</small>' : ''; ?>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="singular">Singular Label <span>*</span></label></td>
                                <td>
                                    <input 
                                    type="text" name="singular" id="singular" 
                                    class="<?php echo (isset($errors['cpta_singular_err'])) ? 'cpta-red-border' : '';?>" 
                                    value="<?php echo (isset($form_data['singular'])) ? $form_data['singular'] : '';?>" 
                                    placeholder="(e.g. Service) Used where needed as single label." />
                                    <?php echo (isset($errors['cpta_singular_err'])) ? '<small>' . $errors['cpta_singular_err'] . '</small>' : ''; ?>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="menu_icon">Menu Icon</label></td>
                                <td>
                                    <input 
                                        name="menu_icon" id="menu_icon" type="text"
                                        value="<?php echo (isset($form_data['menu_icon'])) ? $form_data['menu_icon'] : '';?>" 
                                        placeholder="Paste dashicon class here or choose from button below." />
                                        <input class="button dashicons-picker" type="button" value="Choose Icon" data-target="#menu_icon" />
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="menu_position">Menu Position</label></td>
                                    <td>
                                        <input 
                                        name="menu_position" id="menu_position" type="number" 
                                        min="5" max="100" 
                                        value="<?php echo (isset($form_data['menu_position'])) ? $form_data['menu_position'] : '';?>" 
                                        placeholder="Select from range of 5 to 100" />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="supports">Supports</label>
                                    <p>Check the 'None' option to set 'supports' to false.</p>
                                </td>
                                <td>
                                    <fieldset>
                                        <input type="checkbox" id="title" value="title" name="supports[]" <?php echo (($supports) && in_array('title', $supports)) ? 'checked' : '';?> /> 
                                        <label for="title">Title</label>
                                        <br />
                                        <input type="checkbox" id="editor" value="editor" name="supports[]" <?php echo (($supports) && in_array('editor', $supports)) ? 'checked' : '';?> /> 
                                        <label for="editor">Editor</label>
                                        <br />
                                        <input type="checkbox" id="featured_image" value="thumbnail" name="supports[]" <?php echo (($supports) && in_array('thumbnail', $supports)) ? 'checked' : '';?> /> 
                                        <label for="featured_image">Featured Image</label>
                                        <br />
                                        <input type="checkbox" id="post_excerpt" value="excerpt" name="supports[]" <?php echo (($supports) && in_array('excerpt', $supports)) ? 'checked' : '';?> /> 
                                        <label for="post_excerpt">Excerpt</label>
                                        <br />
                                        <input type="checkbox" id="trackbacks" value="trackbacks" name="supports[]" <?php echo (($supports) && in_array('trackbacks', $supports)) ? 'checked' : '';?> /> 
                                        <label for="trackbacks">Trackbacks</label>
                                        <br />
                                        <input type="checkbox" id="custom_fields" value="custom-fields" name="supports[]" <?php echo (($supports) && in_array('custom-fields', $supports)) ? 'checked' : '';?> /> 
                                        <label for="custom_fields">Custom Fields</label>
                                        <br />
                                        <input type="checkbox" id="comments" value="comments" name="supports[]" <?php echo (($supports) && in_array('comments', $supports)) ? 'checked' : '';?> /> 
                                        <label for="comments">Comments</label>
                                        <br />
                                        <input type="checkbox" id="revisions" value="revisions" name="supports[]" <?php echo (($supports) && in_array('revisions', $supports)) ? 'checked' : '';?> /> 
                                        <label for="revisions">Revisions</label>
                                        <br />
                                        <input type="checkbox" id="author" value="author" name="supports[]" <?php echo (($supports) && in_array('author', $supports)) ? 'checked' : '';?> /> 
                                        <label for="author">Author</label>
                                        <br />
                                        <input type="checkbox" id="page_attributes" value="page_attributes" name="supports[]" <?php echo (($supports) && in_array('page_attributes', $supports)) ? 'checked' : '';?> /> 
                                        <label for="page_attributes">Page Attributes</label>
                                        <br />
                                        <input type="checkbox" id="post_formats" value="post_formats" name="supports[]" <?php echo (($supports) && in_array('post_formats', $supports)) ? 'checked' : '';?> /> 
                                        <label for="post_formats">Post Formats</label>
                                        <br />
                                        <input type="checkbox" id="none" value="none" name="supports[]" <?php echo (($supports) && in_array('none', $supports)) ? 'checked' : '';?> /> 
                                        <label for="none">None</label>
                                        <br />
                                    </fieldset>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="taxonomies">Taxonomies</label>
                                    <p>Add supports for taxonomies.</p>
                                </td>
                                <td>
                                    <fieldset>
                                        <input type="checkbox" id="category" value="category" name="taxonomies[]" <?php echo (isset($taxonomies) && in_array('category', $taxonomies)) ? 'checked' : '';?> /> 
                                        <label for="category">Categories</label>
                                        <br />
                                        <input type="checkbox" id="post_tag" value="post_tag" name="taxonomies[]" <?php echo (isset($taxonomies) && in_array('post_tag', $taxonomies)) ? 'checked' : '';?> /> 
                                        <label for="post_tag">Tags</label>
                                    </fieldset>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td><input type="submit" class="button-primary" name="" id="singular" value="Add Post Type" /></td>
                            </tr>
                        </table>
                    </div>
                    <input type="hidden" name="action" value="handle_custom_form">
                   <?php wp_nonce_field( 'handle_custom_form_action', 'handle_custom_form_nonce' ); ?>
                </form>
            </div>
        </div>
    </div>
</div>