<?php
/**
 * @package EventPluginHendri
*/
namespace Inc\Pages;

use \Inc\Base\BaseController;
use \Inc\Api\SettingsApi;
use \Inc\Api\Callbacks\AdminCallbacks;

class Admin extends BaseController {

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
            "page_title"    => "Event Plugin Hendri",
            "menu_title"    => "EPH",
            "capability"    => "manage_options",
            "menu_slug"     => "event_plugin_hendri",
            "callback"      => array($this->callbacks, "adminIndex"),
            "icon_url"      => "dashicons-store",
            "position"      => 110
            )
        );

        $subPages = array (
            array (
                "parent_slug"   => "event_plugin_hendri",
                "page_title"    => "Semuanya",
                "menu_title"    => "Semua",
                "capability"    => "manage_options",
                "menu_slug"     => "Semuanyaaaa",
                "callback"      => function (){ echo "Ini semua artis";},
            ),
            array (
                "parent_slug"   => "event_plugin_hendri",
                "page_title"    => "add new",
                "menu_title"    => "Add New",
                "capability"    => "manage_options",
                "menu_slug"     => "Add Newwww",
                "callback"      => function (){ echo "Ini tambah baru";},
            )
        );

        $this->settings->addPages($pages)->withSubPages("Dashboard")->addSubPages($subPages)->register();
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
