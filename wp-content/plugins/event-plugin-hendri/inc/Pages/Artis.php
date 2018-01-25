<?php
/**
 * @package EventPluginHendri
*/
namespace Inc\Pages;

use \Inc\Base\BaseController;
use \Inc\Api\SettingsApi;
use \Inc\Api\Callbacks\AdminCallbacks;


class Artis extends BaseController {

    public $settings;
    public $callbacks;

    public function __construct(){
        $this->settings = new SettingsApi();
        $this->callbacks = new AdminCallbacks();
    }

    public function register(){
         // add_action("admin_menu", array($this, "add_admin_pages"));
         $pages = array(
            //hook from wordpress
            array (
            "page_title"    => "Artis",
            "menu_title"    => "Artis",
            "capability"    => "manage_options",
            "menu_slug"     => "Artis",
            "callback"      => array ($this->callbacks, "artisIndex"),
            "icon_url"      => "dashicons-store",
            "position"      => 10
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
        require_once $this->plugin_path. "templates/artis.php";
    }
}
?>
