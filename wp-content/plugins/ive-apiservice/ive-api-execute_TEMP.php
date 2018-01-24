<?php 

// new IVE_API_Execute($_GET);



class IVE_API_Execute
{
	var $method;
	var $post_type;
	var $inputs_param = array();
	var $params = array();
	var $output = array();

	function __construct($input)
	{
		$inputs_param = $input;
		// $params['get'] 				= $this->param('get');

		// $params['post_id'] 			= $this->param('detail_id') ? $this->param('detail_id') : 0;
		// $params['category'] 		= $this->param('category');
		// $params['paged'] 			= $this->param('paged');
		// $params['item_per_page'] 	= $this->param('item_per_page');
		// $params['search'] 			= $this->param('search');
		// $params['active_event'] 	= $this->param('active_event');
		// $params['output'] 			= $this->param('output') ? $this->param('output') : 'json';

		// $params['order'] 			= $this->param('order');
		// $params['orderby'] 			= $this->param('orderby');

		// $params['list_all'] 		= $this->param('list_all');
		// $params['extra'] 			= $this->param('extra');
	}

	function execute()
	{

		$get = $params['get'];

		if( strpos($get, "single_") === 0 ){
			$this->method = "single";
			$this->post_type = str_replace("single_", "", $get);


		} elseif(strpos($get, "list_") === 0) {
			$this->method = "list";
			$this->post_type = str_replace("list_", "", $get);

		} else {
			var_dump("unknown");
		}


	}

	function method_single()
	{
		
	}

	function method_list()
	{
		
	}




	function param($arg)
	{
		return isset( $this->inputs_param[$arg] ) ? $this->inputs_param[$arg] : false;
	}
}