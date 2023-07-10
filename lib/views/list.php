<?php 
    session_start();
    $cpta_delete_success = $_SESSION['cpta_delete_success'] ?? false;
    $cpta_delete_fail = $_SESSION['cpta_delete_fail'] ?? false;
    unset($_SESSION['cpta_delete_success']);
    unset($_SESSION['cpta_delete_fail']);
?>
<div class="wrap cpta-listing-page">
    <h1 class="wp-heading-inline">CPT Listing</h1>
    <a href="<?php echo admin_url()?>admin.php?page=add-new-cpt" class="page-title-action">Add New Post Type</a>
    <div class="alert cpta-delete-success <?php echo ($cpta_delete_success) ? '' : 'cpta-hidden' ?>">
        <?php echo ($cpta_delete_success) ? $cpta_delete_success : '' ?>
    </div>
    <div class="alert cpta-delete-fail <?php echo ($cpta_delete_fail) ? '' : 'cpta-hidden' ?>">
        <?php echo ($cpta_delete_fail) ? $cpta_delete_fail : '' ?>
    </div>
	<div class="bg-white cpta-list-box">
		<div class="ai1wm-left">
            <table id="myTable" class="striped widefat">
                <thead>
                <tr>
                    <th>Slug</th>
                    <th>Singular Label</th>
                    <th>Plural Label</th>
                    <th>Menu Position</th>
                    <th>Menu Icon</th>
                    <th>Action</th>
                 </tr>
                </thead>
                <tbody>
                    <?php 
                    if(count($data['data'])){
                    foreach ($data['data'] as $key=>$value){ 
                    ?>
                    <tr>
                        <td><?php echo $value->slug ?></td>
                        <td><?php echo $value->singular ?></td>
                        <td><?php echo $value->plural ?></td>
                        <td><?php echo $value->menu_position ?></td>
                        <td><i class="dashicons <?php echo $value->menu_icon ?>"></i></td>
                        <td>
                            <a href=""><i class="dashicons dashicons-edit"></i></a>
                            <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                                <i class="dashicons dashicons-trash cpta-delete-btn"></i>
                                <input type="hidden" name="action" value="delete_custom_posttype">
                                <input type="hidden" name="id" value="<?php echo $value->id; ?>">
                                <input type="hidden" name="slug" value="<?php echo $value->slug; ?>">
                                <?php wp_nonce_field( 'delete_custom_posttype_action', 'delete_custom_posttype_nonce' ); ?>
                            </form>
                        </td>
                    </tr>
                    <?php }}else { ?>
                    <tr>
                        <td colspan="6">
                            <p style="text-align:center">No post type found</p>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
	</div>
</div>
