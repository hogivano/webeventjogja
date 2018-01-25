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
               "page_title"    => $admin_page["page_title"],
               "menu_title"    => $admin_page["menu_title"],
               "capability"    => $admin_page["capability"],
               "menu_slug"     => $admin_page["menu_slug"],
               "callback"      => $admin_page["callback"]
            )
        );
        $this->admin_subPages = $subPages;

        return $this;
    }

    public function addPages(array $pages){
        $this->admin_pages = $pages;
        return $this;
    }

    public function addSubPages(array $pages){
        $this->admin_subPages = array_merge($this->admin_subPages, $pages);
        return $this;
    }

    public function addAdminMenu(){
        foreach ($this->admin_pages as $page) {
            # code...
            add_menu_page($page["page_title"], $page["menu_title"], $page["capability"], $page["menu_slug"],
                            $page["callback"], $page["icon_url"], $page["position"]);
        }

        foreach ($this->admin_subPages as $page) {
            # code...
            add_submenu_page($page["parent_slug"], $page["page_title"], $page["menu_title"], $page["capability"],
                            $page["menu_slug"], $page["callback"]);
        }
    }
}
