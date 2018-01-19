<?php
/**
 * @package EventPluginHendri
*/
namespace Inc\Api;

class SettingsApi{

    public $admin_pages;
    public $admin_subPages;

    public function __construct(){
        $this->admin_pages = array();
        $this->admin_subPages = array();
    }

    public function register(){
        if (! empty($this->admin_pages)) {
            # code...
            add_action( "admin_menu", array($this, "addAdminMenu"));
        }
    }

    public function withSubPages($title){
        if (empty($this->admin_pages)) {
            # code...
            return $this;
        }

        $admin_page = $this->admin_pages[0];
        $subPages = array(
           //hook from wordpress
           array (
               "parent_slug"   => $admin_page["menu_slug"],
               "page_title"    => "Event Plugin Hendri",
               "menu_title"    => "EPH",
               "capability"    => "manage_options",
               "menu_slug"     => "event_plugin_hendri",
               "callback"      => function (){ echo '<h1>Dashboard</h1>';},
               "icon_url"      => "dashicons-store",
               "position"      => 110
            )
        );

        return $subPages;
    }

    public function addPages(array $pages){
        $this->admin_pages = $pages;
        return $this;
    }

    public function addSubPages(array $pages){
        $this->admin_subPages = $pages;
        return $this;
    }

    public function addAdminMenu(){
        foreach ($this->admin_pages as $page) {
            # code...
            add_menu_page($page["page_title"], $page["menu_title"], $page["capability"], $page["menu_slug"],
                            $page["callback"], $page["icon_url"], $page["position"]);
        }
    }
}
