<?php 

if( !function_exists('ive_select_html') ){
	function ive_select_html( $items, $args  = array() )
	{
		$attributes = false;

		if( isset($args['attributes']) ){

			if( is_array($args['attributes']) ){
				$attributes = array();

				foreach( $args['attributes'] as $key=>$value ){
					$attributes[] = "$key='$value'";
				}

				$attributes = implode(' ', $attributes);
			}
		}

		printf( '<select id="%s" name="%s" %s>', isset($args['id']) ? $args['id'] : '', $args['name'], $attributes );
			$unselect_first = '<option value=""></option>';
			
			if( isset($args['select_first']) && $args['select_first'])
				$unselect_first = "";

			echo $unselect_first;

			if( $items ) foreach ($items as $value => $item) {
				printf('<option value="%s" %s %s>%s</option>', 
					$value, 
					isset($args['value']) && $value == $args['value'] ? 'selected="selected"' : '',
					isset($item['attributes']) ? $item['attributes'] : '',
					$item['label']
				);
			}
		echo '</select>';
	}
}