<?php 


class IVE_API_Service_Additional
{

	function __construct()
	{
		add_filter( 'query_vars', array( &$this, 'disable_wordpress_query_vars' ), 10, 1 );
		// add_action( 'pre_get_posts', array( &$this, 'pre_get_posts' ) );
	}

	function disable_wordpress_query_vars( $qvars ) {
		// fix wordpress default redirect to paged site.com/page/2?api&...
	 	$qvars = array();
		return $qvars;
	}

	/*
	function pre_get_posts($query){
		// var_dump($query);
		// var_dump($query->is_main_query());

		if( $query->is_main_query() )
		{
			// set_query_var('page_id', 0);
			// set_query_var('paged', false); // fix wordpress default redirect to paged site.com/page/2?api&...
			// set_query_var('event_tag', false);
			// set_query_var('event_category', false);

			if( isset($_GET['e']) )
			{
				// set_query_var('page_id', 0);
				// set_query_var('paged', false);
				// set_query_var('event_tag', false);
				// set_query_var('event_category', false);

				$query->set('p', $_GET['event_id']);
			}
		}

	}
	*/
}


