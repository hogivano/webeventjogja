<?php
/**
 * @package EventPluginHendri
*/
namespace Inc\Pages;

class Admin {

    public function register(){
         add_action("admin_menu", array($this, "add_admin_pages"));
    }

    public function add_admin_pages(){
        add_menu_page( "Event Plugin Hendri", "EPH",
            "manage_options", "event_plugin_hendri", array($this, "admin_index")
            , "dashicons-store", 110);
    }
    public function admin_index(){
        //use templates
        require_once PLUGIN_PATH . "templates/admin.php";
    }
}
?>
