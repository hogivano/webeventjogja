<?php 

class IVE_API_Service_Executor
{
	var $output = array();
	var $output_success = false;
	var $output_results = false;

	function execute()
	{
		status_header(200);

		global $post;

		if( $action_method = $this->input_get('method') ){
			$this->actionMethod($action_method);
		} else {
			$this->actionGet();
		}

		$this->readExtra();
		
		if( $this->output_success == false && (!isset($this->output['message']) || !$this->output['message']) ){
			$this->output['message'] = 'Request can\'t understanding';
		}

		$output_type = $this->input_get('output') ? $this->input_get('output') : 'json';
		$this->show_output($output_type);
	}

	# ----------------------------------------------
	# Read other request method
	# ----------------------------------------------
	
	function actionMethod($action_method){
		$func_name = array(&$this, 'actionMethod_' . $action_method);

		if( is_callable( $func_name ))
			call_user_func($func_name);
	}

	function actionMethod_pengaduan_event(){

		global $IVE_API_Service_Options;
		$email_pengaduan = $IVE_API_Service_Options->get_option('email_pengaduan');

		// $nama = $this->input_get('nama');
		$event_id = $this->input_get('event_id');
		$pengaduan = $this->input_get('pengaduan');

		if( !$event_id ){
			$this->output_success = false;
			$this->output['message'] = "Tidak ada event yang dipilih";
			return;
		}

		if( !$pengaduan ){
			$this->output_success = false;
			$this->output['message'] = "Konten pengaduan masih kosong";
			return;
		}

		// file_put_contents("G:/test.txt", date("Y/m/d H:i:s", current_time('timestamp')) . "    " . 
		// 	print_r($_GET, true) . PHP_EOL . PHP_EOL, FILE_APPEND);

		$event_detail = get_posts(array(
			'post__in' => array((int)$event_id),
			'post_type' => 'event',
			'posts_per_page' => 1,
		));

		if( !$event_detail ){
			$this->output_success = false;
			$this->output['message'] = "Event tidak ditemukan atau sudah berakhir";
			return;
		}

		$event_detail = $event_detail[0];

		$mail_title = "Pengaduan Event - " . $event_detail->post_title; 
		$mail_body = $event_detail->post_title . "\n--------------------------------------------\n" . $pengaduan; 

		$send_mail = wp_mail( $email_pengaduan, $mail_title,  $mail_body);

		if( $send_mail ){
			$this->output_success = true;
			$this->output['message'] = "Pengaduan telah berhasil dikirim.";
		} else {
			$this->output_success = false;
			$this->output['message'] = "Gagal mengirim pengaduan, coba lagi setelah beberapa menit.";
		}

	}

	function actionMethod_get_notification(){
		global $post;

		$last_receive = $this->input_get('last_receive');

		$args = array(
			'post_type' => 'notification',
			'posts_per_page' => 1,
		);

		if( $last_receive ){
			$last_receive = date('Y-m-d H:i:s', strtotime($last_receive));

			$args['date_query'] = array(
				array(
					'after' => $last_receive,
				),
			);
		}
		global $wp_query;

		query_posts($args);
		
		$this->output_results = array();

		$output = array();
		$this->output['available'] = false;

		if( have_posts() ) {
			while( have_posts() ): the_post();
				// $output_item = $this->get_output_list_item();
				// $this->output_results[] = $output_item;

				$_content = $post->post_content;
				$_content = maybe_unserialize($_content);

				$this->output['available'] = true;

				$output['id'] = get_the_ID();
				$output['datetime'] = get_the_date('Y-m-d H:i:s');
				$output['title'] = html_entity_decode(get_the_title());
				$output['content'] = isset($_content['message']) ? $_content['message'] : "";

				$link_detail = array();

				if( isset($_content['link_to']) && isset($_content['link_target']) ){
					$link_detail['link_to'] = $_content['link_to'];
					$link_detail['link_target'] = $_content['link_target'];
				}

				$output['link_detail'] = $link_detail;

			endwhile;
		}

		wp_reset_query();

		if( $output && $output['link_detail'] ){
			$the_link_detail = $this->get_link_detail($output['link_detail']['link_to'], $output['link_detail']['link_target']);
			$output['link_detail'] = array_merge($output['link_detail'], $the_link_detail);
		}

		$this->output_results = $output;

		$this->output_success = true;
	}


	# ----------------------------------------------
	# Read for list wp_post and detail
	# ----------------------------------------------

	function actionGet(){
		$allowed_post_type = array( 'post', 'event' );

		$param_get = $this->input_get('get');
		$param_post_type = $this->input_get('type') ? $this->input_get('type') : 'post';
		$param_post_id = $this->input_get('detail_id') ? (int)$this->input_get('detail_id') : 0;
		$param_category = $this->input_get('category');

		$param_event_category = $this->input_get('event_category');
		$param_event_tag = $this->input_get('event_tag');

		$param_paged = $this->input_get('paged');
		$param_item_per_page = $this->input_get('item_per_page');
		$param_search = $this->input_get('search');
		$param_active_event = $this->input_get('active_event');

		$param_order = $this->input_get('order');
		$param_orderby = $this->input_get('orderby');

		$param_list_all = $this->input_get('list_all');


		if( !in_array($param_post_type, $allowed_post_type))
			return;

		switch ( $param_get ):
			case 'list': // -------- LIST POSTS
				
				$this->output_success = true;
				$this->output_results = array();

				## Setup POST TYPE
				$args = array();
				$args['post_type'] = $param_post_type;

				if( $param_paged )
					$args['paged'] = $param_paged;

				if( $param_item_per_page )
					$args['posts_per_page'] = $param_item_per_page;

				if( $param_list_all )
					$args['posts_per_page'] = -1;

				if( $param_orderby )
					$args['orderby'] = $param_orderby;

				## Setup TAXONOMY TYPE FOR CATEGORY
				$taxonomy = null;

				if( $param_category ){
					if( $args['post_type'] == 'post' ) {
						$taxonomy = 'category';
						$taxonomy_value = $param_category;

					} elseif( $args['post_type'] == 'event' ){
						$taxonomy = 'event_category';
						$taxonomy_value = $param_category;
					}
				}

				if( $param_event_category )
				{
					$taxonomy = 'event_category';
					$taxonomy_value = $param_event_category;
				}

				if( $param_event_tag )
				{
					$taxonomy = 'event_tag';
					$taxonomy_value = $param_event_tag;
				}


				## Setup POST TERM
				if( $taxonomy )
				{
					$args['tax_query'] = array(
						array(
							'taxonomy' => $taxonomy,
							'field'    => 'slug',
							'terms'    => $taxonomy_value,
						),
					);
				}

				## Setup SEARCH
				if( $param_search ){
					$args['s'] = $param_search;
				}

				if( $args['post_type'] == 'event' && $param_active_event ){


					$the_day = array();

					if( $param_active_event == 'this_week' ){

						$this_day = strtolower( date('l') );

						if( $this_day == 'monday' )
							$start_date = date('d-m-Y');
						else
							$start_date = date('d-m-Y',strtotime('last monday'));

						$start_capture = false;

						for ($i=0; $i < 7; $i++) { 
							$the_date = date('d-m-Y', strtotime($start_date . ' + ' . $i . ' day'));

							if( date('d-m-Y') == $the_date){
								$the_day[] = $the_date;
								$start_capture = true;
							} elseif( $start_capture ){
								$the_day[] = $the_date;
							}
						}

					} else {
						$the_day = $param_active_event;
					}

					$args['meta_key'] = '_dp_active_event';
					$args['meta_value'] = $the_day;
				}

				// for ($i=0; $i < 10; $i++) { 
				// var_dump($args);

				query_posts($args);

				if( have_posts() ) {
					while( have_posts() ): the_post();
						$output_item = $this->get_output_list_item();

						$this->output_results[] = $output_item;

					endwhile;
				}

				wp_reset_query();
				// }

				break;

			case 'detail': // -------- DETAIL POSTS

				$args = array();

				$args['p'] = $param_post_id;
				$args['post_type'] = $param_post_type;

				query_posts($args);

				if( have_posts() ) {
					$this->output_success = true;
					$this->output_results = array();

					while( have_posts() ): the_post();

						// $this->output_results = array(
						// 	'id' => get_the_ID(),
						// 	'type' => get_post_type(),
						// 	'slug' => $post->post_name,
						// 	'datetime' => get_the_date('Y/m/d H:i:s'),
						// 	'title' => html_entity_decode(get_the_title()),
						// 	'content_html' => apply_filters('the_content', get_the_content()),
						// );

						$this->output_results = $this->get_output_list_item();

						$param_content = $this->input_get('content');
						$param_content = $param_content ? $param_content : 'html';
						$param_content = explode('|', $param_content);
	
						if( in_array('html', $param_content) )
							$this->output_results['content_html'] = apply_filters('the_content', get_the_content());

						if( in_array('images', $param_content) )
							$this->output_results['content_images'] = $this->get_content_images(get_the_content());

						$this->output_results = array_merge($this->output_results, $this->get_thumbnails(get_the_ID()) );

						if( get_post_type() == 'event' ){
							$active_event = $this->get_active_event(get_the_ID());
							$this->output_results = array_merge($this->output_results, $active_event);
						}

						$this->output_results['similar'] = $this->get_similar( get_the_ID() );

					endwhile;

				} else {
					$this->output_success = false;

					if( $param_post_type == "event"){
						$this->output['message'] = 'Event tidak ditemukan, mungkin event ini sudah berakhir';
					} else {
						$this->output['message'] = 'Content not found';
					}

				}
				wp_reset_query();
				
				break;

		endswitch;
	}


	# ----------------------------------------------
	# Read Extra Parameter
	#
	# Extra parameter hanya akan dikeluarkan jika
	# $this->output_success == true
	# ----------------------------------------------

	function readExtra(){
		
		if( $this->output_success != true )
			return;

		$param_extra = $this->input_get('extra');

		$extras = explode('|', $param_extra);

		for ($i=0; $i < count($extras); $i++) { 
			$func_name = array(&$this, 'readExtra_' . $extras[$i]);

			if( is_callable( $func_name ))
				call_user_func($func_name);
		}
	}

	function readExtra_slider(){
		global $IVE_API_Service_Options;

		$slider_option = $IVE_API_Service_Options->get_option('slider_image');

		$sliders = array();

		for ($i=0; $i < count($slider_option); $i++) { 
			if( $slider_option[$i]['image'] ){

				$link_type = $slider_option[$i]['link_to'];
				$link_target = $slider_option[$i]['link_target'];
				$sliders[] = array_merge($slider_option[$i], $this->get_link_detail($link_type, $link_target));

			}
		}

		$this->output['slider'] = $sliders;
	}

	function readExtra_popup_banner(){
		global $IVE_API_Service_Options;
		$banner_enabled = $IVE_API_Service_Options->get_option('popup_banner_enable');
		$banner_detail = $IVE_API_Service_Options->get_option('popup_banner');

		$banner = array(
			'available' => false,
		);

		if( $banner_enabled ){
			$banner['available'] = true;
		
			$link_type = $banner_detail['link_to'];
			$link_target = $banner_detail['link_target'];
			$link_detail = $this->get_link_detail($link_type, $link_target);

			$banner['detail'] = array_merge($banner_detail, $link_detail);
		}

		$this->output['popup_banner'] = $banner;
	}









	# ----------------------------------------------
	# REQUIRED Function
	# ----------------------------------------------


	function get_similar( $ID ){
		global $post;

		$post_type = get_post_type($ID);

		$term_type = $post_type == 'event' ? 'event_category' : 'category';

		$categories = get_the_terms( get_the_ID(), $term_type ); 
		
		$post_in_cat = array();
		if( $categories ) foreach ($categories as $item) {
			$post_in_cat[] = $item->term_id;
		}

		$similar_args = array(
			'post_type' => $post_type,
			'posts_per_page' => 5,
			'orderby' => 'rand',

			'post__not_in' => array( $ID ),
			'tax_query' => array(
				array(
					'taxonomy' => $term_type,
					'terms'    => $post_in_cat,
				),
			),
		);

		if( $post_type == 'event' ){
			# Similar event dengan active_event 30 hari kedepan

			for ($i=0; $i < 30; $i++) {
				$the_date = date('d-m-Y', strtotime(' + ' . $i . ' day'));	
				$the_day[] = $the_date;
			}

			$similar_args = array_merge($similar_args, array(
				'meta_key'     => '_dp_active_event',
				'meta_value'   => $the_day,
			));
		}

		$results = array();

		$similars = get_posts( $similar_args );
		if( $similars ) foreach( $similars as $post ) :
			setup_postdata($post);

			$results[] = $this->get_output_list_item();
		endforeach;

		wp_reset_postdata();

		return $results;
	}


	function get_content_images($content){

		$content_images = array();
		
		require_once( dirname( __FILE__ ) . '/class/simple_html_dom.php');

		if( $content ){
			$content_images_html = str_get_html($content);

			$images = $content_images_html->find('img');
			if( $images ) foreach ($images as $image) {
				$content_images[] = array(
					'title' => $image->getAttribute('alt'),
					'url' => $image->getAttribute('src'),
				);
			}
			
		}

		return $content_images;
	}

	function get_output_list_item(){
		global $post;

		$post_type = get_post_type();

		$output_item = array(
			'id' => get_the_ID(),
			'type' => get_post_type(),
			'slug' => $post->post_name,
			'datetime' => get_the_date('Y-m-d H:i:s'),
			'title' => html_entity_decode(get_the_title()),
			'excerpt' => get_the_excerpt(),
		);
		$output_item = array_merge($output_item, $this->get_thumbnails(get_the_ID()) );

		$category_taxonomy = "";

		## Setup TAXONOMY TYPE FOR CATEGORY
		if( $post_type == 'post' ) {
			$category_taxonomy = 'category';
		} elseif( $post_type == 'event' ){
			$category_taxonomy = 'event_category';
		}

		if( $category_taxonomy ){
			# Category Object List
			$output_item['category'] = wp_get_post_terms( get_the_ID(), $category_taxonomy, array() );

			## Category Text
			$category_texts = array();
			if( $output_item['category'] ) foreach ($output_item['category'] as $item) {
				$category_texts[] = $item->name;
			}
			$output_item['category_text'] = implode(', ', $category_texts);

			## Active Event Date
			if( $post_type == 'event' ){
				$active_event = $this->get_active_event(get_the_ID());
				$output_item = array_merge($output_item, $active_event);
			}
		}

		return $output_item;
	}

	function get_thumbnails($ID)
	{

		$thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $ID ), 'thumbnail' );
		$thumbnail = $thumbnail ? $thumbnail[0] : "";

		$thumbnail_medium = wp_get_attachment_image_src( get_post_thumbnail_id( $ID ), 'medium' );
		$thumbnail_medium = $thumbnail_medium ? $thumbnail_medium[0] : "";

		$thumbnail_large = wp_get_attachment_url( get_post_thumbnail_id( $ID ) );
		$thumbnail_large = $thumbnail_large ? $thumbnail_large : "";

		return array(
			'thumbnail' => $thumbnail,
			'thumbnail_medium' => $thumbnail_medium,
			'thumbnail_large' => $thumbnail_large,
		);
	}

	function get_active_event($ID)
	{
		$return = array(
			'active_event' => array(),
			'active_event_text' => "",
		);

		$active_event = get_post_meta($ID, '_dp_active_event');

		if( $active_event ){
			$return['active_event'] = $active_event;

			if( count($return['active_event']) > 1 ){
				$first_active_event = $return['active_event'][0];
				$last_active_event = end($return['active_event']);

				$return['active_event_text'] = 
					date('d M Y', strtotime($first_active_event)) . 
					' - ' . 
					date('d M Y', strtotime($last_active_event));

			} else {
				$return['active_event_text'] = date('d M Y', strtotime(end($return['active_event'])));
			}
		}
		return $return;
	}


	/**
	 * get_link_detail
	 * 
	 * @return (array)
	 */
	
	function get_link_detail($link_to, $link_target){
		$return = array();

		switch ( $link_to ):
			case 'event_category':
				$target_detail = get_term($link_target, 'event_category');
				
				if( $target_detail != null ){
					$target_detail = array(
						'title' => $target_detail->name,
						'slug' => $target_detail->slug,
					);
					$return = $target_detail;
				}
				break;

			case 'event_tag':
				$target_detail = get_term($link_target, 'event_tag');
				
				if( $target_detail != null ){
					$target_detail = array(
						'title' => $target_detail->name,
						'slug' => $target_detail->slug,
					);
					$return = $target_detail;
				}
				break;

			case 'event_detail':
				query_posts(array(
					'p' => $link_target,
					'post_type' => 'event'
				));

				$target_detail = array();

				if( have_posts() ) while( have_posts() ): the_post();
					$target_detail = $this->get_output_list_item();
				endwhile;

				wp_reset_query();

				$return = $target_detail;
				break;
			
			case 'post_detail':
				query_posts(array(
					'p' => $link_target,
					'post_type' => 'post'
				));

				$target_detail = array();

				if( have_posts() ) while( have_posts() ): the_post();
					$target_detail = $this->get_output_list_item();
				endwhile;

				wp_reset_query();

				$return = $target_detail;
				break;
			
		endswitch;

		return $return;
	}

	function show_output( $format = 'json' )
	{
		$output = array(
			'success' => $this->output_success,
		);
			
		if( $this->output_results !== false ){
			$output['results'] = $this->output_results;
		}

		$output = array_merge($output, $this->output);

		$format = strtolower($format);

		header('Cache-Control: max-age=0'); //no cache
		switch ($format) {
			case 'pre':
				echo '<pre>' . print_r($output, true) . '</pre>';
				break;

			case 'dump':
				var_dump($output);
				break;
			
			default:
				header("Content-type: application/json");
				echo json_encode($output);
				break;
		}
		if( $format == 'json' ){
			
		} else {
			
		}
	}


	function input_get($arg){
		return isset( $_GET[$arg] ) ? $_GET[$arg] : null;
	}

}