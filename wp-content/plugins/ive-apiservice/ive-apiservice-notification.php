<?php 
new IVE_API_Service_Notification;

class IVE_API_Service_Notification
{
	var $post_type = 'notification';

	function __construct()
	{
		add_action( 'init', array(&$this, 'init') );
		add_action( 'add_meta_boxes', array(&$this, 'add_meta_boxes') );
		add_action( 'save_post', array(&$this, 'content_meta_box_save') ); 
	}

	function init() {
		// Notification
		$labels = array(
			'name' => __('Notifications', 'ive_apiservice' ),
			'singular_name' => __('Notification', 'ive_apiservice' ),
			'add_new' => __('New Notification', 'ive_apiservice' ),
			'add_new_item' => __('Add New Notification', 'ive_apiservice' ),
			'edit_item' => __('Edit Notification', 'ive_apiservice' ),
			'new_item' => __('New Notification', 'ive_apiservice' ),
			'view_item' => __('View Notification', 'ive_apiservice' ),
			'search_items' => __('Search Notification', 'ive_apiservice' ),
			'not_found' =>  __('Nothing found.', 'ive_apiservice' ),
			'not_found_in_trash' => __('There is no item in trash.', 'ive_apiservice' ),
			'parent_item_colon' => ''
		);
		$args = array(
			'labels' => $labels,
			'public' => false,
			'publicly_queryable' => false,
			'show_ui' => true,
			'query_var' => false,
			'capability_type' => 'post',
			'hierarchical' => false,
			'menu_position' => 100,
			'supports' => array('title'),
			'menu_icon' => 'dashicons-media-code',
			// 'show_in_menu' => 'admin.php?page=ive-api-setting',
			'show_in_menu' => 'ive-api-service',
		); 

		register_post_type( $this->post_type , $args );
	}

	function add_meta_boxes() {
		$screens = array( $this->post_type );

		foreach ($screens as $screen) {
			add_meta_box( 'content_meta_box', __( 'Notification Details' ), array( &$this, 'content_custom_box'), $screen, 'normal', 'high' );
		}
	}

	function content_custom_box( $post ) {  
		global $post, $IVE_API_Service_Options;

		// var_dump(get_post_meta($post->ID, '_the_content', true) );

		$link_type_items = $IVE_API_Service_Options->get_link_type_item_select();

		$_content = $post->post_content;
		$_content = maybe_unserialize($_content);

		wp_nonce_field( 'content_meta_box_nonce', 'meta_box_nonce' );
		?>
		<style>
		textarea.fix-size {
			height: 100px!important; 
			max-width: 99%!important; 
			min-width: 99%!important;
			width: 99%!important; 
		}
		</style>

		<table class="form-table">
			<tbody>
				<tr>
					<th>Message</th>
					<td>
						<textarea type="text" class="large-text fix-size" name="_content[message]" style=""><?php echo isset($_content['message']) ? $_content['message'] : '' ?></textarea>
					</td>
				</tr>
				<tr>
					<th>Link Type</th>
					<td>
						<?php ive_select_html($link_type_items, array(
							'id' => 'link_to',
							'name' => '_content[link_to]',
							'value' => isset($_content['link_to']) ? $_content['link_to'] : false,
							'select_first' => true,
							'attributes' => array(
								'data-select_link_type' => '',
							)
						)) ?>
					</td>
				</tr>
				<tr>
					<th>Link Target</th>
					<td>
						<input type="text" class="large-text" name="_content[link_target]" value="<?php echo isset($_content['link_target']) ? esc_attr( $_content['link_target'] ) : ""; ?>">
						<p class="description" id="link_target_placeholder"></p>
					</td>
				</tr>
				
			</tbody>
		</table>


		<script type="text/javascript">
		jQuery(document).ready(function($) {
			$('#link_to').change(function(event) {
				var placeholder = $(':checked', $(this)).data('placeholder');


				$('#link_target_placeholder').html(placeholder);
			}).change();
		});
		</script>

		<?php
	}


	function content_meta_box_save( $post_id ) {  
		if( get_post_type($post_id) == $this->post_type )
		{
			if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return; 

			if( !isset( $_POST['meta_box_nonce'] ) || !wp_verify_nonce( $_POST['meta_box_nonce'], 'content_meta_box_nonce' ) ) return; 

			if( !current_user_can( 'edit_post' ) ) return;  

			
			if ( isset($_POST['_content']) ){
				// Fix Save Post Looping
				remove_action( 'save_post', array(&$this, 'content_meta_box_save') );

				update_post_meta($post_id, '_the_content', $_POST['_content']);

				$content = $_POST['_content'];
				// $content = stripslashes_deep($_POST['_content']);

				$content = wp_unslash($content);
				$content = maybe_serialize($content);

				#--- Base update script very required!

				global $wpdb;
				$wpdb->update($wpdb->posts, array('post_content' => $content), array('ID' => $post_id), array( '%s' ), array( '%d' ));
			}

		}	
	}
}