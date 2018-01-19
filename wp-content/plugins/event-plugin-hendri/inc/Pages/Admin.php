<?php
/**
 * @package EventPluginHendri
*/
namespace Inc\Pages;

use \Inc\Base\BaseController;
use \Inc\Api\SettingsApi;

class Admin extends BaseController {

    public $settings;

    public function __construct(){
        $this->settings = new SettingsApi();
    }

    public function register(){
         // add_action("admin_menu", array($this, "add_admin_pages"));
         $pages = array(
            //hook from wordpress
            array (
            "page_title"    => "Event Plugin Hendri",
            "menu_title"    => "EPH",
            "capability"    => "manage_options",
            "menu_slug"     => "event_plugin_hendri",
            "callback"      => function (){ echo '<h1>Hendriyan Ogivano</h1>';},
            "icon_url"      => "dashicons-store",
            "position"      => 110
            )
        );

        $this->settings->addPages($pages)->register();
    }

    // public function add_admin_pages(){
    //     add_menu_page( "Event Plugin Hendri", "EPH",
    //         "manage_options", "event_plugin_hendri", array($this, "admin_index")
    //         , "dashicons-store", 110);
    // }
    //
    public function admin_index(){
        //use templates
        require_once $this->plugin_path. "templates/admin.php";
    }
}
?>
