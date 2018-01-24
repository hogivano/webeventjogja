<?php 
/*
Plugin Name: IVE API Service
Plugin URI: http://ivebox.com/project/ive-apiservice
Description: API for Wordpress Query
Version: 1.2
Author: ivebox
Author URI: http://dpopcorn.net/
License: GPLv2 or later
Text Domain: ive-apiservice
*/


require_once( dirname(__FILE__) . "/options.php");
require_once( dirname(__FILE__) . "/functions.php");
require_once( dirname(__FILE__) . "/ive-apiservice-executor.php");
require_once( dirname(__FILE__) . "/ive-apiservice-additional.php");
require_once( dirname(__FILE__) . "/ive-apiservice-notification.php");
// require_once( dirname(__FILE__) . "/ive-api-execute.php");


new IVE_API_Service;

class IVE_API_Service
{
	function __construct()
	{
		add_action( 'admin_menu', array( &$this, 'admin_menu') );

		if( isset( $_GET['api'] )) 
		{
			new IVE_API_Service_Additional;
			add_filter( 'template_include', array( &$this, 'template_include' ), 1, 1 );
		} 

	}

	function admin_menu() 
	{  
		global $IVE_API_Service_Options;

		add_menu_page( 'API Service', 'API Service', 'manage_options', 'ive-api-service', false, 'dashicons-editor-code', 70 );
		add_submenu_page( 'ive-api-service', 'API Setting', 'API Setting', 'manage_options', 'ive-api-setting', array( &$IVE_API_Service_Options, 'option_page'), 1 );

		// add_options_page( 'API Setting', 'API Setting', 'manage_options', 'ive-api-setting', array( &$IVE_API_Service_Options, 'option_page') );
	}

	function template_include( $template_path )
	{
		
		// $this->execute_API();
		$IVE_API_Service_Executor = new IVE_API_Service_Executor;
		$IVE_API_Service_Executor->execute();
		exit();
		return;
		// return $template_path;
	}

}





