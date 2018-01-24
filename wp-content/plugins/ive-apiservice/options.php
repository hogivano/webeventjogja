<?php 
global $IVE_API_Service_Options;

$IVE_API_Service_Options = new IVE_API_Service_Options;

class IVE_API_Service_Options 
{
	var $option_group = 'ive_api_service_options';

	function __construct()
	{
		add_action( 'admin_init', array( &$this, 'admin_init') );
		add_action( 'admin_notices', array( &$this, 'admin_notices' ) );
		add_action( 'admin_head', array( &$this, 'admin_head' ) );
		add_action( 'admin_enqueue_scripts', array( &$this, 'admin_enqueue_scripts' ) );
	}

	function get_option($key = null)
	{
		$options = get_option($this->option_group);

		if( $key ){
			if( isset($options[$key]) )
				return $options[$key];

			return;
		}

		return $options;
	}

	function admin_head() 
	{
		echo '<style>.content-tab{display:none}.content-tab-active{display:block}</style>';
	}

	function admin_notices() 
	{
		// if( $_GET['page'] == 'theme-option' && $_GET['settings-updated'] == 'true' )
			// echo '<div class="updated"><p>'.__('Theme setting has been saved', 'dp-simplify').'</p></div>';
	}

	function admin_enqueue_scripts()
	{
		$theme_url = get_template_directory_uri();

		// wp_enqueue_style( 'wp-bootstrap', $theme_url . '/css/wp-bootstrap.min.css' );
		// wp_enqueue_script( 'bootstrap-script', $theme_url . '/js/bootstrap.min.js', array('jquery'), '1.0.0', true );
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'jquery-ui-sortable' );
	}

	function admin_init() 
	{  
		register_setting( $this->option_group, $this->option_group );
	}


	function get_link_type_item_select(){
		$return = array(
			'url' => array(
				'label' => "URL",
				'attributes' => 'data-placeholder="Enter URL"',
			),
			'post_detail' => array(
				'label' => "Post Detail",
				'attributes' => 'data-placeholder="Enter post ID"',
			),
			'event_detail' => array(
				'label' => "Event Detail",
				'attributes' => 'data-placeholder="Enter event ID"',
			),
			'event_category' => array(
				'label' => "Event Category",
				'attributes' => 'data-placeholder="Enter event category ID"',
			),
			'event_tag' => array(
				'label' => "Event Tag",
				'attributes' => 'data-placeholder="Enter event tag ID"',
			),
		);

		return $return;
	}

	
	function option_page() 
	{
		// add_action( 'admin_footer', array( &$this, 'admin_footer') );

		$options = get_option($this->option_group);

		$link_type_items = $this->get_link_type_item_select();
?>


<div class="wrap"> 
	<h2>API Setting</h2>

	<form method="post" action="options.php">
		<?php settings_fields( $this->option_group ); ?>
		<?php do_settings_sections( $this->option_group ); ?>

		<h3>Email Pengaduan</h3>
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><label for="email_pengaduan">Email Pengaduan</label></th>
				<td>
					<input placeholder="Tujuan email pengaduan" type="text" id="email_pengaduan" class="regular-text" name="<?php echo $this->option_group; ?>[email_pengaduan]" value="<?php echo isset($options['email_pengaduan']) ? esc_attr( $options['email_pengaduan'] ) : ""; ?>" />
				</td>
			</tr>
		</table>

		<h3>Popup Banner</h3>
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><label for="popup_banner_image">Enabled</label></th>
				<td>
					<input type="checkbox" value="1" name="<?php echo $this->option_group; ?>[popup_banner_enable]" <?php checked(isset($options['popup_banner_enable']) ? $options['popup_banner_enable'] : false ) ?>>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="popup_banner_image">Image URL</label></th>
				<td>
					<input placeholder="Image URL" type="text" id="popup_banner_image" class="large-text" name="<?php echo $this->option_group; ?>[popup_banner][image]" value="<?php echo isset($options['popup_banner']['image']) ? esc_attr( $options['popup_banner']['image'] ) : ""; ?>" />
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><label>Banner Link</label></th>
				<td>
					<?php ive_select_html($link_type_items, array(
						'name' => $this->option_group . "[popup_banner][link_to]",
						'value' => isset($options['popup_banner']['link_to']) ? $options['popup_banner']['link_to'] : false,
						'select_first' => true,
						'attributes' => array(
							'data-select_link_type' => '',
						)
					)) ?>
					<input type="text" class="regular-text" name="<?php echo $this->option_group; ?>[popup_banner][link_target]" value="<?php echo isset($options['popup_banner']['link_target']) ? esc_attr( $options['popup_banner']['link_target'] ) : ""; ?>">
				</td>
			</tr>
		</table>


		<style>
		.move-hilight {
			border: 2px dashed #ddd;
		}
		</style>

		<h3>Slider Image</h3>
		<p class="desciription">Recomended size 500(px) x 250(px)</p>
		<table class="form-table">
			<tbody class="slider-items">
				<?php for ($i=0; $i < 5; $i++) { ?>
				<tr valign="top">
					<th scope="row" data-action="panel-move">
						<label for="slide_<?php echo $i ?>">Slide #<?php echo $i + 1 ?></label>
					</th>
					<td>
						<p><input placeholder="Slider Title" type="text" id="slide_<?php echo $i ?>" class="regular-text" name="<?php echo $this->option_group; ?>[slider_image][<?php echo $i ?>][label]" value="<?php echo isset($options['slider_image'][$i]['label']) ? esc_attr( $options['slider_image'][$i]['label'] ) : ""; ?>" style="min-width: 535px" /></p>
						<p><input placeholder="Image URL" type="text" class="large-text" name="<?php echo $this->option_group; ?>[slider_image][<?php echo $i ?>][image]" value="<?php echo isset($options['slider_image'][$i]['image']) ? esc_attr( $options['slider_image'][$i]['image'] ) : ""; ?>" /></p>
						Link to: 
						<?php ive_select_html($link_type_items, array(
							'name' => $this->option_group . "[slider_image][{$i}][link_to]",
							'value' => isset($options['slider_image'][$i]['link_to']) ? $options['slider_image'][$i]['link_to'] : false,
							'select_first' => true,
							'attributes' => array(
								'data-select_link_type' => '',
							)
						)) ?>

						<input type="text" class="regular-text" name="<?php echo $this->option_group; ?>[slider_image][<?php echo $i ?>][link_target]" value="<?php echo isset($options['slider_image'][$i]['link_target']) ? esc_attr( $options['slider_image'][$i]['link_target'] ) : ""; ?>">

					</td>
				</tr>

				<?php } ?>
			</tbody>
		</table>
	
		
		<?php submit_button(); ?>
	</form>
</div>
		<?php 


		 ?>

		<script type="text/javascript">
		jQuery(document).ready(function($) {
			$('[data-select_link_type]').change(function(event) {
				var placeholder = $(':checked', $(this)).data('placeholder');

				$(this).next().attr('placeholder', placeholder);
			}).change();



			var container = ".slider-items";

			$( container ).sortable({
				revert: 200,
				placeholder: "move-hilight",
				handle: "[data-action=panel-move]",
				// containment: "body",
				// Find about shortable area
				start: function( event, ui ){
					ui.placeholder.css({
						'height': ui.item.height(),
						'margin-bottom': parseInt(parseInt(ui.item.css('margin-bottom')) + 2) + 'px',
					});
				},
				stop: function( event, ui ) {
					var field_sort = $(this).sortable('toArray');

					field_sort.forEach(function(d, index) {
						var row_container = $('> *', container)[index];
						var inputs = $('[name]', row_container);

						console.log(row_container);

						$(inputs).each(function(i, el) {
							var name = $(el).attr('name');
							var name_replace = name;
							var match = name_replace.match('\\[[0-9]*\]');

							if( typeof match[0] !== 'undefined' ){
								name_replace = name.replace(match[0], '['+index+']');
							}

							$(el).attr('name', name_replace);

						});
						// console.log(inputs);

						// console.log(row_container);
						// var element = $('> *', container)[p];
						// $('.fieldOrder', element).val(p);
					});
				}
			});
		});
		</script>



		<?php 
	}


	function select_page( $args )
	{
		$items = get_posts('post_type=page&posts_per_page=-1&orderby=post_title&order=asc');

		printf( '<select id="%s" name="%s">', $args['id'], $args['name'] );
			echo '<option>- Select -</option>';
			if( $items ) foreach ($items as $item) {
				printf('<option value="%s"%s>%s</option>', 
					$item->ID, 
					$item->ID == $args['value'] ? ' selected="selected"' : '',
					$item->post_title
				);
			}
		echo '</select>';
	}

	function select_category( $args )
	{
		$defaults = array(
			'id' => '',
			'name' => '',
			'value' => '',
			'with_child' => false,
		);
		$args = wp_parse_args( $args, $defaults );

		$term_type = 'category';
		$items = get_terms( $term_type, array( 
			'parent' => 0,
			'hide_empty' => false,
		) ); 

		printf( '<select id="%s" name="%s">', $args['id'], $args['name'] );
			echo '<option>- Select -</option>';
			$level = 0;

			if( $items ) foreach ($items as $item) {
				printf('<option value="%s"%s>%s</option>', 
					$item->term_id, 
					$item->term_id == $args['value'] ? ' selected="selected"' : '',
					$item->name
				);
				if( $args['with_child'] ) $this->select_category_child( $args, $item->term_id, $level );
			}
		echo '</select>';
	}

	function select_category_child( $args, $parent, $level )
	{
		$term_type = 'category';
		$items = get_terms( $term_type, array( 
			'parent' => $parent,
			'hide_empty' => false,
		) ); 
		
		if( $items ) foreach ($items as $item) {
			$level = $level + 1;

			printf('<option value="%s"%s>%s</option>', 
				$item->term_id, 
				$item->term_id == $args['value'] ? ' selected="selected"' : '',
				str_repeat("&#8212; ", $level) . $item->name
			);
			$this->select_category_child( $args, $item->term_id, $level );
		}
	}

	function select_bootstrap_icon( $args )
	{
		$items = array('asterisk','plus','euro','minus','cloud','envelope','pencil','glass','music','search','heart','star','star-empty','user','film','th-large','th','th-list','ok','remove','zoom-in','zoom-out','off','signal','cog','trash','home','file','time','road','download-alt','download','upload','inbox','play-circle','repeat','refresh','list-alt','lock','flag','headphones','volume-off','volume-down','volume-up','qrcode','barcode','tag','tags','book','bookmark','print','camera','font','bold','italic','text-height','text-width','align-left','align-center','align-right','align-justify','list','indent-left','indent-right','facetime-video','picture','map-marker','adjust','tint','edit','share','check','move','step-backward','fast-backward','backward','play','pause','stop','forward','fast-forward','step-forward','eject','chevron-left','chevron-right','plus-sign','minus-sign','remove-sign','ok-sign','question-sign','info-sign','screenshot','remove-circle','ok-circle','ban-circle','arrow-left','arrow-right','arrow-up','arrow-down','share-alt','resize-full','resize-small','exclamation-sign','gift','leaf','fire','eye-open','eye-close','warning-sign','plane','calendar','random','comment','magnet','chevron-up','chevron-down','retweet','shopping-cart','folder-close','folder-open','resize-vertical','resize-horizontal','hdd','bullhorn','bell','certificate','thumbs-up','thumbs-down','hand-right','hand-left','hand-up','hand-down','circle-arrow-right','circle-arrow-left','circle-arrow-up','circle-arrow-down','globe','wrench','tasks','filter','briefcase','fullscreen','dashboard','paperclip','heart-empty','link','phone','pushpin','usd','gbp','sort','sort-by-alphabet','sort-by-alphabet-alt','sort-by-order','sort-by-order-alt','sort-by-attributes','sort-by-attributes-alt','unchecked','expand','collapse-down','collapse-up','log-in','flash','log-out','new-window','record','save','open','saved','import','export','send','floppy-disk','floppy-saved','floppy-remove','floppy-save','floppy-open','credit-card','transfer','cutlery','header','compressed','earphone','phone-alt','tower','stats','sd-video','hd-video','subtitles','sound-stereo','sound-dolby','sound-5-1','sound-6-1','sound-7-1','copyright-mark','registration-mark','cloud-download','cloud-upload','tree-conifer','tree-deciduous');

		printf( '<select id="%s" name="%s" class="form-control">', $args['id'], $args['name'] );
			echo '<option value="">- Select -</option>';
			if( $items ) foreach ($items as $item) {
				printf('<option value="%1$s"%2$s class="glyphicon-%1$s" style="font-family: Glyphicons Halflings"> %1$s</option>', 
					$item, 
					$item == $args['value'] ? ' selected="selected"' : ''
				);
			}
		echo '</select>';
	}

}
	
